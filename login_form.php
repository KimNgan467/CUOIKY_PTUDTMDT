<?php
// Bắt đầu phiên làm việc
session_start();

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
            if ($row['usertype'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                header('location:admin_page.php');
                exit();
            } elseif ($row['usertype'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                header('location:trangchu.php');
                exit();
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
   <link rel="stylesheet" href="login.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
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
 <main>
<div class="form-container">

<form name="loginForm" action="login_form.php" method="post" onsubmit="return validateName()">
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
</main>

</body>
</html>
