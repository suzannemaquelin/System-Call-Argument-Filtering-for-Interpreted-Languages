<?php
$user_agent = 'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en-US) AppleWebKit/522+ (KHTML, like Gecko, Safari/522) OmniWeb/v613';
$caps = get_browser($user_agent, true);
var_dump($caps['browser'], $caps['version']);
?>
==DONE==
