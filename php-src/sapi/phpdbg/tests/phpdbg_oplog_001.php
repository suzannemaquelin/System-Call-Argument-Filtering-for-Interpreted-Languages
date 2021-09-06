<?php

class A {
  public function b($c = 1) {
    if ($c == 1) {
      // comment
    }
  }
}

phpdbg_start_oplog();

echo "hallo";

// fcalls

$a = new A();
$a->b();
$a->b('ha');

var_dump(phpdbg_end_oplog(["functions" => true]));
