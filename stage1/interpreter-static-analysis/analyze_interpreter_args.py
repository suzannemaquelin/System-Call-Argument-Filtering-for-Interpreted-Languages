"""
Original code by BUseclab can be found on https://github.com/BUseclab/saphire
Modified and extended by Suzanne Maquelin
"""

# First Argument:  Table mapping php api to binary address. Use the extension to get this
# Second Argument: objdump of php binary
# Third Argument: maximum length of path
# Fourth Argument: depth of symbolic execution

import sys
import os
import re
import copy
import gc
from subprocess import Popen, PIPE, STDOUT
import angr
from angr import options

php_sources = {}
ctxs = {}
cached = {}
binds = {}

ignore=[
    "lea", "mov", "cmpq", "movl", "cmpb", "pushq", "movq", "test", "cmpl", "movb", "movdqa", "cmp",
    "movdqu", "movsd", "movslq", "movswq", "movups", "movzbl", "movzwl", "mulsd", "orl", "sub",
    "subl", "subsd", "testb", "ucomisd", "xor", "xorpd", "cmove", "cvtsi2s", "divsd", "cmovne",
    "add", "addsd", "andpd"
]

excluded_paths = [
    [50530064, 50529184, 50259920, 50259991],
    [50530064, 50242640, 50242706],
    [50517968, 50516912, 50531696, 50530736, 50244416, 50244434],
    [50438672, 49479872, 49479488, 50242800, 50242869],
    [9866766, 11590554, 11590343, 5705872, 50379872, 50439072, 50438416, 49479872, 49479488, 50242800, 50242869],
    [50519968, 50518112, 50531696, 50530736, 50529184, 50259920, 50259991],
]

libaliases = [f for f in os.listdir("libs/") if os.path.isfile(os.path.join("libs/", f))]
logLevel = 6

def log(m, level):
    if level >= logLevel:
        print(m)


class StaticAnalysis:
    counter = {
        "avoid": 0,
        "cut": 0,
        "deadended": 0,
        "found": 0,
        "error": 0,
        "recovered": 0,
        "nr_registers": 0,
        "uninitialized": 0,
    }
    syscalls_cntr = 0
    found_cntr = 0
    syscall_args_indices = {}
    func_addresses = {}
    visited_paths = {}
    angr_project = None
    exploration_length = 300
    depth = 2
    max_distance = 240
    graph_reversed = {}
    called_by_api = {}


class ctx:
    graph = set()
    sym2addr = {}
    addr2sym = {}
    addr2syscall = {}
    addr_syscall2args = {}
    offsets = {}

    def __init__(self):
        self.graph = set()
        self.sym2addr = {}
        self.addr2sym = {}
        self.addr2syscall = {}
        self.addr_syscall2args = {}
        self.function_info = {}


def ldd(f):
    files = []
    out = os.popen('ldd '+ f).read()
    for l in out.splitlines():
        l = l.replace("=>",'^')
        l = l.split('^')
        if len(l) > 1:
            files.append(l[1].split()[0])
    return files


def readelf(f, c):
    out = os.popen('readelf -s '+f).read()
    for line in out.splitlines():
        line = line.split()
        if len(line) !=8 or line[0]=="Num:":
            continue
        addr = int(line[1], 16)
        if addr != 0:
            addsym(c, line[7], addr)


def addsym(g, sym, addr):
    if "+"in sym:
        name = sym.split('+')[0]
        g.offsets[addr]=sym
    if addr not in g.addr2sym:
        g.addr2sym[addr]=set()
    g.addr2sym[addr].add(sym)
    if sym not in g.sym2addr:
        g.sym2addr[sym]=addr


def bindings(f):
    dump = f.splitlines()
    for line in dump:
        if "binding file" not in line:
            continue
        result = 0
        result = re.search('\] to (.*) \[.*\]:.*`(.*)\'\s*\[(.*)\]', line)
        if result:
            origin = result.group(1)
            sym = result.group(2)
            loc = result.group(3)
        else:
            result = re.search('\] to (.*) \[.*\]:.*`(.*)\'', line)
            origin = result.group(1)
            sym = result.group(2)
            loc = ""
        binds[(sym, loc)] =  origin


def syscall_args_to_dict():
    """
    Parse the system call arguments file to a dictionary structure
    """
    syscall_args_file = open("syscallargs.txt", "r")
    content = syscall_args_file.readlines()
    for line in content:
        indices = []
        result = re.search('.+? ', line)
        if result is not None:
            syscall_nr = result.group(0)[:-1]
            result = re.search(r'\(.+?\);',line)
            if result is None:
                continue
            result = result.group(0)
            arg_list = result.split(",")
            for index, arg in enumerate(arg_list):
                if "*" not in arg and "[" not in arg and "..." and "void" not in arg:
                    indices.append(index)
        else:
            syscall_nr = line
        StaticAnalysis.syscall_args_indices[int(syscall_nr)] = indices


def cfg(f, subg, binary):
    """
    Additional functionality:
    * Store the function addresses encountered
    * Additional graph which creates edges from called function to callee address
    """
    g = ctx()
    func_addr = ""
    func_name =""

    dump = f.splitlines()
    lines = []

    count = 1
    while count !=0 :
        count = 0
        for line in dump:
            start_func = None
            lines.append(line)
            if '<' in line and line.rstrip()[-1] == ':':
                if func_addr != "": start_func = func_addr
                line = line.split()
                func_addr = int(line[0], 16)
                if start_func: g.function_info[start_func] = func_addr
                if binary not in StaticAnalysis.func_addresses:
                    StaticAnalysis.func_addresses[binary] = set()
                StaticAnalysis.func_addresses[binary].add(func_addr)
                func_name = line[1]
                result = re.search('<(.*)>', func_name)
                func_name = result.group(1)
                addsym(g, func_name, func_addr)

            else:
                # Check for syscalls
                if "%eax" in line or "%rax" in line:
                    eax = line
                elif len(line.split())>0:
                    if (line.split())[-1]=="syscall":
                        if "syscall" in func_name:
                            pass
                        else:
                            syscall_addr = int(line.split()[0][:-1], 16)
                            if func_addr not in g.addr2syscall:
                                g.addr2syscall[func_addr]=set()
                            src=0
                            if "xor    %eax,%eax" in eax:
                                src = "$0"
                            else:
                                result = re.search('mov\s*(.*),.*', eax)
                                if result is not None:
                                    src=result.group(1)
                                else:
                                    src='-1'
                            if src[0]=="%" or src[0:2]=="(%":
                                if src[0] == "(":
                                    src = src[1:len(src)-1]
                                i=0
                                while True:
                                    i-=1
                                    if "xor    "+src+","+src in lines[i]:
                                        g.addr2syscall[func_addr].add((0, syscall_addr))
                                        break
                                    result = re.search('mov\s*(.*),'+src, lines[i])
                                    if result is not None:
                                        try:
                                            res = int(result.group(1)[1:], 16)
                                            g.addr2syscall[func_addr].add((res, syscall_addr))
                                        except:
                                            pass
                                        break
                            elif src != '-1':
                                g.addr2syscall[func_addr].add((int(src[1:], 16), syscall_addr))

                # Check for calls
                if '<' in line:
                    if subg != None and func_addr not in subg:
                        continue
                    cont = 1
                    for w in line.split():
                        if w in ignore:
                            cont = 0
                    if cont == 0:
                        continue
                    line_copy = line
                    line_addr = int(line.split(":")[0], 16)
                    result = re.search('([a-f,0-9]*\ <.*>)', line)
                    line = result.group(1)
                    line = line.split()
                    addr = int(line[0], 16)
                    name = line[1]
                    result = re.search('<(.*)>', name)
                    name = result.group(1)
                    if "#" in line_copy:
                        addr_rev = name
                    else:
                        addr_rev = addr
                    if func_name!=name:
                        skip = False
                        if len(name) >= len(func_name):
                            if name[0:len(func_name)]==func_name:
                                if func_name+'+' in name:
                                    skip = True
                        if ".plt.got" in func_name:
                            g.graph.add((line_addr, addr))
                            addsym(g, name, addr)
                            if "+"in name: name = name.split('+')[0]
                            if name not in StaticAnalysis.graph_reversed: StaticAnalysis.graph_reversed[name] = set()
                            StaticAnalysis.graph_reversed[name].add((addr_rev, line_addr, func_addr, binary))
                        elif not skip and (func_addr, addr) not in g.graph:
                            if subg is not None:
                                subg.add(addr)
                            g.graph.add((func_addr, addr))
                            addsym(g, name, addr)
                            if "+"in name: name = name.split('+')[0]
                            if name not in StaticAnalysis.graph_reversed: StaticAnalysis.graph_reversed[name] = set()
                            StaticAnalysis.graph_reversed[name].add((addr_rev, line_addr, func_addr, binary))
                            count+=1
    return g


def resolve_offsets(g):
    skip = "_init@"
    for o, sym in g.offsets.items():
        if sym[0:len(skip)] == skip:
            continue
        addr = 0
        shortsym = sym.split('+')[0]
        if shortsym in g.sym2addr:
            addr = g.sym2addr[shortsym]
            log("Resolved " + sym + " to " + str(g.addr2sym[addr]), 0)
            g.graph.add((o,addr))


def load_php_api(f):
    subg = set()
    classname = None
    with open(f, 'r') as fp:
        line = fp.readline()
        while line:
            line = line.split()
            if line[0] == 'CLASS':
                classname = line[1]
            else:
                addr = int(line[1], 16)
                if addr not in php_sources:
                    php_sources[addr] = set()
                if classname:
                    php_sources[addr].add(classname+"::"+line[0])
                else:
                    php_sources[addr].add(line[0])
                subg.add(addr)
            line = fp.readline()
    return subg


def sym_name(ctx, addr):
    if addr in ctx.addr2sym:
        for i in ctx.addr2sym[addr]:
            return i
    else:
        return str(hex(addr))


def dfs(path, done, api):
    """
    Additional functionality: per api call the visited functions are documented
    """
    guard = [True, True]
    source = path[-1][0]
    f = path[-1][1]

    if path[-1] in cached:
        log("cached: " + sym_name(ctxs[f],source) + " = " + str(cached[path[-1]][0]), 0)
        StaticAnalysis.called_by_api[api] = cached[path[-1]][1]
        return cached[path[-1]][0]

    # Check whether there are any syscalls in latest node
    syscalls = set()
    # Check for neightbors within the same binary
    count = 0   # How many new edges within the same binary
    for edge in ctxs[f].graph:
        if edge[0] == source and (edge[1], f) not in path and(path[-1], (edge[1], f)) not in done :
            count += 1
            done.add((path[-1], (edge[1], f)))
            ss = dfs(path + [(edge[1], f)], done, api)
            log("\""+sym_name(ctxs[f],source)+"@"+f+"\" -> \""+ sym_name(ctxs[f],edge[1])+"@"+f+"\"", 2)
            syscalls |= ss
            StaticAnalysis.called_by_api[api].add((source,f))
            guard[0] = False

    # Check for neightbors within other binaries
    if count == 0:
        if source in ctxs[f].addr2sym:
            sym = ""
            syms = ctxs[f].addr2sym[source]
            ss = ""
            for s in syms:
                ss = s
                s = s.split('@')
                if len(s)>1:
                    s=(s[0], s[-1])
                else:
                    s=(s[0], "")
                if s in binds:
                    sym = s
                    break

            if sym in binds:
                ff = os.path.basename(binds[sym])
                if ff in ctxs:
                    c = ctxs[ff]
                    for sym in ctxs[f].addr2sym[source]:
                        for s in [sym, sym.replace('@', '@@')]:
                            if s in c.sym2addr:
                                caddr = c.sym2addr[s]
                                if (caddr, ff) not in path and (path[-1], (caddr, ff)) not in done:
                                    done.add((path[-1], (caddr, ff)))
                                    ss = dfs(path + [(caddr, ff)], done, api)
                                    if ff != "libc.so.6": log("\""+sym_name(ctxs[f],source)+"@"+f+"\" -> \""+ sym_name(c,caddr)+"@"+ff+"\"", 2)
                                    syscalls |= ss
                                    StaticAnalysis.called_by_api[api].add((source,f))
                                    guard[1] = False
    if source in ctxs[f].addr2syscall:
        syscalls |= ctxs[f].addr2syscall[source]
    syscalls.discard(59)
    log("For " + sym_name(ctxs[f],source) + " caching: " + str(syscalls), 1)
    cached[path[-1]] = (syscalls, StaticAnalysis.called_by_api[api])
    return syscalls


class APICtx:
    """
    Class context per API function in the interpreter. Keeps track of syscall paths and syscall args per API.
    Provides functionality for static analysis using angr.
    """

    def __init__(self, api):
        self.syscall_paths = {}
        self.api = api
        self.syscall_args = {}
        self.min_memory = 1500
        self.stop_memory=300


    def parse_register(self, register):
        """
        Parses angr output to only contain value in register
        """
        result = re.search(r"\s(.*)>", str(register))
        if result:
            register_value = result.group(1)
        else:
            register_value = str(register)
        return register_value


    def recursion_symbolic_execution(self, syscall, state, address_list, path, result):
        """
        Recursive function which does part of the symbolic execution. It takes the first entry in the address_list to be the start address
        and the second to be the goal.
        When the goal is found, either no addresses remained and the system call was found, or a new part of the symbolic execution is started
        where the found state will be inputted in the next round.
        When the goal is not found, execution is stopped and the error/cut/avoid is counted.

        Arguments:
        syscall: system call to be found, used to get the number of arguments.
        state: starting state for symbolic execution
        address_list: remaining addresses that should be used for symbolic execution
        """
        registers = ["rdi", "rsi", "rdx", "r10", "r8", "r9"]
        simgr = StaticAnalysis.angr_project.factory.simulation_manager(state)
        simgr.active[0].regs.fs = simgr.active[0].regs.rax
        limiter = angr.exploration_techniques.LengthLimiter(max_length=StaticAnalysis.exploration_length)
        watcher = angr.exploration_techniques.MemoryWatcher(min_memory=self.min_memory)
        simgr.use_technique(limiter)
        simgr.use_technique(watcher)

        def prevent_path_explosion(simgr):
            """
            Stops the simulation manager when there are over 30 active states.
            """
            return len(simgr.active) > 30


        output = simgr.explore(find=address_list[0], avoid=[0x0, 0x2f5e7f0, 0x2f854c0], until=prevent_path_explosion)
        output = str(output)

        # Count number of problematic cases and investigate
        if "errored" in output:
            StaticAnalysis.counter["error"] += 1
        if "cut" in output:
            StaticAnalysis.counter["cut"] += 1
        if "deadended" in output:
            StaticAnalysis.counter["deadended"] += 1
        if "avoid" in output:
            StaticAnalysis.counter["avoid"] += 1
        if "unconstrained" in output and "found" not in output:
            result = "unconstrained"
        if "lowmem" in output and self.min_memory > self.stop_memory:
            self.min_memory -= 10

        # Rest of functionality
        if "found" in output:
            StaticAnalysis.counter["found"] += 1
            l = output.split()
            index = [idx for idx, s in enumerate(l) if 'found' in s][0]
            nr_found = int(l[index-1])
            for i in range(nr_found):
                if len(address_list) <= 1:
                    args_indices = StaticAnalysis.syscall_args_indices[syscall]
                    if len(args_indices) > 0:
                        StaticAnalysis.counter["recovered"] += 1
                        register_values = []
                        uninitialized = 0
                        for index in args_indices:
                            register = registers[index]
                            register_value = getattr(simgr.found[i].regs, register)
                            if "UNINITIALIZED" in str(register_value):
                                register_value = "UNINITIALIZED"
                                uninitialized += 1
                            register_values.append(self.parse_register(str(register_value)))
                            StaticAnalysis.counter["nr_registers"] += 1
                        if syscall not in self.syscall_args: self.syscall_args[syscall] = []
                        StaticAnalysis.visited_paths[tuple(path)][0] = register_values
                        if uninitialized == len(args_indices):
                            result = "uninitialized"
                        else:
                            result = register_values
                else:
                    try:
                        state = copy.deepcopy(simgr.found[i])
                        result = self.recursion_symbolic_execution(syscall, state, address_list[1:], path, result)
                    except Exception:
                        print("Exception" + str(Exception))
        del simgr
        del state
        gc.collect()
        return result



    def symbolic_execution(self, address_list, syscall):
        """
        The first state is created which has a number of options to start memory and registers symbolic and 
        to have resilience during the symbolic execution so it will not halt at unfamiliar operations or expressions.

        Arguments:
        address_list: addresses to guide the symbolic execution to the system call
        syscall: system call we need to find
        """
        StaticAnalysis.syscalls_cntr += 1
        state = StaticAnalysis.angr_project.factory.blank_state(
            addr=address_list[0],
            add_options={
                options.BYPASS_UNSUPPORTED_IROP,
                options.BYPASS_UNSUPPORTED_IREXPR,
                options.BYPASS_UNSUPPORTED_IRSTMT,
                options.BYPASS_UNSUPPORTED_IRDIRTY,
                options.BYPASS_UNSUPPORTED_IRCCALL,
                options.BYPASS_ERRORED_IRCCALL,
                options.BYPASS_UNSUPPORTED_SYSCALL,
                options.BYPASS_ERRORED_IROP,
                options.BYPASS_VERITESTING_EXCEPTIONS,
                options.BYPASS_ERRORED_IRSTMT,
                options.SYMBOL_FILL_UNCONSTRAINED_REGISTERS,
                options.SYMBOL_FILL_UNCONSTRAINED_MEMORY,
            }
        )
        with open("/tmp/paths", "a") as f:
            f.write(str(address_list))
        return self.recursion_symbolic_execution(syscall, state, address_list[1:], address_list, "")


    def start_argument_analysis(self):
        """
        For each syscall in the functions called by the api function, starts to determine paths for symbolic execution

        Arguments:
        api: address of the api function for which we want to do symbolic execution
        ctxs: class objects which keep information retrieved during cfg functione execution per api function
        """
        counter = 0
        for (func, binary) in StaticAnalysis.called_by_api[self.api]:
            if func in ctxs[binary].addr2syscall:
                for (syscall_nr, addr) in ctxs[binary].addr2syscall[func]:
                    counter += 1
                    if addr not in self.syscall_paths:
                        self.syscall_paths[addr] = []
                    self.create_new_paths([self.add_base(addr,binary)], syscall_nr, addr, binary, func)

    def start_execution(self, paths, syscall_nr, elements):
        """
        Starts symbolic execution and determines on its output whether a path extension is required

        Arguments:
        paths: list of paths to do symbolic exectuion on
        syscall_nr: system call number of system call at root of paths
        elements: extra information on path elements needed for path extension
        """
        nr_args = len(StaticAnalysis.syscall_args_indices[syscall_nr])
        uninitialized = ["UNINITIALIZED"] * nr_args

        def find_all_parents(path, paths):
            """
            Extends selected paths
            """
            selected_indices = [index_2 for (index_2, path_2) in enumerate(paths) if path_2 == path]
            for index in selected_indices:
                element = elements[index]
                self.create_new_paths(path, syscall_nr, element[1], element[3], element[2])

        if syscall_nr not in self.syscall_args:
            self.syscall_args[syscall_nr] = []
        results = []

        # for each path not yet visited, start symbolic execution or append the appropriate result
        for (index, path) in enumerate(paths):
            if path in excluded_paths or (len(path) == 6 and path[:5] == [50519968, 50518112, 50531696, 50530736, 50244416]) or \
                (len(path) > 3 and path[len(path) - 4:] == [49479872, 49479488, 50242800, 50242818]) or \
                (len(path) > 3 and path[len(path) - 4:] == [49479872, 49479488, 50242800, 50242869]):
                continue
            if tuple(path) not in StaticAnalysis.visited_paths:
                StaticAnalysis.visited_paths[tuple(path)] = [None, None]
                old_length = len(self.syscall_args[syscall_nr])
                result = self.symbolic_execution(path, syscall_nr)
                results.append(result)
            elif StaticAnalysis.visited_paths[tuple(path)][1] and len(path) <= StaticAnalysis.depth:
                results.append("unconstrained")
            else:
                if syscall_nr not in self.syscall_args:
                    self.syscall_args[syscall_nr] = []
                output = StaticAnalysis.visited_paths[tuple(path)][0]
                if output and uninitialized != [str(a) for a in output]:
                    results.append(output)
                else:
                    results.append("uninitialized")

        # determine whether another round of symbolic execution is appropriate
        if "uninitialized" in results or "unconstrained" in results:
            if len(paths[0]) > StaticAnalysis.depth:
                self.syscall_args[syscall_nr].append(uninitialized)
            else:
                for index, result in enumerate(results):
                    if result in ("uninitialized", "unconstrained"):
                        find_all_parents(paths[index], paths)
                    else:
                        self.syscall_args[syscall_nr].append(result)
        else:
            self.syscall_args[syscall_nr].extend(results)


    def create_new_paths(self, path, syscall_nr, addr, binary, func):
        """
        Obtains the elements for path extension, creates new paths by extending the existing path,
        and keeps the elements information as well.

        path: path to be extended
        syscall_nr: system call number of system call at end of path
        addr: address to pass on to next function
        binary: binary to pass on to next function
        func: function to pass on to next function
        """
        elements = self.dfs_reversed_one_level(addr, binary, func)
        paths_new = []
        for element in elements:
            path_new = copy.deepcopy(path)
            path_new.insert(0, self.add_base(element[0], binary))
            paths_new.append(path_new)
        self.start_execution(paths_new, syscall_nr, elements)


    def dfs_reversed_one_level(self, addr, binary, func):
        """
        Reverses the graph one step to determine all appropriate paths leading to the address.
        A path is appropriate when the called address is smaller than the required address,
        the difference between the called address and the required address is at most max_distance,
        and the callee address lies within the api reachability.
        Returns the appropriate addresses, with binary and function information

        Arguments:
        addr: required address
        binary: binary of required address
        func: function of required address
        """
        func_name = ctxs[binary].addr2sym[func]
        elements = set()
        for f in func_name:
            if "@@" in f:
                f_sub = re.sub("@@", "@", f)
                elements |= (StaticAnalysis.graph_reversed).get(f_sub, set())
            elements |= (StaticAnalysis.graph_reversed).get(f, set())

        possible_paths = []
        for element in elements:
            start = element[0]
            if type(start) == str:
                start = self.deduce_start_addr(start, binary)
            if start <= addr and start > (addr-StaticAnalysis.max_distance) and \
                element[2] in [v[0] for v in StaticAnalysis.called_by_api[self.api]]:
                possible_paths.append((start, element[1], element[2], element[3]))
        return possible_paths


    def deduce_start_addr(self, start, binary):
        """
        start address is of type string when it refers to another binary file.

        Arguments:
        start: address to be translated from string to integer
        binary: look up the address in this binary
        ctxs: class objects which keep information retrieved during cfg functione execution
            per api function
        """
        if "+" in start:
            start_split = start.split("+")
            offset = start_split[1]
            start = start_split[0]
        else:
            offset = "0"
        if "@@" not in start:
            name = re.sub("@", "@@", start)
        else:
            name = start
        start = ctxs[binary].sym2addr[name] + int(offset,16)
        return start


    def add_base(self, addr, binary):
        """
        Given an address and a binary, compute the address it will have in the angr project.
        """
        obj = StaticAnalysis.angr_project.loader.shared_objects[binary]
        base_address = obj.mapped_base
        return int(hex(base_address + addr),16)


    def compute_restriction(self, syscalls):
        """
        Combines information obtained in symbolic execution to determine which arguments per syscall per api
        will be restricted.
        """
        for syscall_nr in set([s[0] for s in syscalls]):
            args = set(tuple(args) for args in self.syscall_args.get(syscall_nr, []))
            args.discard('')
            args.discard(())
            print(f"{syscall_nr}: ", end="")
            nr_args = len(StaticAnalysis.syscall_args_indices[syscall_nr])
            uninitialized = ["UNINITIALIZED"] * nr_args
            if args and uninitialized not in [[str(a) for a in arg] for arg in args]:
                # syscall arguments can be (partly) restricted
                initialized = set(range(nr_args))
                for arg in args:
                    initialized = initialized.intersection([index for index, a in enumerate(arg) if str(a) != "UNINITIALIZED"])
                    print("(", end="")
                    for index, a in enumerate(arg):
                        if index in initialized:
                            print(int(a, 0), end=", ")
                        else:
                            print("UNINITIALIZED", end=", ")
                    print("),,, ", end="")
            print(";;;", end="")


def main():
    if len(sys.argv) > 3:
        StaticAnalysis.exploration_length = int(sys.argv[3])
        StaticAnalysis.depth = int(sys.argv[4])
        StaticAnalysis.max_distance = int(sys.argv[5])
    subg = load_php_api(sys.argv[1])
    syscall_args_to_dict()

    php_bin = sys.argv[2]
    libs = ldd(php_bin)

    # Bindings
    output = Popen(
        "LD_DEBUG=bindings " + php_bin +  " /dev/null",
        shell=True,
        stdout=PIPE,
        close_fds=True,
        stderr=STDOUT,
    ).stdout.read().decode("utf-8")
    bindings(output)

    output = os.popen('objdump -d ' + sys.argv[2]).read()
    StaticAnalysis.angr_project = angr.Project(
        sys.argv[2],
        use_sim_procedures=False,
        ld_path = ["./libs/"],
    )
    ctxs[os.path.basename(php_bin)] = cfg(output, None, os.path.basename(php_bin))
    resolve_offsets(ctxs[os.path.basename(php_bin)])
    for l in libs:
        lalias = l
        l_b = os.path.basename(l)
        if l_b in libaliases:
            lalias = "./libs/" + l_b
        log(l, 1)
        output = os.popen('objdump -d ' + lalias).read()
        ctxs[l_b]=cfg(output, None, l_b)
        resolve_offsets(ctxs[l_b])
        log(ctxs[l_b].addr2syscall, 1)
        readelf(l, ctxs[l_b])

    php_bin_b = os.path.basename(php_bin)

    for n in php_sources:
        api_context = APICtx(n)
        log(f"================= {php_sources[n]} ==================", 1)
        origins = set()
        for alias in php_sources[n]:
            if "zif_" + alias  in ctxs[php_bin_b].sym2addr:
                origins.add((ctxs[php_bin_b].sym2addr["zif_" + alias], php_bin_b))
            if "php_if_" + alias  in ctxs[php_bin_b].sym2addr:
                origins.add((ctxs[php_bin_b].sym2addr["php_if_" + alias], php_bin_b))
        origins.add((n, php_bin_b))
        StaticAnalysis.called_by_api[n] = set()
        scs = dfs(list(origins), set([]), n)
        api_context.start_argument_analysis()
        for s in php_sources[n]:
            print(s, end=': ')
            api_context.compute_restriction(scs)
            print()

if __name__ == "__main__":
    main()