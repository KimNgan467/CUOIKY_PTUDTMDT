<?php

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

// Xử lý khi form được submit
if (isset($_POST['submit'])) {
    // Lấy và bảo vệ dữ liệu đầu vào từ người dùng
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];  // Lưu mật khẩu không qua md5 ngay lập tức
    $cpassword = $_POST['cpassword'];
    $usertype = $_POST['usertype'];
    $usertype = isset($_POST['usertype']) ? $_POST['usertype'] : 'user';

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

            // Chèn người dùng vào bảng userform
            $insert_userform = "INSERT INTO userform(name, email, password, usertype) VALUES('$name', '$email', '$hashed_password', '$usertype')";
            $insert_userform_result = mysqli_query($conn, $insert_userform);

            if ($insert_userform_result) {
                // Sau khi người dùng được chèn vào bảng userform, tiếp tục chèn vào bảng userprofile
                // Lấy tên người dùng (username) từ email hoặc tên đã nhập
                $profile_username = strtolower(str_replace(' ', '', $name));  // Ví dụ lấy tên đầy đủ để làm username

                // Bạn có thể thêm thêm thông tin về ngày sinh, bio nếu muốn trong userprofile
                $profile_bio = "Chưa có thông tin giới thiệu"; // Có thể thay đổi theo yêu cầu
                $profile_birthday = "Chưa có thông tin ngày sinh"; // Thêm thông tin ngày sinh mặc định hoặc lấy từ form nếu có

                $insert_userprofile = "INSERT INTO userprofile(profile_username, profile_name, profile_email, profile_password, profile_bio, profile_birthday) 
                                       VALUES('$profile_username', '$name', '$email', '$hashed_password', '$profile_bio', '$profile_birthday')";
                $insert_userprofile_result = mysqli_query($conn, $insert_userprofile);

                // Kiểm tra việc chèn người dùng vào bảng userprofile
                if ($insert_userprofile_result) {
                    // Chuyển hướng đến trang đăng nhập sau khi đăng ký thành công
                    header('Location: login_form.php');
                    exit();
                } else {
                    die('Lỗi khi thêm người dùng vào bảng userprofile: ' . mysqli_error($conn));
                }
            } else {
                die('Lỗi khi thêm người dùng vào bảng userform: ' . mysqli_error($conn));
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

   <!-- Link tới file CSS tùy chỉnh -->
   <link rel="stylesheet" href="register_form.css">
</head>



<body>

<div class="form-container">

   <form action="" method="POST">
      <h3>Đăng ký ngay</h3>
      <?php
      if (isset($error)) {
         foreach ($error as $error) {
            echo '<span class="error-msg">' . $error . '</span>';
         }
      }
      ?>
      <input type="text" name="name" required placeholder="Nhập tên của bạn">
      <input type="email" name="email" required placeholder="Nhập email của bạn">
      <input type="password" name="password" required placeholder="Nhập mật khẩu của bạn">
      <input type="password" name="cpassword" required placeholder="Xác nhận mật khẩu">
      <input type="hidden" name="usertype" value="user">
      <input type="submit" name="submit" value="Đăng ký ngay" class="form-btn">
      <p>Đã có tài khoản? <a href="login_form.php">Đăng nhập ngay</a></p>
   </form>

</div>

</body>
</html>
