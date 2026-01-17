<?php
require_once 'bootstrap.php';
$_SESSION = [];
session_destroy();
header("Location: login.php");
exit;
?>