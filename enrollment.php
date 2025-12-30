<?php
include 'Config.php';

if (!isset($_POST['Student_ID'], $_POST['Course_Code'])) {
    exit("Invalid request");
}

$student_id  = (int) $_POST['Student_ID'];
$course_code = $_POST['Course_Code'];

$check = $conn->prepare(
    "SELECT Enrollment_ID
     FROM Course_Enrollment
     WHERE Student_ID = ? AND Course_Code = ?"
);
$check->bind_param("is", $student_id, $course_code);
$check->execute();
$check->store_result();

if ($check->num_rows == 0) {

    $insert = $conn->prepare(
        "INSERT INTO Course_Enrollment (Student_ID, Course_Code)
         VALUES (?, ?)"
    );
    $insert->bind_param("is", $student_id, $course_code);
    $insert->execute();

    echo "Course enrolled successfully.";

} else {
    echo "You are already enrolled in this course.";
}
?>
