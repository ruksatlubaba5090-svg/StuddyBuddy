<?php
include 'config.php';

$sql = "SELECT sp.Post_ID, s.Name, sp.Course_Code, sp.Study_Type, sp.Study_Time
        FROM Study_Post sp
        JOIN Student s ON sp.Student_ID = s.Student_ID";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<b>Post ID:</b> {$row['Post_ID']}<br>";
    echo "<b>Student:</b> {$row['Name']}<br>";
    echo "<b>Course:</b> {$row['Course_Code']}<br>";
    echo "<b>Study Type:</b> {$row['Study_Type']}<br>";
    echo "<b>Study Time:</b> {$row['Study_Time']}<br><hr>";
}
?>