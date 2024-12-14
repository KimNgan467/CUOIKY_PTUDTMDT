<?php
session_start();  // Bắt đầu phiên làm việc

// Kiểm tra nếu người dùng đã đăng nhập
$is_logged_in = false;
if (isset($_SESSION['user_email'])) {
    $is_logged_in = true;
    $username = $_SESSION['user_name'];  // Lấy tên người dùng từ session
} else {
    $username = '';
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
    <title>TRANG CÁ NHÂN</title>
    <link rel="stylesheet" href="userprofilestyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>/* Khung bao quanh header */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 25px 30px;
    background-color: #05719D;  /* Màu nền tối cho header */
    color: white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Thêm bóng đổ nhẹ cho header */
    
}

/* Logo */
header img {
    height: 45px;
}

/* Phần menu bên trái */
.header-left {
    display: flex;
    align-items: center;
}

.header-left a {
    color: white;
    text-decoration: none;
    margin: 10px 80px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 18px;
    position: relative;
    transition: color 0.3s ease, transform 0.3s ease; /* Hiệu ứng chuyển động cho màu và kích thước */
    padding: 8px 12px; /* Thêm padding để tạo không gian cho khung */
    border-radius: 5px; /* Bo góc cho khung */
    font-family: 'Times New Roman', Times, serif;
}

/* Thêm hiệu ứng hover cho các liên kết menu */
.header-left a:hover {
    text-decoration: none;
}
.header-left a::before { 
    content: "";
    position: absolute;
    bottom: 0; 
    left: 0;
    width: 100%;
    height: 2px; 
    background-color: transparent; 
    transition: background-color 0.3s ease; 
}
.header-left a:hover::before {
    background-color: #A0D5E8; 
}
/* Menu dropdown */
.drop-down {
    position: relative; /* Đảm bảo dropdown được đặt đúng vị trí */
}

.detail {
    display: none; /* Ẩn dropdown mặc định */
    position: absolute;
    background-color: #ffffff; /* Màu nền trắng cho dropdown */
    border-radius: 8px; /* Bo góc */
    min-width: 10px; /* Chiều rộng tối thiểu */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Bóng đổ mạnh hơn */
    z-index: 10; /* Đảm bảo dropdown luôn ở trên các phần tử khác */
    transition: opacity 0.3s ease, visibility 0.3s ease; /* Hiệu ứng chuyển động cho dropdown */
    opacity: 0; /* Bắt đầu với độ mờ */
    visibility: hidden; /* Ẩn dropdown */
}

.drop-down:hover .detail {
    display: block; /* Hiển thị dropdown khi hover */
    opacity: 1; /* Đưa độ mờ về 1 */
    visibility: visible; /* Thay đổi thành visible khi hiển thị */
}

.detail a {
    color: #05719D; /* Màu chữ cho các mục con */
    text-decoration: none; /* Bỏ gạch chân */
    padding: 10px 15px; /* Khoảng cách cho các mục */
    display: block; /* Thay đổi thành block để dễ dàng nhấp chuột */
    text-align: left; /* Căn trái nội dung */
    font-size: 16px; /* Kích thước chữ */
    transition: background-color 0.3s ease, color 0.3s ease; /* Hiệu ứng chuyển động cho màu nền và chữ */
    white-space: nowrap; /* Ngăn không cho chữ bị xuống dòng */
}

.detail a:hover {
    background-color: rgba(0, 87, 115, 0.1); /* Màu nền khi hover vào các mục con */
    color:black; /* Màu chữ thay đổi khi hover */
    border-radius: 8px; /* Bo góc cho mục khi hover */
    transform: translateY(-2px); /* Hiệu ứng di chuyển nhẹ lên khi hover */
}

/* Thêm một hiệu ứng cho dropdown khi hiển thị */
.drop-down:hover .detail {
    animation: fadeIn 0.3s ease; /* Hiệu ứng fade in khi hiển thị */
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px); /* Di chuyển nhẹ lên trên */
    }
    to {
        opacity: 1;
        transform: translateY(0); /* Về vị trí ban đầu */
    }
}
/* Phần menu bên phải */
.header-right {
    display: flex;
    align-items: center;
}

/* Giỏ hàng */
.header-right a {
    color: white;
    text-decoration: none;
    margin-left: 25px;
    font-size: 20px;
    transition: all 0.3s ease;
}

.header-right a:hover {
    color:#D7F9FD;
    transform: translateY(-3px);
}
/*Người dùng*/
/* Biểu tượng người dùng */
.user-info a {
    color: white;
    margin-left: 25px;
    font-size: 20px;
}
/* Hiệu ứng hover cho biểu tượng người dùng */
.user-info a:hover {
    color: #D7F9FD;
    transform: translateY(-3px);
}
/* Đặc biệt đối với người dùng đã đăng nhập */
.user-info .user-greeting {
    margin-right: 20px;
}
/* Liên kết đăng xuất */
.logout-link {
    color: white;
    font-size: 20px;
    margin-left: 10px;
}
.logout-link:hover {
    color: #D7F9FD;
}
/* Thêm hiệu ứng cho các liên kết khi active và focus */
header a:active, header a:focus {
    outline: none;
}</style>
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
<header>
            <img src="./Anh/Logo.png">
        <div class="header-left">
            <a href="trangchu1.php"><strong>TRANG CHỦ</strong></a>
            <div class="drop-down">
            <a href="./sản phẩm/sp.php"><strong>SẢN PHẨM</strong></a>
                <div class="detail">
                    <a href="./sản phẩm/danhmucanimals.php"><strong>ANIMALS</strong></a>
                    <a href="./sản phẩm/danhmucbags&charms.php"><strong>BAGS & CHARMS</strong></a>
                    <a href="./sản phẩm/danhmucamuseables.php"><strong>AMUSEABLES</strong></a>
                    <a href="./sản phẩm/danhmucgifts.php"><strong>GIFTS</strong></a>
                </div>
            </div>
            <a href="tintuc.php"><strong>TIN TỨC</strong></a>
        </div>



        <div class="header-right">
            <div class="search-bar">
                
                <a href="cart.php"><i class="fa fa-shopping-cart"></i></a>
            </div>
            <!-- Nếu người dùng đã đăng nhập -->
        <?php if ($is_logged_in): ?>
            <div class="user-info">
            <a href="
            <?php 
                // Kiểm tra usertype và chuyển hướng tới trang tương ứng
                if ($_SESSION['usertype'] == 'admin') {
                    echo 'admin.php';  // Trang admin
                } else {
                    echo 'user_page.php';  // Trang user
                }
            ?>
        " class="user-greeting">
            <i class="fa fa-user"></i>
        </a>
                <a href="logout.php" class="logout-link"><i class="fa fa-sign-out-alt"></i></a>
            </div>
        <?php else: ?>
            <div class="user-info">
            <a href="login_form.php" class="login-link">
                <i class="fa fa-user"></i>
            </a>
            </div>
        <?php endif; ?>
        </div>
            

    </header>
    <div class="container light-style flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center py-3 mb-4">
    <h4 class="font-weight-bold">Quản lý tài khoản</h4>
    <div class="button-group">
        <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
        <a href="trangchu1.php"><button type="button" class="btn btn-back">Quay lại</button></a>
    </div>
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
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <form action="" method="POST">
                                <h6 class="mb-4">Chung</h6>
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
