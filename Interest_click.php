<?php
include 'Config.php';

if (!isset($_POST['Student_id'], $_POST['Post_ID'])) {
    exit("Invalid request");
}

$student_id = $_POST['Student_id'];
$post_id    = $_POST['Post_ID'];

/* Check if already interested */
$check = $conn->prepare(
    "SELECT Interest_Student_ID FROM study_post 
     WHERE Interest_Student_ID = ? AND Post_ID = ?"
);
$check->bind_param("ii", $student_id, $post_id);
$check->execute();
$check->store_result();

if ($check->num_rows == 0) {

    /* Add interest */
    $insert = $conn->prepare(
        "INSERT INTO Interested_Student_ID (Interest_Student_ID, Post_ID)
         VALUES (?, ?)"
    );
    $insert->bind_param("ii", $student_id, $post_id);
    $insert->execute();

    echo "Interest added";

} else {

    /* Remove interest */
    $delete = $conn->prepare(
        "DELETE FROM Interested_Student_ID
         WHERE Interest_Student_ID = ? AND Post_ID = ?"
    );
    $delete->bind_param("ii", $student_id, $post_id);
    $delete->execute();

    echo "Interest removed";
}
?>


