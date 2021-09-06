import sys
import re


dynamic = sys.argv[1]
if sys.argv[1] == "True":
    dynamic = True
elif sys.argv[1] == "False":
    dynamic = False
else:
    print("dynamic is not properly indicated")

map1 = sys.argv[2]
if len(sys.argv) > 3:
    map2 = sys.argv[3]


ignore = ["+++", "---", "system:", "proc_open:", "popen:", "shell_exec:", "pcntl_exec:", "exec:", "passthru:"]


def readable_syscalls():
    """
    Creates conversion dictionary from system call numbers to system call names
    """
    table = "/usr/include/x86_64-linux-gnu/asm/unistd_64.h"
    conversion = {}
    with open(table, 'r') as f:
        for line in f:
            line = line.rstrip().split(" ")
            if len(line) != 3:
                continue
            if line[0] != "#define" or "_NR" not in line[1]:
                continue
            name = line[1][5:]
            nr = line[2]
            conversion[nr] = name
    return conversion


def remove_args_mapping():
    """
    Reads from nopointersyscallargs file to denote in a dictionary the indices of the arguments
    that should be restricted per system call.
    """
    mapping = {}
    with open('./nopointersyscallargs.txt', 'r') as fd:
        for line in fd:
            split = line.split()
            syscall = split[0]
            nr_of_args = int(split[1])
            indices = []
            if nr_of_args:
                for index in split[2].split(','):
                    indices.append(int(index))
            mapping[syscall] = indices
    print(mapping)
    return mapping

def readmapping_static(f, conversion):
    """
    Reads from file the results of the static analysis, it only takes into account
    those arguments that are allowed by remove_args_mapping function.

    f: file name to read static analysis results from
    conversion: mapping from system call numbers to names
    """
    mapping = {}
    remove = remove_args_mapping()
    with open(f, 'r') as fd:
        for line in fd:
            line = line.split(" ",1)
            if len(line) == 0:
                continue
            fn = line[0]
            if fn in ignore:
                continue
            mapping[fn] = {}
            for sc in line[1].split(";;;"):
                if sc == '\n':
                    continue
                syscall = sc.split(":")[0]
                # convert syscall from number to name
                syscall_name = conversion[syscall]
                sca = sc.split(":", 1)[1]
                mapping[fn][syscall_name] = set()
                arg_options = sca.split(",,,")
                for args in arg_options:
                    result = re.search(" *?\((.*)\)", args, flags=re.DOTALL)
                    if result:
                        stripped_args = result.group(1)
                        indices = remove[syscall]
                        reduced_args = ""
                        for index, arg in enumerate(stripped_args.split(", ")[:-1]):
                            if index in indices:
                                reduced_args += arg + ", "
                        if reduced_args != "": mapping[fn][syscall_name].add(reduced_args)
    return mapping


def readmapping_dynamic(f):
    """
    Reads the dynamic analysis results of Saphire (without arguments)
    """
    mapping = {}
    with open(f, 'r') as fd:
        for line in fd:
            line = line.split()
            if len(line) == 0:
                continue
            fn = line[0]
            mapping[fn] = set()
            for sc in line[1:]:
                if sc != "+++" and sc != "---":
                    mapping[fn].add(sc)
    mapping.pop("system:", None)
    mapping.pop("proc_open:", None)
    mapping.pop("popen:", None)
    mapping.pop("shell_exec:", None)
    mapping.pop("pcntl_exec:", None)
    mapping.pop("exec:", None)
    mapping.pop("passthru:", None)
    return mapping


def readmapping_dynamic_args(f):
    """
    Reads results of dynamic analysis with arguments and denotes this in dictionary.
    This function also takes care of converting hexadecimal to decimal
    """
    mapping = {}
    with open(f, 'r') as fd:
        for line in fd:
            line = line.split(" ",1)
            if len(line) == 0:
                continue
            fn = line[0]
            if fn in ignore:
                continue
            mapping[fn] = dict()
            for sc in line[1].split(";;;"):
                if sc == '\n':
                    continue
                syscall_name = sc.split(":")[0]
                # convert syscall from number to name
                sca = sc.split(":", 1)[1]
                mapping[fn][syscall_name] = set()
                args = sca.split(",,,")
                for arg in args:
                    result = re.search(" *?\((.*)\)", arg, flags=re.DOTALL)
                    # if result: mapping[fn][syscall_name].add(result.group(1))
                    if result:
                        result_arg = result.group(1)
                        args_decimal = ""
                        for a in result_arg.split(", "):
                            if "=" in a:
                                a = a.split("=")[1]
                            if "}" in a:
                                a = a.split("}")[0]
                            if "0x" in a and "|" not in a:
                                a_decimal = int(a, 16)
                            elif "|" in a:
                                a_decimal = 0
                                for or_args in a.split("|"):
                                    or_args = int(or_args, 16)
                                    a_decimal = a_decimal | or_args
                            else:
                                a_decimal = a
                            if a != "": args_decimal += str(a_decimal) + ", "
                        mapping[fn][syscall_name].add(args_decimal)
    return mapping


if dynamic:
    map1dict = readmapping_dynamic_args(map1)
    map2dict = {}
else:
    conversion = readable_syscalls()
    map1dict = readmapping_static(map1, conversion)
    map2dict = readmapping_dynamic(map2)


if dynamic or len(sys.argv) > 3:
    for fn, map_sc_arg in map1dict.items():
        if fn not in map2dict:
            for sc, args in map_sc_arg.items():
                for arg in args:
                    print(str(fn) + " " + str(sc) + " " + str(arg))
                if not args:
                    print(str(fn) + " " + str(sc))
    for fn_2, sc_set in map2dict.items():
        if fn_2 in map1dict:
            for sc_2 in sc_set:
                if not sc_2 in map1dict[fn_2]:
                    print(str(fn_2) + " " + str(sc_2))
            for sc, args in map1dict[fn_2].items():
                for arg in args:
                    print(str(fn_2) + " " + str(sc) + " " + str(arg))
                if not args:
                    print(str(fn_2) + " " + str(sc))
else:
    for fn, map_sc_arg in map1dict.items():
        for sc, args in map_sc_arg:
            for arg in args:
                print(str(fn) + " " + str(sc) + " " + str(arg))
            if not args:
                print(str(fn) + " " + str(sc))
