<?php
session_start();

// Kết nối cơ sở dữ liệu
function ketnoidb() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "vidu";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Kiểm tra nếu người dùng đã đăng nhập
$is_logged_in = false;
$username = '';
if (isset($_SESSION['user_email'])) {
    $is_logged_in = true;
    $username = $_SESSION['user_name'];  // Lấy tên người dùng từ session
}

// Truy vấn đơn hàng theo trạng thái
function layDonHangTheoStatus($status) {
    $conn = ketnoidb();
    $sql = "SELECT customer_id, customer_name, email, address, city, phone, note, totalPrice, status FROM bill WHERE status = :status";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Cập nhật trạng thái đơn hàng
function capNhatTrangThai($orderId, $newStatus) {
    $conn = ketnoidb();
    $sql = "UPDATE bill SET status = :status WHERE customer_id = :customer_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':status', $newStatus, PDO::PARAM_STR);
    $stmt->bindParam(':customer_id', $orderId, PDO::PARAM_INT);

    return $stmt->execute();
}

// Xử lý cập nhật trạng thái khi có yêu cầu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['status']) && isset($_POST['order_id'])) {
        $orderId = (int)$_POST['order_id']; // Chuyển đổi sang kiểu số nguyên
        $newStatus = $_POST['status'];

        if (capNhatTrangThai($orderId, $newStatus)) {
            $_SESSION['update_success'] = true;
        } else {
            $_SESSION['update_success'] = false;
        }

        // Chuyển hướng lại trang hiện tại với biến session để thông báo cập nhật
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUẢN TRỊ ĐƠN HÀNG</title>
    <link rel="stylesheet" href="admin_order2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                
                <a href="./sản phẩm/cart.php"><i class="fa fa-shopping-cart"></i></a>
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
    <main>
    <div class="container">
        <div class="left-menu">
            <div class="menu-heading">Trang quản trị</div>
            <div class="menu-items">
                <ul>
                    <li><a href="admin.php">Thông tin tài khoản</a></li>
                    <li><a href="qttintuc.php">Tin tức</a></li>
                    <li><a href="./sản phẩm/qtsp.php">Sản phẩm</a></li>
                    <li><a href="admin_order2.php">Đơn hàng</a></li>
                </ul>
            </div>
        </div>

        <div class="tabs">
            <ul class="tab-links">
                <li><a href="#choxacnhan">Chờ xác nhận</a></li>
                <li><a href="#dangchuahanh">Đang chuẩn bị hàng</a></li>
                <li><a href="#danggiaohang">Đang giao hàng</a></li>
                <li><a href="#dagiaothanhcong">Đã giao thành công</a></li>
            </ul>

            <div class="tab-content">
                <!-- Tab Chờ Xác Nhận -->
                <div id="choxacnhan" class="tab-panel">
                    <h2>Đơn hàng chờ xác nhận</h2>
                    <table class="tbl-full">
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Địa Chỉ</th>
                            <th>Thành Phố</th>
                            <th>Số Điện Thoại</th>
                            <th>Ghi Chú</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Chỉnh Sửa</th>
                        </tr>
                        <?php
                        $orders = layDonHangTheoStatus('Chờ xác nhận');
                        foreach ($orders as $order) {
                            echo "<tr>";
                            echo "<td>{$order['customer_id']}</td>";
                            echo "<td>{$order['customer_name']}</td>";
                            echo "<td>{$order['email']}</td>";
                            echo "<td>{$order['address']}</td>";
                            echo "<td>{$order['city']}</td>";
                            echo "<td>{$order['phone']}</td>";
                            echo "<td>{$order['note']}</td>";
                            echo "<td>{$order['totalPrice']}</td>";
                            echo "<td>{$order['status']}</td>";
                            echo "<td>
                                    <form method='POST' action=''>
                                        <select name='status'>
                                            <option value='Chờ xác nhận' " . ($order['status'] == 'Chờ xác nhận' ? 'selected' : '') . ">Chờ xác nhận</option>
                                            <option value='Đang chuẩn bị hàng' " . ($order['status'] == 'Đang chuẩn bị hàng' ? 'selected' : '') . ">Đang chuẩn bị hàng</option>
                                            <option value='Đang giao hàng' " . ($order['status'] == 'Đang giao hàng' ? 'selected' : '') . ">Đang giao hàng</option>
                                            <option value='Đã giao thành công' " . ($order['status'] == 'Đã giao thành công' ? 'selected' : '') . ">Đã giao thành công</option>
                                        </select>
                                        <input type='hidden' name='order_id' value='{$order['customer_id']}'>
                                        <button type='submit' class='edit-btn'>Cập nhật</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>

                <!-- Tab Đang Chuẩn Bị Hàng -->
                <div id="dangchuahanh" class="tab-panel">
                    <h2>Đơn hàng đang chuẩn bị hàng</h2>
                    <table class="tbl-full">
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Địa Chỉ</th>
                            <th>Thành Phố</th>
                            <th>Số Điện Thoại</th>
                            <th>Ghi Chú</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Chỉnh Sửa</th>
                        </tr>
                        <?php
                        $orders = layDonHangTheoStatus('Đang chuẩn bị hàng');
                        foreach ($orders as $order) {
                            echo "<tr>";
                            echo "<td>{$order['customer_id']}</td>";
                            echo "<td>{$order['customer_name']}</td>";
                            echo "<td>{$order['email']}</td>";
                            echo "<td>{$order['address']}</td>";
                            echo "<td>{$order['city']}</td>";
                            echo "<td>{$order['phone']}</td>";
                            echo "<td>{$order['note']}</td>";
                            echo "<td>{$order['totalPrice']}</td>";
                            echo "<td>{$order['status']}</td>";
                            echo "<td>
                                    <form method='POST' action=''>
                                        <select name='status'>
                                            <option value='Chờ xác nhận' " . ($order['status'] == 'Chờ xác nhận' ? 'selected' : '') . ">Chờ xác nhận</option>
                                            <option value='Đang chuẩn bị hàng' " . ($order['status'] == 'Đang chuẩn bị hàng' ? 'selected' : '') . ">Đang chuẩn bị hàng</option>
                                            <option value='Đang giao hàng' " . ($order['status'] == 'Đang giao hàng' ? 'selected' : '') . ">Đang giao hàng</option>
                                            <option value='Đã giao thành công' " . ($order['status'] == 'Đã giao thành công' ? 'selected' : '') . ">Đã giao thành công</option>
                                        </select>
                                        <input type='hidden' name='order_id' value='{$order['customer_id']}'>
                                        <button type='submit' class='edit-btn'>Cập nhật</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>

                <!-- Tab Đang Giao Hàng -->
                <div id="danggiaohang" class="tab-panel">
                    <h2>Đơn hàng đang giao hàng</h2>
                    <table class="tbl-full">
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Địa Chỉ</th>
                            <th>Thành Phố</th>
                            <th>Số Điện Thoại</th>
                            <th>Ghi Chú</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Chỉnh Sửa</th>
                        </tr>
                        <?php
                        $orders = layDonHangTheoStatus('Đang giao hàng');
                        foreach ($orders as $order) {
                            echo "<tr>";
                            echo "<td>{$order['customer_id']}</td>";
                            echo "<td>{$order['customer_name']}</td>";
                            echo "<td>{$order['email']}</td>";
                            echo "<td>{$order['address']}</td>";
                            echo "<td>{$order['city']}</td>";
                            echo "<td>{$order['phone']}</td>";
                            echo "<td>{$order['note']}</td>";
                            echo "<td>{$order['totalPrice']}</td>";
                            echo "<td>{$order['status']}</td>";
                            echo "<td>
                                    <form method='POST' action=''>
                                        <select name='status'>
                                            <option value='Chờ xác nhận' " . ($order['status'] == 'Chờ xác nhận' ? 'selected' : '') . ">Chờ xác nhận</option>
                                            <option value='Đang chuẩn bị hàng' " . ($order['status'] == 'Đang chuẩn bị hàng' ? 'selected' : '') . ">Đang chuẩn bị hàng</option>
                                            <option value='Đang giao hàng' " . ($order['status'] == 'Đang giao hàng' ? 'selected' : '') . ">Đang giao hàng</option>
                                            <option value='Đã giao thành công' " . ($order['status'] == 'Đã giao thành công' ? 'selected' : '') . ">Đã giao thành công</option>
                                        </select>
                                        <input type='hidden' name='order_id' value='{$order['customer_id']}'>
                                        <button type='submit' class='edit-btn'>Cập nhật</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>

                <!-- Tab Đã Giao Thành Công -->
                <div id="dagiaothanhcong" class="tab-panel">
                    <h2>Đơn hàng đã giao thành công</h2>
                    <table class="tbl-full">
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Địa Chỉ</th>
                            <th>Thành Phố</th>
                            <th>Số Điện Thoại</th>
                            <th>Ghi Chú</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Chỉnh Sửa</th>
                        </tr>
                        <?php
                        $orders = layDonHangTheoStatus('Đã giao thành công');
                        foreach ($orders as $order) {
                            echo "<tr>";
                            echo "<td>{$order['customer_id']}</td>";
                            echo "<td>{$order['customer_name']}</td>";
                            echo "<td>{$order['email']}</td>";
                            echo "<td>{$order['address']}</td>";
                            echo "<td>{$order['city']}</td>";
                            echo "<td>{$order['phone']}</td>";
                            echo "<td>{$order['note']}</td>";
                            echo "<td>{$order['totalPrice']}</td>";
                            echo "<td>{$order['status']}</td>";
                            echo "<td>
                                    <form method='POST' action=''>
                                        <select name='status'>
                                            <option value='Chờ xác nhận' " . ($order['status'] == 'Chờ xác nhận' ? 'selected' : '') . ">Chờ xác nhận</option>
                                            <option value='Đang chuẩn bị hàng' " . ($order['status'] == 'Đang chuẩn bị hàng' ? 'selected' : '') . ">Đang chuẩn bị hàng</option>
                                            <option value='Đang giao hàng' " . ($order['status'] == 'Đang giao hàng' ? 'selected' : '') . ">Đang giao hàng</option>
                                            <option value='Đã giao thành công' " . ($order['status'] == 'Đã giao thành công' ? 'selected' : '') . ">Đã giao thành công</option>
                                        </select>
                                        <input type='hidden' name='order_id' value='{$order['customer_id']}'>
                                        <button type='submit' class='edit-btn'>Cập nhật</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>

            </div>
        </div>
    </div>
                    </main>
    <script>
        // JavaScript quản lý các tab
        document.querySelectorAll('.tab-links a').forEach(function(tabLink) {
            tabLink.addEventListener('click', function(event) {
                event.preventDefault();
                document.querySelectorAll('.tab-links a').forEach(function(link) {
                    link.classList.remove('active');
                });
                tabLink.classList.add('active');
                document.querySelectorAll('.tab-panel').forEach(function(panel) {
                    panel.style.display = 'none';
                });
                const targetTab = document.querySelector(tabLink.getAttribute('href'));
                targetTab.style.display = 'block';
            });
        });
        // Kích hoạt tab mặc định
        document.querySelector('.tab-links a').click();
        
        // Kiểm tra nếu có session thông báo cập nhật
        <?php if (isset($_SESSION['update_success'])): ?>
            window.onload = function() {
                alert('<?php echo $_SESSION['update_success'] ? "Cập nhật trạng thái thành công!" : "Cập nhật trạng thái thất bại!"; ?>');
                <?php unset($_SESSION['update_success']); ?>
            };
        <?php endif; ?>
    </script>
</body>
</html>
