<?php
require_once("../db_connect.php");


// 檢查是否有提交表單
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type_id = $_POST["type_id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $release_time = $_POST["release_time"];
    $CH = isset($_POST["CH"]) ? 1 : 0;
    $EN = isset($_POST["EN"]) ? 1 : 0;
    $JN = isset($_POST["JN"]) ? 1 : 0;
    $rating_id = $_POST["rating_id"];
    $co_op_valid = isset($_POST["co-op_valid"]) ? 1 : 0;


    $imgFileName = "";

    if ($_FILES["img"]["error"] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["img"]["tmp_name"];
        $timestamp = time();  // 用時間戳記來取名↓
        $imgFileName = $timestamp . "_" . $_FILES["img"]["name"];
        $destination = "../upload/" . $imgFileName;
        // 移動上傳的圖片到目的地
        move_uploaded_file($tmp_name, $destination);
    }

    $seller_id = 2;
    date_default_timezone_set('Asia/Taipei');
    $created_at = date('Y-m-d H:i:s');
    $valid = 0; //預設隱藏先0

    // 準備 SQL 語句
    $query = "INSERT INTO product (type_id, name, price, img, release_time, CH, EN, JN, rating_id, `co-op_valid`, seller_id, created_at, valid, exist_valid)
              VALUES ('$type_id', '$name', '$price', '$imgFileName', '$release_time', '$CH', '$EN', '$JN', '$rating_id', '$co_op_valid', '$seller_id', '$created_at', '$valid', 1)";

    // 執行 SQL 語句
    if ($conn->query($query) === TRUE) {
        echo '<script>alert("商品新增成功！");</script>';
        echo '<script>window.location.href = "product_list.php";</script>';
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;

    }

    // 關閉資料庫連接
    $conn->close();
}
?>