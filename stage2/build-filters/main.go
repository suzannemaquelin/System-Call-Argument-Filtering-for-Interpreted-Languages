package main

import (
	"fmt"
	"os"
	"../db"
)

func main() {
	if len(os.Args) != 2 {
		fmt.Printf("Usage: ./build-filters DB \n")
		os.Exit(0)
	}
	
	dbpath := os.Args[1]

	Db, _ := db.OpenDb(dbpath)

	_, syscallargs  := Db.GetSyscallIdsAndArgsForFile()
	for file, sys_args := range syscallargs {
		fmt.Printf("%s\n", file)
		for syscall, args := range sys_args {
			fmt.Printf(" %d:", syscall)
			for _, arg := range args {
				if (arg != "") {
					fmt.Printf(" %s", arg)
				}
			}
			fmt.Printf("\n")
		}
		fmt.Printf("\n")
	}
}
