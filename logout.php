<?php
// Bắt đầu phiên làm việc
session_start();

// Hủy session và đăng xuất người dùng
session_unset();  // Xóa tất cả biến trong session
session_destroy();  // Hủy phiên

// Chuyển hướng người dùng về trang chủ sau 3 giây
header("Refresh: 3; url=trangchu1.php");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Xuất</title>
    <style>
        .box-content {
            margin: 0 auto;
            width: 800px;
            border: 1px solid #ccc;
            text-align: center;
            padding: 20px;
        }

        #user_logout form {
            width: 200px;
            margin: 40px auto;
        }

        #user_logout form input {
            margin: 5px 0;
        }

        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div id="user_logout" class="box-content">
    <h1>Đăng xuất tài khoản thành công</h1>
    <p class="message">Bạn sẽ được chuyển về trang chủ trong vài giây...</p>
    <p>Hoặc bạn có thể nhấn vào nút dưới đây để quay lại trang chủ ngay lập tức:</p>
    <a href="trangchu1.php" class="button">Quay về trang chủ</a>
</div>

</body>
</html>
