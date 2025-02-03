<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appointments_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อผิดพลาด: " . $conn->connect_error);
}

return $conn;
?>
