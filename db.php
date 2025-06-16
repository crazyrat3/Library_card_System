<?php
$host = "localhost";       // or "127.0.0.1"
$user = "root";            // change if you're using another DB user
$pass = "";                // set your DB password here
$db   = "libcard";       // your database name

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
