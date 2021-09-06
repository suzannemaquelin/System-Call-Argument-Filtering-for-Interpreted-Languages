package main

import (
	"bufio"
	"fmt"
	"os"
	"../db"
	"strings"
	"strconv"
)

func isElementExist(s []string, str string) bool {
  for _, v := range s {
    if v == str {
      return true
    }
  }
  return false
}

func main() {
	if len(os.Args) != 4 {
		fmt.Printf("Usage: ./register-functions DB FUNC_SC_FILE MODE \n")
		os.Exit(0)
	}

	dbpath := os.Args[1]
	path := os.Args[2]
	mode := os.Args[3]

	Db, err := db.OpenDb(dbpath)
	file, err := os.Open(path)
	if err != nil {
		panic(err)
	}
	defer file.Close()

	tx, err := Db.Begin()
	scanner := bufio.NewScanner(file)
	var function_names []string
	for scanner.Scan() {
		function := strings.Fields(scanner.Text())
		if len(function) > 1 {
			function_name := function[0][0:(len(function[0]) - 1)]
			if !isElementExist(function_names, function_name) {
				tx.CreateFunction(function_name)
				function_names = append(function_names, function_name)
			}
			sc := function[1]
			arguments := ""
			for _,argument := range function[2:] {
				arguments = arguments + argument
			}
			if mode == "names" {
				err = tx.CreateSyscallArgsRequirement(function_name, sc, arguments)
				if err != nil {
					panic(err)
				}
			} else {
				syscallnr, err := strconv.Atoi(sc)
				if err != nil {
					panic(err)
				}
				err = tx.CreateSyscallArgsRequirementFromSyscallNr(function_name, syscallnr, arguments)
				if err != nil {
					panic(err)
				}
			}
		}
	}
	err = tx.Commit()
}