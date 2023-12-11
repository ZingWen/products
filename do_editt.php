<?php
require_once("../db_connect.php");
var_dump($_POST['type_id']);
$name = $_POST['name'];
$type_id = $_POST['type_id'];

$sql= "UPDATE type SET name = '$name' WHERE id = $type_id";

if ($type_id > 0) {
    // 執行更新
    $updateResult = $conn->query("UPDATE type SET name = '$name' WHERE id = $type_id");

    // 檢查更新是否成功
    if ($updateResult === TRUE) {
        echo '<script>alert("類別更新成功！");</script>';
        echo '<script>window.location.href = "type.php";</script>';
    } else {
        echo "更新資料錯誤: " . $conn->error;
    }
} else {
    echo "type_id 不合法。";
}

// 關閉數據庫連接
$conn->close();
?>
