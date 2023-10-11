<?php
include("connection.php");

$sql = "SELECT user.user_id, user.user_name, address.address
        FROM user
        INNER JOIN address ON user.user_id = address.user_id
        WHERE address.default = '1' AND user.active = '1'";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
?>
