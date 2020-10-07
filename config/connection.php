<?php
require_once("db.php");

$host = HOST;
$user = USER;
$pass = PASS;
$db = DB;

$conn = mysqli_connect($host, $user, $pass, $db) or die("Connection failed: " . mysqli_connect_error());
?>
