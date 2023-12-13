<?php
require_once("../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['type_id'])) {
    $type_id = intval($_GET['type_id']);
    $updateQuery = "UPDATE type SET valid = 0 WHERE id = $type_id";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult === TRUE) {
        echo '<script>alert("類別已刪除！");</script>';
        echo '<script>window.location.href = "type.php";</script>';
    } else {
        echo "錯誤: " . $conn->error;
    }
}

$conn->close();
?>
