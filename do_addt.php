<?php
require_once("../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $valid = 1;
    $name = $_POST['name'];
    $insertQuery = "INSERT INTO type (name, valid) VALUES ('$name', '$valid')";

    if ($conn->query($insertQuery) === TRUE) {
        echo '<script>alert("類別新增成功！");</script>';
        echo '<script>window.location.href = "type.php";</script>';
    } else {
        echo "錯誤：" . $conn->error;
    }

    $conn->close();
}
?>
