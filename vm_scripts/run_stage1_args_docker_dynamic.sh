#!/bin/bash
# Usage
if [ $# -lt 1 ]; then
    echo "Usage $0 PATH_TO_OUTPUT"
    exit 1
fi

OUTPATH=$(realpath $1)

#####################################################################
# Parse the traces output by TR to build an initial mapping of PHP function to syscalls
cd ~/stage1/interpreter-tracing/process-traces-args
go build
cd ..
./process-traces-args/process-traces-args /tmp/stage1.tmp/traces/ > /tmp/stage1.tmp/dynamic-syscalls-args

#####################################################################
# Process arguments. This is the output of stage 1
cd ~/stage1/interpreter-static-analysis/
python3 util/mergemappings_args.py True /tmp/stage1.tmp/dynamic-syscalls-args > $OUTPATH