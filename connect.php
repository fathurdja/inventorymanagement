<?php
// Assuming you have a MySQL database

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datapbo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// // Retrieve data from the form

// $koneksi = mysqli_connect("localhost","root","","datapbo");

?>
