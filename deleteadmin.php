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

// Kiểm tra nếu ID người dùng được truyền từ URL
$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($userId > 0) {
        // Lấy email của người dùng để xóa từ profile_email
        $emailToDelete = isset($_POST['email']) ? $_POST['email'] : '';

        // Bắt đầu giao dịch
        $conn->begin_transaction();

        try {
            // Xóa thông tin người dùng
            $deleteUserSql = "DELETE FROM userform WHERE id = ?";
            $stmtUser = $conn->prepare($deleteUserSql);
            $stmtUser->bind_param("i", $userId);
            $stmtUser->execute();

            // Xóa email từ profile_email
            $deleteEmailSql = "DELETE FROM userprofile WHERE profile_email = ?";
            $stmtEmail = $conn->prepare($deleteEmailSql);
            $stmtEmail->bind_param("s", $emailToDelete);
            $stmtEmail->execute();

            // Cam kết giao dịch
            $conn->commit();

            echo "Xóa thành công.";
            header("Location: admin.php"); // Chuyển hướng về trang admin
            exit();
        } catch (Exception $e) {
            // Nếu có lỗi, hoàn tác giao dịch
            $conn->rollback();
            echo "Có lỗi xảy ra: " . $e->getMessage();
        }
    } else {
        echo "ID không hợp lệ.";
    }
}

// Lấy thông tin người dùng để xác nhận
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
        exit();
    }
} else {
    echo "ID không hợp lệ.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="deleteadmin.css">
    <style>
        /* CSS có thể được thêm vào đây */
    </style>
</head>
<body>
    <div class="container">
        <form method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['usertype']) ?>) không?');">
            <h2>Xác nhận xóa</h2>
            <?php if ($user): ?>
                <div class="info">
                    <p><strong>Tên:</strong> <?= htmlspecialchars($user['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Loại người dùng:</strong> <?= htmlspecialchars($user['usertype']) ?></p>
                </div>
                <div class="form_group">
                    <input type="hidden" name="name" value="<?= $user['name'] ?>">
                    <input type="hidden" name="email" value="<?= $user['email'] ?>">
                </div>
                <div class="form_group">
                    <button type="submit" class="button btn_confirmdelete">Xác nhận xóa</button>
                    <a href="admin.php">
                        <button type="button" class="button btn_back">Quay lại</button>
                    </a>
                </div>
            <?php else: ?>
                <p class="error">Không thể xác nhận xóa. Vui lòng cung cấp ID hợp lệ.</p>
                <a href="admin.php">
                    <button type="button" class="button btn_back">Quay lại</button>
                </a>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>