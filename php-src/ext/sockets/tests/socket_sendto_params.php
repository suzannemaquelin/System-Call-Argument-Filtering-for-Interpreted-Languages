<?php
    $rand = rand(1,999);
    $s_c = socket_create_listen(31330+$rand);
    $s_w = socket_sendto($s_c, "foo", -1, MSG_OOB, '127.0.0.1');
    socket_close($s_c);
?>
