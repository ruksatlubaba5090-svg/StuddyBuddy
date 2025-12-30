<?php
require_once 'config.php';

$sql = "SELECT Student_id, Name, Email
        FROM student
        WHERE Verified_status = 'PENDING'";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "Student id: ".$row['Student_id']."<br>";
    echo "Name: ".$row['Name']."<br>";
    echo "Email: ".$row['Email']."<br><br>";
}
?>

