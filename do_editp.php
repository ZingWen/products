<?php
require_once("../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;

    $type_id = $_POST['type_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $img = $_FILES['img']; 
    $release_time = $_POST['release_time'];
    $CH = isset($_POST['CH']) ? 1 : 0;
    $EN = isset($_POST['EN']) ? 1 : 0;
    $JN = isset($_POST['JN']) ? 1 : 0;
    $rating_id = $_POST['rating_id'];
    $co_op_valid = isset($_POST['co-op_valid']) ? 1 : 0;


    $imgPath = ''; // 初始化圖片路徑

    if ($img['error'] == 0) {
        // 如果上傳成功，將檔案移動到指定目錄
        $uploadDir = __DIR__ . '/images/';
        $imgPath = md5($name); // 新的圖片檔名
        move_uploaded_file($img['tmp_name'], $uploadDir . $imgPath);
    }

    // 更新商品資料
    $updateQuery = "UPDATE product SET
        type_id = $type_id,
        name = '$name',
        price = $price,
        img = '$imgPath',
        release_time = '$release_time',
        CH = $CH,
        EN = $EN,
        JN = $JN,
        rating_id = $rating_id,
        `co-op_valid` = $co_op_valid
        WHERE id = $product_id";

    if ($conn->query($updateQuery) === TRUE) {
        echo '<script>alert("商品更新成功！");</script>';
        echo '<script>window.location.href = "product_list.php";</script>';
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request method";
}
?>
