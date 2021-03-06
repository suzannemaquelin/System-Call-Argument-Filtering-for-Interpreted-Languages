<?php
  define('DEFINED', 1234);
  $def = 456;
  define('DEFINED_TO_VAR', $def);
  define('DEFINED_TO_UNDEF_VAR', $undef);

  class C
  {
      const c0 = UNDEFINED;

      const c1 = 1, c2 = 1.5;
      const c3 =  + 1, c4 =  + 1.5;
      const c5 = -1, c6 = -1.5;

      const c7 = __LINE__;
      const c8 = __FILE__;
      const c9 = __CLASS__;
      const c10 = __METHOD__;
      const c11 = __FUNCTION__;

      const c12 = DEFINED;
      const c13 = DEFINED_TO_VAR;
      const c14 = DEFINED_TO_UNDEF_VAR;

      const c15 = "hello1";
      const c16 = 'hello2';
      const c17 = C::c16;
      const c18 = self::c17;
  }

  echo "\nAttempt to access various kinds of class constants:\n";
  var_dump(C::c0);
  var_dump(C::c1);
  var_dump(C::c2);
  var_dump(C::c3);
  var_dump(C::c4);
  var_dump(C::c5);
  var_dump(C::c6);
  var_dump(C::c7);
  var_dump(C::c8);
  var_dump(C::c9);
  var_dump(C::c10);
  var_dump(C::c11);
  var_dump(C::c12);
  var_dump(C::c13);
  var_dump(C::c14);
  var_dump(C::c15);
  var_dump(C::c16);
  var_dump(C::c17);
  var_dump(C::c18);

  echo "\nExpecting fatal error:\n";
  var_dump(C::c19);

  echo "\nYou should not see this.";
?>
