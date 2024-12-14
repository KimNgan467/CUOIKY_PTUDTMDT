<?php
session_start(); // Bắt đầu phiên làm việc

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "vidu";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin người dùng (giả sử ID được truyền từ URL)
$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user = null;

if ($userId > 0) {
    $sql = "SELECT * FROM userform WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy người dùng.";
        exit(); // Dừng thực thi nếu không tìm thấy người dùng
    }
}

// Xử lý dữ liệu biểu mẫu khi được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $usertype = $_POST['usertype']; // Lấy giá trị usertype từ form

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Cập nhật thông tin người dùng, không bao gồm email và mật khẩu
        $updateUserSql = "UPDATE userform SET name = ?, usertype = ? WHERE id = ?";
        $stmtUser = $conn->prepare($updateUserSql);
        $stmtUser->bind_param("ssi", $name, $usertype, $userId);
        $stmtUser->execute();

        // Cam kết giao dịch
        $conn->commit();

        echo "Cập nhật thành công.";
        header("Location: admin.php"); // Chuyển hướng về trang admin
        exit();
    } catch (Exception $e) {
        // Nếu có lỗi, hoàn tác giao dịch
        $conn->rollback();
        echo "Có lỗi xảy ra: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editadmin.css">
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
                <input type="email" name="email" class="form_control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            </div>
            <div class="form_group">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form_control" value="" readonly>
            </div>
            <div class="form_group">
                <label>Xác nhận mật khẩu</label>
                <input type="password" name="confirmpassword" class="form_control" value="" readonly>
            </div>
            <div class="form_group">
                <label>Loại người dùng</label>
                <select name="usertype" class="form_control">
                    <option value="admin" <?php echo ($user['usertype'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="user" <?php echo ($user['usertype'] == 'user') ? 'selected' : ''; ?>>User</option>
                </select>
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
