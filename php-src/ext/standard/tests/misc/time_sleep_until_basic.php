<?php
  $time = microtime(true) + 2;
  var_dump(time_sleep_until( (int)$time ));
  $now = microtime(true);
  if(substr(PHP_OS, 0, 3) == 'WIN' ) {
    // on windows, time_sleep_until has millisecond accuracy while microtime() is accurate
    // to 10th of a second. this means there can be up to a .9 millisecond difference
    // which will fail this test. this test randomly fails on Windows and this is the cause.
    //
    // fix: round to nearest millisecond
    // passes for up to .5 milliseconds less, fails for more than .5 milliseconds
    // should be fine since time_sleep_until() on Windows is accurate to the
    // millisecond(.5 rounded up is 1 millisecond)
    // In practice, on slower machines even that can fail, so giving yet 50ms or more.
    $tmp = round($now, 3);
    $now = $tmp >= (int)$time ? $tmp : $tmp + .05;
  }
  var_dump($now >= (int)$time);
?>
