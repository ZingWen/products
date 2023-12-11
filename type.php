<?php
require_once("../db_connect.php");

// 假設登入用POST方法
/* $loginSeller = $_POST["member_identity"]; */
$seller_id = 2; //測試

$itemsPerPage = 7;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; //抓當下頁碼
$startIndex = ($page - 1) * $itemsPerPage; //算要抓那頁第幾個資料


if (isset($_GET["search"])) {
    $search = $_GET['search'];
    $query = "SELECT type.*,
    type.name AS type_name, 
    type.id AS type_id
    FROM type
    WHERE type.name LIKE '%$search%' AND type.valid=1
    LIMIT $startIndex, $itemsPerPage";
    $result = $conn->query($query);
    $searchResult = $result->fetch_all(MYSQLI_ASSOC);

    $searchCountQuery = "SELECT COUNT(*) as total FROM type WHERE type.name LIKE '%$search%'";
    $searchCountResult = $conn->query($searchCountQuery);
    $searchItems = $searchCountResult->fetch_assoc()["total"];
    $searchPages = ($searchItems > 0) ? ceil($searchItems / $itemsPerPage) : 0;
}

$query = "SELECT type.*,
type.name AS type_name, 
type.id AS type_id
FROM type
WHERE type.valid=1
LIMIT $startIndex, $itemsPerPage";

$result = $conn->query($query);
$typeResult = $result->fetch_all(MYSQLI_ASSOC);

/* id升冪 */
if (isset($_GET["idUp"])) {
    $query = "SELECT type.*,
    type.name AS type_name, 
    type.id AS type_id
    FROM type
    WHERE type.valid=1
    ORDER BY type.id ASC
    LIMIT $startIndex, $itemsPerPage";
    $result = $conn->query($query);
    $idUpResult = $result->fetch_all(MYSQLI_ASSOC);
    $result->data_seek(0); // 重新將指針移回結果集開頭
} else if (isset($_GET["idDown"])) {
    $query = "SELECT type.*,
    type.name AS type_name, 
    type.id AS type_id
    FROM type
    WHERE type.valid=1
    ORDER BY type.id DESC
    LIMIT $startIndex, $itemsPerPage";
    $result = $conn->query($query);
    $idDownResult = $result->fetch_all(MYSQLI_ASSOC);
    $result->data_seek(0); // 重新將指針移回結果集開頭
}

/* 商品總數 */
$alltypecount = "SELECT COUNT(*) as total FROM type";
$totalItemsResult = $conn->query($alltypecount);
$allTypeItems = $totalItemsResult->fetch_assoc()["total"];

/* 頁數 */
$allTypePages = ($allTypeItems > 0) ? ceil($allTypeItems / $itemsPerPage) : 0;

/* 用來顯示賣場的 */
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
WHERE product.seller_id = $seller_id
LIMIT $startIndex, $itemsPerPage";

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>類別管理</title>
    <?php include("include.php"); ?>
</head>

<body class="sb-nav-fixed searchResultContainer">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
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
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Layouts
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                            aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Pages
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="login.html">Login</a>
                                        <a class="nav-link" href="register.html">Register</a>
                                        <a class="nav-link" href="password.html">Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#pagesCollapseError" aria-expanded="false"
                                    aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordionPages">
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
                                    <?php $row = $result->fetch_assoc(); ?>
                                    <?= $row["s_shop_name"] ?> 賣場
                                </h3>
                            </div>
                            <div class="btn-group">
                                <a type="button" class="btn btn-danger" href="add_type.php">新增分類</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <form action="type.php" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="搜尋分類" name="search">
                                        <div class="col-auto">
                                            <button class="btn border-0" type="submit">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- table -->
                            <div class="container">
                                <table class="table mt-4 container">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="col-3">
                                                類別名稱
                                                <a
                                                    href="type.php?idDown<?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">
                                                    <i class="bi bi-caret-down-fill"></i>
                                                </a>
                                                <a
                                                    href="type.php?idUp<?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">
                                                    <i class="bi bi-caret-up-fill"></i>
                                                </a>
                                            </th>
                                            <th class="col-2">編輯
                                            </th>
                                            <th class="col-2">
                                                刪除分類
                                            </th>
                                        </tr>
                                    </thead>
                                    <!-- tbody -->
                                    <tbody>
                                        <?php
                                        if (isset($_GET["search"])) {
                                            $resultArray = $searchResult;
                                        } elseif (isset($_GET["idUp"])) {
                                            $resultArray = $idUpResult;
                                        } elseif (isset($_GET["idDown"])) {
                                            $resultArray = $idDownResult;
                                        } else {
                                            $resultArray = $typeResult;
                                        }

                                        foreach ($resultArray as $row):
                                            ?>
                                            <tr>
                                                <td class="col-6">
                                                    <?= $row["type_name"] ?>
                                                </td>
                                                <td class="col-2">
                                                    <a href="edit_type.php?type_id=<?= $row['type_id'] ?>"> <i class="bi bi-pencil-square"></i></a>
                                                   
                                                </td>
                                                <td class="col-2">
                                                    <a href="type_sdelete.php?type_id=<?= $row['type_id'] ?>"
                                                        onclick="return confirm('確定要刪除嗎？')">
                                                        <i class="bi bi-trash3"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        endforeach;
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                            <nav class="d-flex justify-content-center">
                                <div class="col-auto">
                                    <a title="返回第一頁" class="btn btn-secondary text-white" href="type.php"><i
                                            class="bi bi-reply-all-fill"></i></a>
                                </div>
                                <ul class="pagination">
                                    <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                                        <a title="上一頁" class="page-link" href="type.php?page=<?= $page - 1; ?>"
                                            aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php
                                    $paginationUrl = isset($_GET['search']) ? 'type.php?search=' . $_GET['search'] . '&page=' : 'type.php?page=';

                                    for ($i = 1; $i <= (isset($_GET['search']) ? $searchPages : $allTypePages); $i++):
                                        ?>
                                        <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">
                                            <a class="page-link" href="<?= $paginationUrl . $i; ?>">
                                                <?= $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <li class="page-item <?= ($page == $allTypePages) ? 'disabled' : ''; ?>">
                                        <a title="下一頁" class="page-link" href="type.php?page=<?= $page + 1; ?>"
                                            aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <p class="text-center">
                                總共有
                                <?= (isset($_GET['search']) ? $searchItems : $allTypeItems) ?? 0 ?> 個分類，共
                                <?= (isset($_GET['search']) ? $searchPages : $allTypePages) ?? 0 ?> 頁。
                            </p>
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
</body>

</html>