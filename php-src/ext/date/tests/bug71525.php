<?php
$date = new DateTime('2011-12-25 00:00:00');
$date->modify('first day of next month');
$date->setDate('2012', '1', '29');
var_dump($date);
