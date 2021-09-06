#!/bin/bash
# Usage
if [ $# -lt 1 ]; then
    echo "Usage $0 PATH_TO_OUTPUT"
    exit 1
fi

OUTPATH=$(realpath $1)

#####################################################################
# Parse the traces output by TR to build an initial mapping of PHP function to syscalls
cd ~/stage1/interpreter-tracing/process-traces
go build
cd ..
./process-traces/process-traces /tmp/stage1.tmp/traces/ > /tmp/stage1.tmp/dynamic-syscalls

#####################################################################
# Collect another mapping of PHP functions to syscalls, statically

# Build a simple extension for obtaining binary offsets of PHP API functions
# Write the offsets to a file
cd ~/stage1/interpreter-static-analysis/enum
/opt/php-7.1/bin/phpize
./configure --with-php-config=/opt/php-7.1/bin/php-config
make

cd ~/stage1/interpreter-static-analysis/
/opt/php-7.1/bin/php -d "extension=enum/modules/enum.so" enum/do-enum.php  > /tmp/stage1.tmp/func_to_addr
python3 fix_offset.py /tmp/stage1.tmp/func_to_addr

# Disassemble and analyze the PHP binary and all of its dynamic libraries to collect another mapping of PHP API function to syscalls
pip3 install setuptools 
pip3 install wheel 
pip3 install angr
python3 analyze_interpreter_args.py /tmp/stage1.tmp/func_to_addr /opt/php-7.1/bin/php > /tmp/stage1.tmp/static-syscalls-args

######################################################################
# Convert the list of syscall numbers to readable names. 
# Merge the Dynamically collected mapping with the statically-collected mapping. This is the output of stage 1
cd ~/stage1/interpreter-static-analysis/
python3 util/mergemappings_args.py False /tmp/stage1.tmp/static-syscalls-args /tmp/stage1.tmp/dynamic-syscalls > $OUTPATH

