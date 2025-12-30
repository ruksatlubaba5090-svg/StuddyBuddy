<?php
require_once 'config.php';

$sql = "
SELECT 
    sp.Post_ID,
    sp.Course_Code,
    sp.Study_type,
    COUNT(isd.Interest_Student_ID) AS total_interest
FROM study_post sp
LEFT JOIN interested_student isd
    ON sp.Post_ID = isd.Post_ID
GROUP BY sp.Post_ID, sp.Course_Code, sp.Study_type
ORDER BY total_interest DESC
LIMIT 5
";

$result = mysqli_query($conn, $sql);

echo '<h2>Top 5 Most Interested Study Posts</h2>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<b>Post ID:</b> ' . $row['Post_ID'] . '<br>';
    echo '<b>Course:</b> ' . $row['Course_Code'] . '<br>';
    echo '<b>Study Type:</b> ' . $row['Study_type'] . '<br>';
    echo '<b>Total Interests:</b> ' . $row['total_interest'] . '<br><hr>';
}
?>

