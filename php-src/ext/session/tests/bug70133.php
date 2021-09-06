<?php

class CustomReadHandler extends \SessionHandler {

    public function read($session_id) {
        return parent::read('mycustomsession');
    }
}

ob_start();

session_set_save_handler(new CustomReadHandler(), true);

session_id('mycustomsession');
session_start();
$_SESSION['foo'] = 'hoge';
var_dump(session_id());
session_commit();

session_id('otherid');
session_start();
var_dump($_SESSION);
var_dump(session_id());

?>
