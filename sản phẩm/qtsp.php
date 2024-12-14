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

//Thông tin kết nối
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vidu";
//Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);
//Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    updateJsonFile($conn); // Gọi hàm cập nhật JSON
    header('location:qtsp.php');
}

function updateJsonFile($conn) {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    $products = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    // Chuyển đổi sang JSON và lưu vào file
    file_put_contents('product.json', json_encode($products, JSON_PRETTY_PRINT));
}
?>

<?php
// session_start();  // Bắt đầu phiên làm việc

// Kiểm tra nếu người dùng đã đăng nhập
$is_logged_in = false;
if (isset($_SESSION['user_email'])) {
    $is_logged_in = true;
    $username = $_SESSION['user_name'];  // Lấy tên người dùng từ session
} else {
    $username = '';
}

// Khởi tạo giỏ hàng
$listCart = isset($_COOKIE['listCart']) ? json_decode($_COOKIE['listCart'], true) : [];
$totalQuantity = 0;

// Tính tổng số lượng sản phẩm trong giỏ hàng
if (!empty($listCart)) {
    foreach ($listCart as $product) {
        if (isset($product['quantity'])) {
            $totalQuantity += $product['quantity'];
        }
    }
}
?>
<html>
<head>
    <title>QUẢN TRỊ SẢN PHẨM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="qtspfinal.css">
</head>
<body>
    <header>
    <img src="./Anh/Logo.png" alt="Logo" />
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
        <!-- Nếu người dùng đã đăng nhập -->
        <?php if ($is_logged_in): ?>
            <div class="user-info">
                <a href="
                <?php 
                    // Kiểm tra usertype và chuyển hướng tới trang tương ứng
                    echo ($_SESSION['usertype'] == 'admin') ? '../admin.php' : '../user_page.php';
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
    <main>
    <div class="management">
        <div class="left-menu">
            <div class="menu-heading"><strong>Trang quản trị</strong></div>
            <div class="menu-items">
                <ul>
                    <li><a href="../admin.php">Thông tin admin</a></li>
                    <li><a href="../qttintuc.php">Tin tức</a></li>
                    <li><a href="qtsp.php">Sản phẩm</a></li>
                    <li><a href="../admin_order2.php">Đơn hàng</a></li>
                </ul>
            </div>
        </div>

        <div class="product-display">
            <div class="adding">
                <a href="qtsp_add.php" class="btn">+ Thêm sản phẩm</a>
            </div>
            <table class="product-display-table">
                <tr>
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Kích cỡ</th>
                    <th>Mô tả</th>
                    <th>Loại</th>
                    <th>Quản lý</th>
                </tr>
                <?php
                $select = mysqli_query($conn, "SELECT * FROM products");
                while ($row = mysqli_fetch_assoc($select)) {
                ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['image1'])): ?>
                                <img src="Anh/<?php echo $row['image1']; ?>" height="100" alt="">
                            <?php endif; ?>
                            <?php if (!empty($row['image2'])): ?>
                                <img src="Anh/<?php echo $row['image2']; ?>" height="100" alt="">
                            <?php endif; ?>
                            <?php if (!empty($row['image3'])): ?>
                                <img src="Anh/<?php echo $row['image3']; ?>" height="100" alt="">
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['name']; ?></td>
                        <td>$<?php echo $row['price']; ?></td>
                        <td><?php echo $row['size']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td>
                            <a href="qtsp_update.php?edit=<?php echo $row['id']; ?>" class="btn"><i class="fas fa-edit"></i> Sửa </a>
                            <a href="qtsp.php?delete=<?php echo $row['id']; ?>" class="btn"><i class="fas fa-trash"></i> Xoá </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    </main>
</body>
</html>