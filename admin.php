<?php
session_start(); // Bắt đầu phiên làm việc

$servername = "localhost";
$username = "dieuhuyen"; 
$password = "123456"; 
$dbname = "register"; // Đổi tên nếu cần

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$sql = "SELECT * FROM userform";
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

<html>
<head>
    <link rel="stylesheet" href="admin.css">
    <style>
    </style>
</head>
<body>
<div id="admin-heading-panel">
                <div class="container">
                    <div class="left-panel">
                        Xin chào <span><?= $_SESSION['admin_name'] ?></span>
                    </div>
                    <div class="right-panel">
                        <a href="logout.php">Đăng xuất</a>
                    </div>
                </div>
            </div>
            <div id="content-wrapper">
                <div class="container">
                    <div class="left-menu">
                        <div class="menu-heading">Trang quản trị</div>
                        <div class="menu-items">
                            <ul>
                                <li><a href="admin.php">Thông tin admin</a></li>
                                <li><a href="#">Tin tức</a></li>
                                <li><a href="#">Sản phẩm</a></li>
                                <li><a href="#">Đơn hàng</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="admininfo">
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
            <?php
            foreach($userlist as $item) {
                echo '
                <tr>
                    <td>'.$item['id'].'</td>
                    <td>'.$item['name'].'</td>
                    <td>'.$item['email'].'</td>
                    <td>'.$item['password'].'</td>
                    <td>'.$item['usertype'].'</td>
                    <td>
                    <a href = "editadmin.php?id='.$item['id'].'"><button class = "button btn_edit">Sửa</button></a>
                    </td>
                    <td>
                    <a href = "deleteadmin.php?id='.$item['id'].'"><button class = "button btn_delete">Xóa</button></a>
                    </td>
                </tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

</body>
</html>