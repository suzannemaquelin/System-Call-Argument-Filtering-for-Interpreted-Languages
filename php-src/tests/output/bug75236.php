<?php

    ini_set('html_errors', true);
    ini_set('default_charset', 'ISO-8859-2');

    printf ("before getfilecontent\n");
    file_get_contents ('no/suchfile');
    printf ("after getfilecontent\n");

?>
