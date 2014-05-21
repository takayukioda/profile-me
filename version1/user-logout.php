<?php
require_once 'bootstrap.php';
session_destroy();
$_SESSION = null;

return header('Location: index.php');
