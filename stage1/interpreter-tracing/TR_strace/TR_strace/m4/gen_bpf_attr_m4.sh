#!/bin/sh -efu
# Copyright (c) 2018 Dmitry V. Levin <ldv@altlinux.org>
# All rights reserved.
#
# SPDX-License-Identifier: LGPL-2.1-or-later

input=bpf_attr.h
output="${0%/*}"/bpf_attr.m4
exec > "$output"

cat <<EOF
dnl Generated by $0 from $input; do not edit.
AC_DEFUN([st_BPF_ATTR], [dnl
	AC_CHECK_MEMBERS(m4_normalize([
EOF

gawk -f "${0%/*}"/gen_bpf_attr_m4.awk < "$input" | sort -u

cat <<'EOF'
		union bpf_attr.dummy
	]),,, [#include <linux/bpf.h>])
])
EOF
