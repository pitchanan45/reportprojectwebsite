<?php

if (!isset($_SESSION)) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pro1";
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
