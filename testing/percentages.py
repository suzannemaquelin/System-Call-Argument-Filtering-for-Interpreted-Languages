import os
import sys

static_analysis = sys.argv[1]
nopointerargs = sys.argv[2]
if len(sys.argv) > 3:
    application = sys.argv[3]

def getArgumentNumbers():
    args_per_syscall = dict()
    with open(nopointerargs, 'r') as fd:
        for syscall in fd:
            split = syscall.split()
            syscall_nr = split[0]
            nr_arguments = split[1]
            args_per_syscall[syscall_nr] = nr_arguments
    return args_per_syscall


def percentagePerAPI():
    args_per_syscall = getArgumentNumbers()
    percentage_api = []
    with open(static_analysis, 'r') as f:
        for call_nr, line in enumerate(f):
            if ":" not in line: continue
            syscalls = line.split(" ", 1)[1]
            total_arguments = 0
            total_found_arguments = 0
            for syscall in syscalls.split(";;;")[:-1]:
                syscall_number = syscall.split(':')[0]
                nr_arguments = int(args_per_syscall[syscall_number])
                total_arguments += nr_arguments
                if not nr_arguments: continue
                if "(" in syscall:
                    indices = set()
                    for arg_combi in syscall.split(",,,")[:-1]:
                        for index, arg in enumerate(arg_combi.split(",")[:-1]):
                            if not "UNINITIALIZED" in arg:
                                indices.add(index)
                    found_arguments = len(indices)
                else:
                    found_arguments = 0
                total_found_arguments += found_arguments
            if total_arguments: percentage_api.append(total_found_arguments / total_arguments * 100)
        mean = sum(percentage_api) / len(percentage_api)
        print("mean percentage per API is " + str(mean))

def percentageAllAPI():
    args_per_syscall = getArgumentNumbers()
    percentage_api = []
    with open(static_analysis, 'r') as f:
        total_arguments = 0
        total_found_arguments = 0
        for call_nr, line in enumerate(f):
            if ":" not in line: continue
            syscalls = line.split(" ", 1)[1]
            for syscall in syscalls.split(";;;")[:-1]:
                syscall_number = syscall.split(':')[0]
                nr_arguments = int(args_per_syscall[syscall_number])
                total_arguments += nr_arguments
                if not nr_arguments: continue
                if "(" in syscall:
                    indices = set()
                    for arg_combi in syscall.split(",,,")[:-1]:
                        for index, arg in enumerate(arg_combi.split(",")[:-1]):
                            if not "UNINITIALIZED" in arg:
                                indices.add(index)
                    found_arguments = len(indices)
                else:
                    found_arguments = 0
                total_found_arguments += found_arguments
        percentage = (total_found_arguments / total_arguments) * 100
        print("percentage over all APIs is " + str(percentage))


def percentagePerScript():
    args_per_syscall = getArgumentNumbers()
    percentage_script = []
    with open(application, 'r') as fd:
        for line in fd:
            if line[0] == "/":
                total_found_arguments = 0
                total_arguments = 0
            elif line[0] == " ":
                split = line.split()
                syscall_number = split[0].split(":")[0]
                if len(split) > 1:
                    # arguments
                    indices = set()
                    for arg_combi in split[1:]:
                        for index, arg in enumerate(arg_combi.split(",")[:-1]):
                            if not "UNINITIALIZED" in arg:
                                indices.add(index)
                    found_arguments = len(indices)
                else:
                    found_arguments = 0
                nr_arguments = int(args_per_syscall[syscall_number])
                total_arguments += nr_arguments
                total_found_arguments += found_arguments
            else:
                continue
            if total_arguments: percentage_script.append((total_found_arguments / total_arguments) * 100)
        mean = sum(percentage_script) / len(percentage_script)
        print("mean percentage per script is " + str(mean))

def percentageAllScript():
    args_per_syscall = getArgumentNumbers()
    percentage_script = []
    with open(application, 'r') as fd:
        total_found_arguments = 0
        total_arguments = 0
        for line in fd:
            if line[0] == " ":
                split = line.split()
                syscall_number = split[0].split(":")[0]
                if len(split) > 1:
                    # arguments
                    indices = set()
                    for arg_combi in split[1:]:
                        for index, arg in enumerate(arg_combi.split(",")[:-1]):
                            if not "UNINITIALIZED" in arg:
                                indices.add(index)
                    found_arguments = len(indices)
                else:
                    found_arguments = 0
                nr_arguments = int(args_per_syscall[syscall_number])
                total_arguments += nr_arguments
                total_found_arguments += found_arguments
            else:
                continue
        percentage = (total_found_arguments / total_arguments) * 100
        print("percentage over all scripts is " + str(percentage))


percentagePerAPI()
percentageAllAPI()
if len(sys.argv) > 3:
    print("For the application: " + str(application))
    percentagePerScript()
    percentageAllScript()

# python3 percentages.py /home/suzanne/Documents/saphire-main/testing/static_analysis/static-analysis /home/suzanne/Documents/saphire-main/stage1/interpreter-static-analysis/nopointersyscallargs.txt