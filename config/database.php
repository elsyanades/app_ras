<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ras_otomasi";  // Ganti dengan nama database Anda

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
