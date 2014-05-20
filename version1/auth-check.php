<?php
require_once 'bootstrap.php';
$db = dbconnect();

if (! $_SESSION['auth']['loggedin']) {
	return header('Location: /version1/signin.php');
}

if (! isset($_SESSION['auth']['user'])) {
	return header('Location: /version1/signin.php');
}
