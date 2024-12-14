<?php
session_start();  // Bắt đầu phiên làm việc

// Kiểm tra nếu người dùng đã đăng nhập
$is_logged_in = false;
if (isset($_SESSION['user_email'])) {
    $is_logged_in = true;
    $username = $_SESSION['user_name'];  // Lấy tên người dùng từ session
} else {
    $username = '';
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="footer.css">
    <style>
        /* Khung bao quanh header */
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
}
    </style>
</head>
<body>
<header>
            <img src="./Anh/Logo.png">
        <div class="header-left">
            <a href="../trangchu1.php"><strong>TRANG CHỦ</strong></a>
            <div class="drop-down">
            <a href="sp.php"><strong>SẢN PHẨM</strong></a>
                <div class="detail">
                    <a href="danhmucanimals.php"><strong>ANIMALS</strong></a>
                    <a href="danhmucbags&charms.php"><strong>BAGS & CHARMS</strong></a>
                    <a href="danhmucamuseables.php"><strong>AMUSEABLES</strong></a>
                    <a href="danhmucgifts.php"><strong>GIFTS</strong></a>
                </div>
            </div>
            <a href="../tintuc.php"><strong>TIN TỨC</strong></a>
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
                    echo '../admin.php';  // Trang admin
                } else {
                    echo '../user_page.php';  // Trang user
                }
            ?>
        " class="user-greeting">
            <i class="fa fa-user"></i>
        </a>
                <a href="logout.php" class="logout-link"><i class="fa fa-sign-out-alt"></i></a>
            </div>
        <?php else: ?>
            <div class="user-info">
            <a href="../login_form.php" class="login-link">
                <i class="fa fa-user"></i>
            </a>
            </div>
        <?php endif; ?>
        </div>
            

    </header>
   
<div class="container">
    <div class="checkoutLayout">
        <div class="returnCart">
            <a class="keepshopping" href="sp.php">Tiếp tục mua sắm</a>
            <h1>GIỎ HÀNG CỦA BẠN</h1>
            <div class="list">
                <div class="item">
                    <img src="Anh/A2CL__32714.1.jpg" alt="">
                    <div class="info">
                        <div class="name">PRODUCT 1</div>
                        <div class="price">22000đ/1 sản phẩm</div>
                    </div>
                    <div class="size">M</div>
                    <!-- <div class="quantity">1</div> -->
                    <div class="quantity">
                        <button>-</button>
                        <span class="value">3</span>
                        <button>+</button>
                    </div>
                    <div class="returnPrice">50000đ</div>
                    <div class="remove"><i class="fa-solid fa-trash-can"></i></div>
                </div>
            </div>
        </div>

        <div class="right">
            <h1>TỔNG</h1>            
            <div class="wrap">
                <div class="return">
                    <div class="row">
                        <div>Tổng sản phẩm</div>
                        <div class="totalQuantity">0</div>
                    </div>
                    <div class="row">
                        <div>Tổng tiền</div>
                        <div class="totalPrice">0đ</div>
                    </div>
                </div>
                <button class="buttonCheckout">
                    <a class="checkout" href="trangthanhtoan.php">Thanh toán</a>                    
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- <script src="cart.js"></script> -->
    <?php include 'cart_js.php'; ?>
</body>
</html>