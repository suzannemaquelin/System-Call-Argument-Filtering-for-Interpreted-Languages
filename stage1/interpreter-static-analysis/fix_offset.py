import sys
import os

file = open(sys.argv[1], "r")
replacement = ""
offset = 0
zend_offset = 0
objdump = os.popen('objdump -d ' + sys.argv[2]).read()
for line in objdump.splitlines():
    if "<zif_zend_version" in line:
        zend_offset = int(line.split()[0],16)
        break
for index, line in enumerate(file):
    line = line.split()
    if index == 0:
        offset = zend_offset - int(line[1],16)
    if line[0] != "CLASS":
        changes = line[0] + " " +f'{(int(line[1], 16) + offset):x}'
    else:
        changes = line[0] + " " + line[1]
    replacement = replacement + changes + "\n"

file.close()
fout = open(sys.argv[1], "w")
fout.write(replacement)
fout.close()
