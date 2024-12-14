<?php
session_start();  // Bắt đầu phiên làm việc

// Kiểm tra nếu người dùng đã đăng nhập
$is_logged_in = false;
if (isset($_SESSION['user_email'])) {
    $is_logged_in = true;
    $username = $_SESSION['user_name'];  // Lấy tên người dùng từ session
} else {
    $username = '';
}
?>
<html>
<title>Head</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="head.css">
<body>
    <header>
            <img src="./Anh/Logo.png">
        <div class="header-left">
            <a href="../trangchu1.php"><strong>TRANG CHỦ</strong></a>
            <div class="drop-down">
            <a href="sp.php"><strong>SẢN PHẨM</strong></a>
                <div class="detail">
                    <a href="danhmucanimals.php"><strong>ANIMALS</strong></a>
                    <a href="danhmucbags&charms.php"><strong>BAGS & CHARMS</strong></a>
                    <a href="danhmucamuseables.php"><strong>AMUSEABLES</strong></a>
                    <a href="danhmucgifts.php"><strong>GIFTS</strong></a>
                </div>
            </div>
            <a href="../tintuc.php"><strong>TIN TỨC</strong></a>
        </div>
        <div class="header-right">
            <div class="search-bar">
                <a href="cart.php"><i class="fa fa-shopping-cart"></i></a>
            </div>
            <!-- <div class="iconCart">
                <i class="fa-solid fa-cart-shopping"></i>
                <div class="totalQuantity">0</div>
        </div> -->
            <!-- Nếu người dùng đã đăng nhập -->
        <?php if ($is_logged_in): ?>
            <div class="user-info">
            <a href="
            <?php 
                // Kiểm tra usertype và chuyển hướng tới trang tương ứng
                if ($_SESSION['usertype'] == 'admin') {
                    echo '../admin.php';  // Trang admin
                } else {
                    echo '../user_page.php';  // Trang user
                }
            ?>
        " class="user-greeting">
            <i class="fa fa-user"></i>
        </a>
                <a href="../logout.php" class="logout-link"><i class="fa fa-sign-out-alt"></i></a>
            </div>
        <?php else: ?>
            <div class="user-info">
            <a href="../login_form.php" class="login-link">
                <i class="fa fa-user"></i>
            </a>
            </div>
        <?php endif; ?>
        </div>
    </header>
</body>
</html>