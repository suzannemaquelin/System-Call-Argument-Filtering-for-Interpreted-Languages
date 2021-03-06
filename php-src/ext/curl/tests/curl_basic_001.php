<?php
/* Prototype  : bool curl_exec(resource ch)
 * Description: Perform a cURL session
 * Source code: ext/curl/interface.c
 * Alias to functions:
 */
  include 'server.inc';
  $host = curl_cli_server_start();

  // start testing
  echo "*** Testing curl_exec() : basic functionality ***\n";

  $url = "{$host}/get.php?test=get";
  $ch = curl_init();

  ob_start(); // start output buffering
  curl_setopt($ch, CURLOPT_URL, $url); //set the url we want to use
  $ok = curl_exec($ch);
  curl_close($ch);
  $curl_content = ob_get_contents();
  ob_end_clean();

  if($ok) {
    var_dump( $curl_content );
  } else {
    echo "curl_exec returned false";
  }
?>
===DONE===
