<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng về trang login
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit();
}

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vidu";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin người dùng từ session
$user_email = $_SESSION['user_email'];

// Truy vấn thông tin người dùng từ cơ sở dữ liệu (bao gồm profile_username)
$sql = "SELECT profile_username, profile_name, profile_email, profile_bio, profile_birthday FROM userprofile WHERE profile_email = '$user_email'";
$result = $conn->query($sql);

// Kiểm tra nếu tìm thấy thông tin người dùng
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Không tìm thấy thông tin người dùng.");
}

// Kiểm tra khi người dùng nhấn nút 'Lưu thay đổi' cho Tab Chung
if (isset($_POST['submit_chung'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Cập nhật thông tin người dùng trong Tab Chung
    $update_sql = "UPDATE userprofile SET profile_name = '$name' WHERE profile_email = '$user_email'";
    
    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['user_name'] = $name;  // Cập nhật tên trong session
        // Thông báo cập nhật thành công và chuyển hướng
        echo "<script>
                alert('Bạn đã cập nhật thông tin thành công');
                window.location.href = 'user_page.php'; // Thay thế 'your_page.php' với trang bạn muốn chuyển hướng
              </script>";
    } else {
        echo "<script>alert('Lỗi cập nhật thông tin: " . $conn->error . "');</script>";
    }
}

// Kiểm tra khi người dùng nhấn nút 'Lưu thay đổi' cho Tab Giới thiệu
if (isset($_POST['submit_gioithieu'])) {
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    
    // Cập nhật thông tin người dùng trong Tab Giới thiệu
    $update_sql = "UPDATE userprofile SET profile_bio = '$bio', profile_birthday = '$birthday' WHERE profile_email = '$user_email'";
    
    if ($conn->query($update_sql) === TRUE) {
        // Thông báo cập nhật thành công và chuyển hướng
        echo "<script>
                alert('Thông tin giới thiệu đã được cập nhật');
                window.location.href = 'user_page.php'; // Thay thế 'your_page.php' với trang bạn muốn chuyển hướng
              </script>";
    } else {
        echo "<script>alert('Lỗi cập nhật thông tin: " . $conn->error . "');</script>";
    }
}

// Kiểm tra khi người dùng thay đổi cài đặt thông báo
if (isset($_POST['submit_notifications'])) {
    $notify_likes = isset($_POST['notify_likes']) ? 1 : 0;
    $notify_replies = isset($_POST['notify_replies']) ? 1 : 0;
    $notify_news = isset($_POST['notify_news']) ? 1 : 0;
    $notify_products = isset($_POST['notify_products']) ? 1 : 0;

    // Cập nhật cài đặt thông báo của người dùng
    $update_notify_sql = "UPDATE userprofile SET 
                            notify_likes = '$notify_likes',
                            notify_replies = '$notify_replies',
                            notify_news = '$notify_news',
                            notify_products = '$notify_products'
                            WHERE profile_email = '$user_email'";

    if ($conn->query($update_notify_sql) === TRUE) {
        // Thông báo cập nhật thành công và chuyển hướng
        echo "<script>
                alert('Cài đặt thông báo đã được cập nhật');
                window.location.href = 'your_page.php'; // Thay thế 'your_page.php' với trang bạn muốn chuyển hướng
              </script>";
    } else {
        echo "<script>alert('Lỗi cập nhật cài đặt thông báo: " . $conn->error . "');</script>";
    }
}

// Đóng kết nối
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodingDung | Profile Template</title>
    <link rel="stylesheet" href="userprofilestyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Hàm để chuyển đổi giữa chế độ chỉnh sửa và chỉ đọc
        function toggleEditMode(tabId) {
            if (tabId === 'chung') {
                document.getElementById('name').disabled = false;
                document.getElementById('email').disabled = false;
                document.getElementById('editBtnChung').style.display = 'none';
                document.getElementById('saveBtnChung').style.display = 'inline-block';
            } else if (tabId === 'gioithieu') {
                document.getElementById('bio').disabled = false;
                document.getElementById('birthday').disabled = false;
                document.getElementById('editBtnGioithieu').style.display = 'none';
                document.getElementById('saveBtnGioithieu').style.display = 'inline-block';
            }
        }
    </script>
</head>
<body>
    <div class="container light-style flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center py-3 mb-4">
        <h4 class="font-weight-bold">Quản lý tài khoản</h4>
        <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
    </div>

        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">Chung</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Giới thiệu tài khoản</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-notifications">Cài đặt thông báo</a>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="tab-content">
                        <!-- Tab Chung -->
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt class="d-block ui-w-80">
                                <div class="media-body ml-4">
                                    <label class="btn btn-outline-primary">
                                        Cập nhật ảnh đại diện
                                        <input type="file" class="account-settings-fileinput">
                                    </label> &nbsp;
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <form action="" method="POST">
                                <div class="form-group">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control mb-1" value="<?php echo $row['profile_username']; ?>" disabled>
                                </div>

                                    <div class="form-group">
                                        <label class="form-label">Tên người dùng</label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $row['profile_name']; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control mb-1" name="email" id="email" value="<?php echo $row['profile_email']; ?>" disabled>
                                    </div>
                                    <!-- Các nút điều khiển -->
                                    <button type="button" id="editBtnChung" class="btn btn-secondary" onclick="toggleEditMode('chung')">Chỉnh sửa</button>
                                    <button type="submit" name="submit_chung" id="saveBtnChung" class="btn btn-primary" style="display:none;">Lưu thay đổi</button>
                                </form>
                            </div>
                        </div>

                        <!-- Tab Giới thiệu -->
                        <div class="tab-pane fade" id="account-info">
                            <div class="card-body pb-2">
                                <form action="" method="POST">
                                    <h6 class="mb-4">Giới thiệu tài khoản</h6>
                                    
                                    <div class="form-group">
                                        <label class="form-label">Ngày sinh</label>
                                        <input type="text" class="form-control" name="birthday" id="birthday" value="<?php echo $row['profile_birthday']; ?>" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Mô tả</label>
                                        <textarea class="form-control" name="bio" id="bio" rows="5" disabled><?php echo $row['profile_bio']; ?></textarea>
                                    </div>
                                    </br>
                                    <!-- Các nút điều khiển -->
                                    <button type="button" id="editBtnGioithieu" class="btn btn-secondary" onclick="toggleEditMode('gioithieu')">Chỉnh sửa</button>
                                    <button type="submit" name="submit_gioithieu" id="saveBtnGioithieu" class="btn btn-primary" style="display:none;">Lưu thay đổi</button>
                                </form>
                            </div>
                        </div>

                        <!-- Tab Cài đặt thông báo -->
                        <div class="tab-pane fade" id="account-notifications">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Hoạt động</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Thông báo khi người khác thích bình luận của bạn</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Thông báo khi người khác trả lời bình luận của bạn</span>
                                    </label>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Thông báo khác</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Thông báo khi có tin tức mới</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Thông báo khi có sản phẩm mới</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Thông báo tin tức gợi ý cho bạn</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mt-3">
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
