<?php
require_once 'bootstrap.php';
require_once 'auth-check.php';
$db = dbconnect();

$username = $_POST['username'];
$mail = $_POST['mail'];
$passwd = hash('sha256', $_POST['passwd']);

header('Location: /version1/edit.php');
