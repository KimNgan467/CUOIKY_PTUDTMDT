<?php
session_start(); // Bắt đầu phiên làm việc

// Kiểm tra nếu người dùng đã đăng nhập
$is_logged_in = false;
if (isset($_SESSION['user_email'])) {
    $is_logged_in = true;
    $username = $_SESSION['user_name'];  // Lấy tên người dùng từ session
} else {
    $username = '';
}

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "vidu"; // Đổi tên nếu cần

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập biến tìm kiếm
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $conn->real_escape_string($_POST['search']);
}

// Lấy dữ liệu cho cả admin và user với tìm kiếm
$sql = "SELECT * FROM userform WHERE usertype IN ('admin', 'user') AND (name LIKE '%$search_query%' OR email LIKE '%$search_query%')";
$result = $conn->query($sql);
$userlist = [];

if ($result->num_rows > 0) {
    // Lấy dữ liệu cho mỗi hàng
    while ($row = $result->fetch_assoc()) {
        $userlist[] = $row;
    }
} else {
    echo "0 results";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="admin.css">
    <title>TRANG QUẢN TRỊ</title>
</head>
<body>

<header>
    <img src="./Anh/Logo.png">
    <div class="header-left">
        <a href="trangchu1.php"><strong>TRANG CHỦ</strong></a>
        <div class="drop-down">
            <a href="./sản phẩm/sp.php"><strong>SẢN PHẨM</strong></a>
            <div class="detail">
                <a href="./sản phẩm/danhmucanimals.php"><strong>ANIMALS</strong></a>
                <a href="./sản phẩm/danhmucbags&charms.php"><strong>BAGS & CHARMS</strong></a>
                <a href="./sản phẩm/danhmucamuseables.php"><strong>AMUSEABLES</strong></a>
                <a href="./sản phẩm/danhmucgifts.php"><strong>GIFTS</strong></a>
            </div>
        </div>
        <a href="tintuc.php"><strong>TIN TỨC</strong></a>
    </div>

    <div class="header-right">
        <div class="search-bar">
            <a href="./sản phẩm/cart.php"><i class="fa fa-shopping-cart"></i></a>
        </div>
        <!-- Nếu người dùng đã đăng nhập -->
        <?php if ($is_logged_in): ?>
            <div class="user-info">
                <a href="<?php 
                    // Kiểm tra usertype và chuyển hướng tới trang tương ứng
                    if ($_SESSION['usertype'] == 'admin') {
                        echo 'admin.php';  // Trang admin
                    } else {
                        echo 'user_page.php';  // Trang user
                    }
                ?>" class="user-greeting">
                    <i class="fa fa-user"></i>
                </a>
                <a href="logout.php" class="logout-link"><i class="fa fa-sign-out-alt"></i></a>
            </div>
        <?php else: ?>
            <div class="user-info">
                <a href="login_form.php" class="login-link">
                    <i class="fa fa-user"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</header>

<main>
    <div id="content-wrapper">
        <div class="container">
            <div class="left-menu">
                <div class="menu-heading">Trang quản trị</div>
                <div class="menu-items">
                    <ul>
                        <li><a href="admin.php">Thông tin tài khoản</a></li>
                        <li><a href="qttintuc.php">Tin tức</a></li>
                        <li><a href="./sản phẩm/qtsp.php">Sản phẩm</a></li>
                        <li><a href="admin_order2.php">Đơn hàng</a></li>
                    </ul>
                </div>
            </div>
            <div class="admininfo">
                <!-- Form tìm kiếm -->
                <form method="POST" action="">
                    <input type="text" name="search" placeholder="Tìm kiếm theo tên hoặc email" value="<?= htmlspecialchars($search_query) ?>">
                    <button class="button btn_edit" type="submit">Tìm kiếm</button>
                </form>

                <table class="admin">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Mật khẩu</th>
                            <th>Loại người dùng</th>
                            <th style="width: 60px"></th>
                            <th style="width: 60px"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($userlist as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['email'] ?></td>
                            <td>****</td>
                            <td><?= $item['usertype'] ?></td>
                            <td>
                                <a href="editadmin.php?id=<?= $item['id'] ?>"><button class="button btn_edit">Sửa</button></a>
                            </td>
                            <td>
                                <a href="deleteadmin.php?id=<?= $item['id'] ?>"><button class="button btn_delete">Xóa</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
</body>
</html>