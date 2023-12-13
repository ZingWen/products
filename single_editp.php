<?php
/* session_start();

// 檢查是否有登入
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php"); //要記得改這邊的連線
    exit();
}

$auSellerId = $_SESSION['seller_id'];

if ($auSellerId != $seller_id) {
    header("Location: login.php");
    exit();
} */
?>

<?php

require_once("../db_connect.php");

$seller_id = 2; //測試

/* 賣場顯示 */
$query = "SELECT *,
ysl_seller.shop_name AS s_shop_name
FROM ysl_seller
WHERE ysl_seller.seller_id = $seller_id
LIMIT 1";
$shopResult = $conn->query($query);
$shopRow = $shopResult->fetch_assoc();


$query = "SELECT product.*,
type.name AS type_name, 
rating.name AS rating_name,
rating.img AS rating_img,
ysl_seller.shop_name AS s_shop_name,
product.id AS product_id
FROM product 
JOIN type ON product.type_id = type.id
JOIN rating ON product.rating_id = rating.id
JOIN ysl_seller ON product.seller_id = ysl_seller.seller_id
WHERE product.seller_id = $seller_id";

$result = $conn->query($query);

// 獲取商品 ID
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;
/* 類別 */
$categoryQuery = "SELECT DISTINCT type.*,
type.name AS type_name
FROM type ";
$filterCategory = $conn->query($categoryQuery);

/* 級別 */
$ratingQuery = "SELECT DISTINCT rating.*,
rating.name AS rating_name
FROM rating ";
$filterRating = $conn->query($ratingQuery);


/* 圖片 */
$sql = "SELECT product.img FROM product ORDER BY id DESC LIMIT 1";
$imgResult = $conn->query($sql);
$img = $imgResult->fetch_assoc();
// 初始化預設值
$defaultValues = array(
    'type_id' => '',
    'name' => '',
    'price' => '',
    'img' => '', // 假設這是你的圖片路徑欄位
    'release_time' => '',
    'CH' => '', // 中文
    'EN' => '', // 英文
    'JN' => '', // 日文
    'rating_id' => '',
    'co-op_valid' => ''
);

if ($product_id) {
    $queryProduct = "SELECT * FROM product WHERE id = $product_id";
    $resultProduct = $conn->query($queryProduct);

    if ($resultProduct->num_rows > 0) {
        $productInfo = $resultProduct->fetch_assoc();

        $defaultValues['type_id'] = $productInfo['type_id'];
        $defaultValues['name'] = $productInfo['name'];
        $defaultValues['price'] = $productInfo['price'];
        $defaultValues['img'] = $productInfo['img'];
        $defaultValues['release_time'] = $productInfo['release_time'];
        $defaultValues['CH'] = ($productInfo['CH'] == '1') ? 'checked' : '';
        $defaultValues['EN'] = ($productInfo['EN'] == '1') ? 'checked' : '';
        $defaultValues['JN'] = ($productInfo['JN'] == '1') ? 'checked' : '';
        $defaultValues['rating_id'] = $productInfo['rating_id'];
        $defaultValues['co-op_valid'] = ($productInfo['co-op_valid'] == 1) ? 'checked' : '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>商品新增</title>
    <?php include("include.php"); ?>
</head>

<body class="sb-nav-fixed searchResultContainer">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Layouts
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Pages
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="login.html">Login</a>
                                        <a class="nav-link" href="register.html">Register</a>
                                        <a class="nav-link" href="password.html">Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="401.html">401 Page</a>
                                        <a class="nav-link" href="404.html">404 Page</a>
                                        <a class="nav-link" href="500.html">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="product_list.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            商品管理
                        </a>
                        <a class="nav-link" href="type.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            類別管理
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- <h1 class="mt-4">Tables</h1> -->
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">商品管理</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h3><i class="fas fa-table"></i>
                                    <?php if (isset($_GET["price-min"]) && isset($_GET["price-max"])) : ?>
                                        
                                            <?= $shopResult["s_shop_name"] . " 賣場"; ?>
                                    <?php else : ?>
                                        <?php $row = $result->fetch_assoc(); ?>
                                        <?= $row["s_shop_name"] ?> 賣場
                                    <?php endif ?>
                                </h3>
                            </div>
                        </div>
                        <!-- 這裡開始格式統整 -->
                        <div class="card-body">
                            <div class="container mt-2">
                                <form action="do_editp.php" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                        <label for="type_id" class="form-label">商品類型：</label>
                                        <select class="form-select" name="type_id" id="type_id">
                                            <?php foreach ($filterCategory as $type) : ?>
                                                <option value="<?= $type["id"] ?>" <?= ($defaultValues['type_id'] == $type["id"]) ? 'selected' : '' ?>>
                                                    <?= $type["type_name"] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label" required>商品名稱：</label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?= $defaultValues['name'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="price" class="form-label" required>商品價格：</label>
                                        <input type="number" class="form-control" name="price" id="price" value="<?= $defaultValues['price'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="img" class="form-label">商品列表圖片：</label>
                                        <input type="file" class="form-control" name="img" id="img" accept="image/*" onchange="previewImage()">

                                        <p class="mt-3">目前相片</p>
                                        <div class="row g-3">
                                            <div class="row g-3">
                                                <div class="img_container">
                                                    <?php
                                                    // 先動態生成圖片路徑
                                                    $currentImagePath = $img ? '/upload/' . $img["img"] : '';
                                                    
                                                    // 檢查檔案是否存在
                                                    if ($img && file_exists(__DIR__ . $currentImagePath)) {
                                                        // 如果存在，使用這個路徑
                                                        echo '<img id="currentImageForm" class="img-fluid" src="' . $currentImagePath . '" alt="' . $img["img"] . '">';
                                                    } else {
                                                        // 如果不存在，使用一個預設的圖片路徑
                                                        echo '<img id="currentImageForm" class="img-fluid" src="images/' . $defaultValues['img'] . '" alt="' . $defaultValues['name'] . '">';
                                                        
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label for="release_time" class="form-label">遊戲上市時間：</label>
                                        <input type="date" class="form-control" name="release_time" id="release_time" value="<?= date('Y-m-d', strtotime($defaultValues['release_time'])) ?>">
                                        <script>
                                            
                                            let releaseTimeInput = document.getElementById('release_time');

                                            releaseTimeInput.addEventListener('change', function() {
                                                let currentDate = new Date();
                                                var selectedDate = new Date(this.value);
                                                if (selectedDate > currentDate) {
                                                    // 如果大於目前，將輸入框的值設為現在的日期
                                                    releaseTimeInput.valueAsDate = currentDate;
                                                    alert('遊戲上市時間不能超過當前日期！');
                                                }
                                            });
                                        </script>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-check-label">語言支援：</label>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="CH" id="CH" <?= $defaultValues['CH'] ?>>
                                            <label class="form-check-label" for="CH">中文</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="EN" id="EN" <?= $defaultValues['EN'] ?>>
                                            <label class="form-check-label" for="EN">英文</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="JN" id="JN" <?= $defaultValues['JN'] ?>>
                                            <label class="form-check-label" for="JN">日文</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="rating_id" class="form-label">評分：</label>
                                        <select class="form-select" name="rating_id" id="rating_id">
                                            <?php foreach ($filterRating as $rating) : ?>
                                                <option value="<?= $rating["id"] ?>" <?= ($defaultValues['rating_id'] == $rating["id"]) ? 'selected' : '' ?>>
                                                    <?= $rating["rating_name"] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="co-op_valid" id="co-op_valid" <?= $defaultValues['co-op_valid'] ?>>
                                            <label class="form-check-label" for="co-op_valid">支援多人</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <form action="do_editp.php">
                                                <button type="submit" class="btn btn-primary">儲存</button>
                                            </form>
                                            <a href="product_list.php" class="btn btn-danger text-end">取消</a>
                                        </div>
                                        <button title="確定儲存並繼續編輯商品詳細頁面" type="submit" class="btn btn-secondary">進階編輯</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- 預覽圖片js -->
    <script>
        {
            /* 看有沒有改變圖片 */ }
        document.getElementById('img').addEventListener('change', function(event) {
            const selectedFile = event.target.files[0]; /* 記得要是第0個索引 */
            const currentImage = document.getElementById('currentImageForm');
            if (selectedFile) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentImage.src = e.target.result;
                };
                reader.readAsDataURL(selectedFile);
            } else {
                // 如果取消選擇檔案就回到一開始的圖片路徑
                const initialImagePath = '/default/path/to/image.jpg';
                currentImage.src = initialImagePath;
            }
        });
    </script>

</body>

</html>