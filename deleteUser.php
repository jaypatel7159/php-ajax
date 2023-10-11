<?php
include("connection.php");

if(isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    $query = "DELETE user, address FROM user
              INNER JOIN address ON user.user_id = address.user_id
              WHERE user.user_id = $userId";

    $result = mysqli_query($conn, $query);

} 
?>
