--TEST--
Test chunk_split() function : usage variations - different double quoted values for 'str' argument
--FILE--
<?php
/* Prototype  : string chunk_split(string $str [, int $chunklen [, string $ending]])
 * Description: Returns split line
 * Source code: ext/standard/string.c
 * Alias to functions: none
*/

/*
* Passing different double quoted strings for 'str' argument to chunk_split()
* here 'chunklen' is set to 5 and 'ending' is "????"
*/

echo "*** Testing chunk_split() : with different double quoted values for 'str' argument ***\n";

// Initializing variables
$chunklen = 5;
$ending = "????";

// different values for 'str'
$values = array(
  "",  //empty
  " ",  //space
  "This is simple string",  //regular string
  "It's string with quotes",  //string containing single quote
  "This contains @ # $ % ^ & chars",   //string with special characters
  "This string\tcontains\rwhite space\nchars",
  "This is string with 1234 numbers",
  "This is string with \0 and ".chr(0)."null chars",  //for binary safe
  "This is string with    multiple         space char",
  "Testing invalid \k and \m escape char",
  "This is to check with \\n and \\t" //to ignore \n and \t results

);

// loop through each element of the array for 'str'
for($count = 0; $count < count($values); $count++) {
  echo "-- Iteration ".($count+1)." --\n";
  var_dump( chunk_split( $values[$count], $chunklen, $ending) );
}

echo "Done"
?>
--EXPECTF--
*** Testing chunk_split() : with different double quoted values for 'str' argument ***
-- Iteration 1 --
string(4) "????"
-- Iteration 2 --
string(5) " ????"
-- Iteration 3 --
string(41) "This ????is si????mple ????strin????g????"
-- Iteration 4 --
string(43) "It's ????strin????g wit????h quo????tes????"
-- Iteration 5 --
string(59) "This ????conta????ins @???? # $ ????% ^ &???? char????s????"
-- Iteration 6 --
string(70) "This ????strin????g	con????tains????whit????e spa????ce
ch????ars????"
-- Iteration 7 --
string(60) "This ????is st????ring ????with ????1234 ????numbe????rs????"
-- Iteration 8 --
string(69) "This ????is st????ring ????with ????  and????  nul????l cha????rs????"
-- Iteration 9 --
string(90) "This ????is st????ring ????with ????   mu????ltipl????e    ????     ????space???? char????"
-- Iteration 10 --
string(69) "Testi????ng in????valid???? \k a????nd \m???? esca????pe ch????ar????"
-- Iteration 11 --
string(59) "This ????is to???? chec????k wit????h \n ????and \????t????"
Done
