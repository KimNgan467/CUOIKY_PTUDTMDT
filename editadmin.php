<?php
session_start(); // Bắt đầu phiên làm việc

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "dieuhuyen"; 
$password = "123456"; 
$dbname = "register"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin người dùng (giả sử ID được truyền từ URL)
$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user = null;

if ($userId > 0) {
    $sql = "SELECT * FROM userform WHERE id = $userId";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy người dùng.";
    }
}

// Xử lý dữ liệu biểu mẫu khi được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    // Kiểm tra mật khẩu xác nhận
    if ($password === $confirmpassword) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Băm mật khẩu

        // Cập nhật thông tin người dùng
        $updateSql = "UPDATE userform SET name = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("sssi", $name, $email, $hashedPassword, $userId);

        if ($stmt->execute()) {
            echo "Cập nhật thành công.";
            header("Location: admin.php"); // Chuyển hướng về trang admin
            exit();
        } else {
            echo "Có lỗi xảy ra: " . $stmt->error;
        }
    } else {
        echo "Mật khẩu không khớp.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editadmin.css">
    <style>
        /* CSS sẽ được đặt ở đây */
    </style>
</head>
<body>
    <div class="container">
        <form method="post" onsubmit="return validateData();">
            <h2>Sửa thông tin</h2>
            <div class="form_group">
                <label>Tên</label>
                <input required type="text" name="name" class="form_control" value="<?php echo htmlspecialchars($user['name']); ?>">
            </div>
            <div class="form_group">
                <label>Email</label>
                <input required type="email" name="email" class="form_control" value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>
            <div class="form_group">
                <label>Mật khẩu</label>
                <input required type="password" name="password" class="form_control">
            </div>
            <div class="form_group">
                <label>Xác nhận mật khẩu</label>
                <input required type="password" name="confirmpassword" class="form_control">
            </div>
            <div class="form_group">
                <button type="submit" class="button btn_save">Lưu</button>
                <a href="admin.php">
                    <button type="button" class="button btn_back">Quay lại</button>
                </a>
            </div>
        </form>
    </div>
</body>
</html>