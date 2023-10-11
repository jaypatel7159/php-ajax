<?php
include("connection.php");

$sql = "SELECT user.*, address.*
        FROM user
        INNER JOIN address ON user.user_id = address.user_id";

$result = mysqli_query($conn, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);
?>
