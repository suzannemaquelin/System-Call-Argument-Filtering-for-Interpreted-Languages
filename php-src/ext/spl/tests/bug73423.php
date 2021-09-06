<?php

class foo implements \RecursiveIterator
  {
    public $foo = [];

    public Function current ()
      {
        return current ($this->foo);
      }

    public Function key ()
      {
        return key ($this->foo);
      }

    public Function next ()
      {
        next ($this->foo);
      }

    public Function rewind ()
      {
        reset ($this->foo);
      }

    public Function valid ()
      {
        return current ($this->foo) !== false;
      }

    public Function getChildren ()
      {
        return current ($this->foo);
      }

    public Function hasChildren ()
      {
        return (bool) count ($this->foo);
      }
  }


class fooIterator extends \RecursiveFilterIterator
  {
    public Function __destruct ()
      {
		eval("class A extends NotExists {}");

        /* CRASH */
      }

    public Function accept ()
      {
        return true;
      }
  }


$foo = new foo ();

$foo->foo[] = new foo ();

foreach (new \RecursiveIteratorIterator (new fooIterator ($foo)) as $bar) ;

?>
