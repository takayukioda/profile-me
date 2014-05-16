<?php
require_once 'bootstrap.php';

$data = array('username' => 'test', 'mail' => 'mail@address.com', 'comment' => 'blablablabla');
$user = Users::instance($data, false);


var_dump($user);

$user->username = 'modified';

var_dump($user);

