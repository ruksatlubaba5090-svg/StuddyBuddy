<?php
$conn = mysqli_connect("localhost", "root", "", "campus_connection");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>