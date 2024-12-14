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


if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM news WHERE id = $id");
    header('location:qttintuc.php');
};
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
<!DOCTYPE html>
<html>
    <head>
        <title>QUẢN TRỊ TIN TỨC</title>
        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- custom css file link  -->
        <link rel="stylesheet" href="quantri1.css">
    </head>
    <body>  
    <header>
    <img src="./Anh/Logo.png" alt="Logo" />
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
                <a href="
                <?php 
                    // Kiểm tra usertype và chuyển hướng tới trang tương ứng
                    echo ($_SESSION['usertype'] == 'admin') ? 'admin.php' : 'user_page.php';
                ?>
                " class="user-greeting">
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
    <?php
    if(isset($message)){
        foreach($message as $message){
        echo '<span class="message">'.$message.'</span>';
        }
    }
    ?>
    <div class="management">
        <div class="left-menu">
                        <div class="menu-heading"><strong>Trang quản trị</strong></div>
                        <div class="menu-items">
                            <ul>
                                <li><a href="admin.php">Thông tin tài khoản</a></li>
                                <li><a href="qttintuc.php">Tin tức</a></li>
                                <li><a href="./sản phẩm/qtsp.php">Sản phẩm</a></li>
                                <li><a href="admin_order2.php">Đơn hàng</a></li>
                            </ul>
                        </div>
                        </div>
    <?php
        $select = mysqli_query($conn, "SELECT * FROM news");
    ?>
        <div class="news-display">
            <div class="adding">
        <a href="qttintuc_add.php?add=<?php $_SERVER['PHP_SELF'] ?>" class="btn">+Thêm tin tức</a>
        </div>
        <table class="news-display-table">
            <tr>
            <th>Ảnh</th>
            <th>Tin tức</th>
            <th>Ngày thêm</th>
            <th>Tác giả</th>
            <th>Nội dung</th>
            <th>Link bài viết</th>
            <th>Quản lý</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
         <td><img src="picture/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><?php echo $row['content']; ?></td>
            <td><a href="<?php echo $row['link']; ?>" target="_blank">Xem bài viết</a></td>
            <td>
               <a href="qttintuc_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> Sửa </a>
               <a href="qttintuc_add.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> Xoá </a>
            </td>
         </tr>
      <?php } ?>
        </table>
        </div>
    </div>
    </div>
</main>
</body>
</html>
