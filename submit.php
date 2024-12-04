<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit</title>
</head>
<body>
<h1>Thông tin người dùng</h1>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Lấy dữ liệu từ query string
    $hoten = isset($_GET['hoten']) ? htmlspecialchars($_GET['hoten']) : '';
    $email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
    $gender = isset($_GET['gender']) ? htmlspecialchars($_GET['gender']) : '';
    $ngaysinh = isset($_GET['ngaysinh']) ? htmlspecialchars($_GET['ngaysinh']) : '';
    $sothich = isset($_GET['sothich']) ? htmlspecialchars($_GET['sothich']) : '';

    // Hiển thị thông tin người dùng
    echo "<ul>";
    echo "<li>Họ tên: " . $hoten . "</li>";
    echo "<li>Email: " . $email . "</li>";
    echo "<li>Giới tính: " . $gender . "</li>";
    echo "<li>Ngày sinh: " . $ngaysinh . "</li>";
    echo "<li>Sở thích: " . $sothich . "</li>";
    echo "</ul>";
} else {
    echo "Không có dữ liệu để hiển thị.";
}
?>
</body>
</html>
