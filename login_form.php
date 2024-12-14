<?php
// Bắt đầu phiên làm việc
session_start();

// Kết nối đến cơ sở dữ liệu
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

if (isset($_POST['submit'])) {
    // Bảo vệ dữ liệu đầu vào từ người dùng
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password']; // Mật khẩu đăng nhập
    $error = [];

    // Kiểm tra nếu người dùng đã đăng ký với email này
    $select = "SELECT * FROM userform WHERE email = '$email'";

    // Thực thi câu truy vấn
    $result = mysqli_query($conn, $select);

    // Kiểm tra nếu có lỗi trong truy vấn
    if (!$result) {
        die('Lỗi truy vấn: ' . mysqli_error($conn));
    }

    // Nếu tìm thấy người dùng với email
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        // Kiểm tra mật khẩu bằng cách sử dụng password_verify
        if (password_verify($pass, $row['password'])) {
            // Nếu đăng nhập thành công
            // Lưu thông tin người dùng vào session
            $_SESSION['user_email'] = $row['email'];  // Lưu email vào session
            $_SESSION['user_name'] = $row['name'];    // Lưu tên người dùng vào session
            $_SESSION['usertype'] = $row['usertype']; // Lưu loại người dùng vào session

            // Kiểm tra nếu là admin thì chuyển hướng đến trang admin
            if ($row['usertype'] == 'admin') {
                header('location: admin.php');
                exit();
            } elseif ($row['usertype'] == 'user') {
                // Nếu có URL trong session (người dùng đến từ trang thanh toán)
                if (isset($_SESSION['redirect_to'])) {
                    $redirect_url = $_SESSION['redirect_to'];  // Lấy URL từ session
                    unset($_SESSION['redirect_to']);  // Xóa URL khỏi session sau khi điều hướng
                    header("Location: $redirect_url");  // Chuyển hướng đến trang thanh toán
                    exit();
                } else {
                    header('location: trangchu1.php');  // Nếu không có URL, chuyển hướng về trang chủ
                    exit();
                }
            }
        } else {
            // Mật khẩu sai
            $error[] = 'Email hoặc mật khẩu không chính xác!';
        }

    } else {
        // Email không tồn tại
        $error[] = 'Email hoặc mật khẩu không chính xác!';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>
   <link rel="stylesheet" href="login_form.css">
</head>

<body>
   
<div class="form-container">

   <form action="" method="POST">
      <h3>ĐĂNG NHẬP TÀI KHOẢN</h3>
      <?php
      if (isset($error)) {
         foreach ($error as $err) {
            echo '<span class="error-msg">' . $err . '</span>';
         };
      };
      ?>
      <label for="email">Email*</label>
      <input type="email" name="email" required placeholder="Nhập vào email...">
      <label for="password">Mật khẩu*</label>
      <input type="password" name="password" required placeholder="Nhập vào mật khẩu...">
      <input type="submit" name="submit" value="Đăng nhập" class="form-btn">
      <p>Bạn chưa có tài khoản? <a href="register_form.php">Đăng ký ngay</a></p>
   </form>

</div>

</body>
</html>
