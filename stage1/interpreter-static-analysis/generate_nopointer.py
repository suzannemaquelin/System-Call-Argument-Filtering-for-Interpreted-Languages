import sys

if sys.argv[1] != "0" and sys.argv[1] != "1" and sys.argv[1] != "2":
    print("no valid option is given\n")


with open('./syscallargs.txt', 'r') as file:
    for line in file.readlines():
        syscall = line.split()[0]
        count = 0
        indices = []
        if len(line.split(';')[0].split(" ")) == 1:
            print(str(syscall) + " " + str(count))
            continue
        for i,part in enumerate(line.split(';')[0].split('(')[1].split(',')):
            if "//" in part:
                break
            if sys.argv[1] == "0" and '[' not in part and '...' not in part and '*' not in part and 'fd' not in part \
           		and 'size' not in part and 'len' not in part and 'offset' not in part and 'void' not in part:
                count += 1
                indices.append(i)
            if sys.argv[1] == "1" and '[' not in part and '...' not in part and '*' not in part and 'fd' not in part \
                and 'void' not in part:
                count += 1
                indices.append(i)
            if sys.argv[1] == "2" and '[' not in part and '...' not in part and '*' not in part and 'void' not in part:
                count += 1
                indices.append(i)
        print(str(syscall) + " " + str(count) + " ", end="")
        for i in indices:
            print(str(i), end=",")
        print("")
