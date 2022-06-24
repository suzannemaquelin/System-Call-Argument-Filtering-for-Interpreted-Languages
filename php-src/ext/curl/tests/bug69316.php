<?php
  function hdr_callback($ch, $data) {
      // close the stream, causing the FILE structure to be free()'d
      if($GLOBALS['f_file']) {
          fclose($GLOBALS['f_file']); $GLOBALS['f_file'] = 0;

          // cause an allocation of approx the same size as a FILE structure, size varies a bit depending on platform/libc
          $FILE_size = (PHP_INT_SIZE == 4 ? 0x160 : 0x238);
          curl_setopt($ch, CURLOPT_COOKIE, str_repeat("a", $FILE_size - 1));
      }
      return strlen($data);
  }

  include 'server.inc';
  $host = curl_cli_server_start();
  $temp_file = dirname(__FILE__) . '/body.tmp';
  $url = "{$host}/get.php?test=getpost";
  $ch = curl_init();
  $f_file = fopen($temp_file, "w") or die("failed to open file\n");
  curl_setopt($ch, CURLOPT_BUFFERSIZE, 10);
  curl_setopt($ch, CURLOPT_HEADERFUNCTION, "hdr_callback");
  curl_setopt($ch, CURLOPT_FILE, $f_file);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_exec($ch);
  curl_close($ch);
?>
===DONE===
