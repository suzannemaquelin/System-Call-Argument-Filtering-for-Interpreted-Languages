#!/bin/bash

file1=syscalls.txt
file2=syscallargs.txt
rm -f $file1
rm -f $file2

# Read system calls from file /usr/include/x86_64-linux-gnu/asm/unistd_64.h
while read line; do echo $line | grep -oP '#define __NR_\K.*' >> $file1; done < /usr/include/x86_64-linux-gnu/asm/unistd_64.h

# For each syste call, parse the man page to determine the system call arguments
while read line; do NAME=`echo $line | grep -oP ".*?(?= )"`; NR=`echo $line | \
	grep -oP " .*"`; TEST=`man $NAME.2 | pcregrep -oM "SYNOPSIS\n(.*\n)*DESCRIPTION"`;\
	TEST=$(sed 's|/\*|//|g' <<< $TEST); TEST=$(sed 's|\*/|//|g' <<< $TEST); TEST2=`echo $TEST | \
	pcregrep -o "[ *_]\K$NAME\([^)]+?\)(?>;)"`; echo $NR $TEST2 >> $file2; done < $file1
