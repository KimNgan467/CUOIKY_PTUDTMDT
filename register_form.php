<?php

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "userdb"; // Đổi tên nếu cần

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý khi form được submit
if (isset($_POST['submit'])) {
    // Lấy và bảo vệ dữ liệu đầu vào từ người dùng
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];  // Lưu mật khẩu không qua md5 ngay lập tức
    $cpassword = $_POST['cpassword'];
    $usertype = $_POST['usertype'];

    //Mặc định đăng ký là user//
    $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : 'user';
    // Kiểm tra xem người dùng đã tồn tại chưa
    $select = "SELECT * FROM userform WHERE email = '$email'";

    // Thực thi câu truy vấn
    $result = mysqli_query($conn, $select);

    // Kiểm tra lỗi nếu truy vấn không thành công
    if (!$result) {
        die('Truy vấn không thành công: ' . mysqli_error($conn)); // In ra lỗi nếu có
    }

    // Kiểm tra nếu người dùng đã tồn tại
    if (mysqli_num_rows($result) > 0) {
        $error[] = 'Người dùng đã tồn tại!';
    } else {
        // Kiểm tra mật khẩu và mật khẩu xác nhận có khớp không
        if ($password != $cpassword) {
            $error[] = 'Mật khẩu không khớp!';
        } else {
            // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Chèn người dùng mới vào cơ sở dữ liệu
            $insert = "INSERT INTO userform(name, email, password, usertype) VALUES('$name', '$email', '$hashed_password', '$usertype')";
            $insert_result = mysqli_query($conn, $insert);

            // Kiểm tra việc chèn người dùng
            if ($insert_result) {
                // Chuyển hướng đến trang đăng nhập sau khi đăng ký thành công
                header('Location: login_form.php');
                exit();
            } else {
                die('Lỗi khi thêm người dùng: ' . mysqli_error($conn)); // In ra lỗi nếu có khi thêm người dùng
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đăng ký tài khoản</title>
   <link rel="stylesheet" href="register.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

   <!-- Link tới file CSS tùy chỉnh -->
 
</head>
<body>
    <header>
            <img src="./Ảnh/Logo.png">
        <div class="header-left">
            <a href="#"><strong>TRANG CHỦ</strong></a>
            <div class="drop-down">
            <a href="#"><strong>SẢN PHẨM</strong></a>
                <div class="detail">
                    <a href="#"><strong>ANIMALS</strong></a>
                    <a href="#"><strong>BAGS & CHARMS</strong></a>
                    <a href="#"><strong>AMUSEABLES</strong></a>
                </div>
            </div>
            <a href="#"><strong>THANH TOÁN</strong></a>
            <a href="news.php"><strong>TIN TỨC</strong></a>
        </div>
        <div class="header-right">
            <div class="search-bar">
                <form action="#" method="get">
                    <input type="text" name="timkiem" placeholder="Tìm kiếm...">
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
                <a href="cart.html"><i class="fa fa-shopping-cart"></i></a>
                <a href="login_form.php"><i class="fa fa-user"></i></a>
            </div>
        </div>
 </header>

<div class="form-container">

<form name="registerForm" action="register_form.php" method="post" onsubmit="return validateName()">
      <h3>Đăng ký ngay</h3>
      <?php
      if (isset($error)) {
         foreach ($error as $error) {
            echo '<span class="error-msg">' . $error . '</span>';
         }
      }
      ?>
      <label for="name">Tên người dùng*</label>
      <input type="text" name="name" required placeholder="Nhập vào tên...">
      <label for="email">Email*</label>
      <input type="email" name="email" required placeholder="Nhập vào email...">
      <label for="password">Mật khẩu*</label>
      <input type="password" name="password" required placeholder="Nhập vào password...">
      <label for="cpassword">Xác nhận mật khẩu*</label>
      <input type="password" name="cpassword" required placeholder="Nhập lại mật khẩu...">
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>Bạn đã có tài khoản? <a href="login_form.php">Đăng nhập ngay</a></p>
   </form>
    </div>
</body>
</html>
