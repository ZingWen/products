<?php
require_once("../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $new_valid = $_POST['new_valid'];

    // 更新資料庫中的 valid 欄位
    $updateQuery = "UPDATE product SET valid = $new_valid WHERE id = $product_id";

    if ($conn->query($updateQuery) === TRUE) {
        echo "Success";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request method";
}
?>
