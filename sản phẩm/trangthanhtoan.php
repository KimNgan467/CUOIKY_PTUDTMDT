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


$jsonFile = 'product.json';

if (file_exists($jsonFile)) {
    $currentData = file_get_contents($jsonFile);
    $productsArray = json_decode($currentData, true);
} else {
    $productsArray = []; // Mảng rỗng nếu file không tồn tại
}
?>

<html>
<head>
    <title>trangthanhtoan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="trangthanhtoan.css">
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
                <a href="../logout.php" class="logout-link"><i class="fa fa-sign-out-alt"></i></a>
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

    <main>
        

<div class="row">
  <div class="col-65">
    <div class="container">
      <!-- <form action="newbill.php" method="post" onsubmit="return showAlert()">  -->
      <form action="newbill.php" method="post">
        <div class="row">
          <div class="col-50">
            <h3>Thông tin đặt hàng</h3>
            <label for="fname"><i class="fa fa-user"></i> Họ và Tên</label>
            <input type="text" id="fname" name="firstname" placeholder="Nhập tại đây...." required>
            
            <label for="email"><i class="fa fa-envelope"></i> Địa chỉ Email</label>
            <input type="text" id="email" name="email" placeholder="Nhập tại đây...." required>
            
            <label for="adr"><i class="fa fa-address-card-o"></i> Địa chỉ nhận hàng</label>
            <input type="text" id="adr" name="address" placeholder="Nhập tại đây...." required>
            
            <label for="city"><i class="fa fa-institution"></i> Thành phố</label>
            <input type="text" id="city" name="city" placeholder="Nhập tại đây...." required>

            <div class="row">
              <div class="col-50">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="phone" placeholder="Nhập tại đây...." required>
              </div>
              <div class="col-50">
                <label for="note">Ghi chú (Nếu có)</label>
                <input type="text" id="note" name="note" placeholder="Nhập tại đây....">
              </div>
            </div>
          </div>



          
        </div>
        <label>
          <input type="checkbox" checked="checked" name="sameadr"> Địa chỉ giao hàng giống như địa chỉ thanh toán
        </label>
        <input type="submit" value="HOÀN THÀNH THANH TOÁN" name="dongydathang" class="btn">
      
</script>
    </main>
    <footer>
      <div class="container1">
          <div class="sec aboutus">
              <h2>Về chúng tôi</h2>
              <p>
                  Jellycat là một công ty nổi tiếng toàn cầu, chuyên thiết kế và sản xuất các món đồ chơi nhồi bông cao cấp, đặc biệt là những chú thú nhồi bông dễ thương và độc đáo. Được thành lập vào năm 1999 tại London, Jellycat đã nhanh chóng chiếm được cảm tình của khách hàng trên toàn thế giới nhờ vào chất lượng vượt trội và sự sáng tạo không ngừng. 
                  Với cam kết phát triển bền vững và trách nhiệm đối với cộng đồng, Jellycat tiếp tục khẳng định vị thế vững chắc trong ngành công nghiệp đồ chơi nhồi bông.
              </p>
              <ul class="sci">
                  <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                  <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                  <li><a href="#"><i class="fa-brands fa-tiktok"></i></a></li>
                  <li><a href="#"><i class="fa-solid fa-x"></i></a></li>

              </ul>
          </div>
          <div class="sec quicklinks">
              <h2>Tin tức</h2>
              <ul>
                  
                  <li>
                      <a href="https://lifestyle.znews.vn/jellycat-la-gi-ma-duoc-lo-lem-chao-yeu-thich-post1500529.html">Hết Labubu đến Jellycat gây sốt</a>
                  </li>

                  <li>
                      <a href="https://vnexpress.net/chu-cho-de-thuong-nhat-the-gioi-bi-nham-la-gau-bong-4013339.html">Mê gấu bông "biết đi" nên mình chọn mua Jellycat: Trải nghiệm siêu chill</a>
                  </li>
                  
                  <li>
                      <a href="https://vietcetera.com/vn/anh-chang-thu-gian-bieu-tuong-moi-cua-loi-song-cu-chill-di">Chill Noel Guy: Hãy mua gấu bông</a>
                  </li>

                  <li>
                      <a href="https://cany.vn/blog/gau-bong-jellycat-co-gi-thu-vi-ma-em-pam-yeu-oi-lai-me-den-vay">Gấu bông Pamyeuoi có gì đặc biệt?</a>
                  </li>
              </ul>

          </div>

          <div class="sec contact">
              <h2>Liên hệ</h2>
              <ul class="info">
                  <li>
                      <span><i class="fa-solid fa-phone"></i></span>
                      <p><a href="tel:+12345678">+ 123 456 78</a></p>
                  </li>
                  <li>
                      <span><i class="fa-regular fa-envelope"></i></span>
                      <p><a href="mailto:ptudtmdt@gmail.com">ptudtmdt@gmail.com</a></p>
                  </li>
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125428.95859731767!2d106.52416244335936!3d10.761053200000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ee4595019ad%3A0xf2a1b15c6af2c1a6!2zxJDhuqFpIGjhu41jIEtpbmggdOG6vyBUUC4gSOG7kyBDaMOtIE1pbmggKFVFSCkgLSBDxqEgc-G7nyBC!5e0!3m2!1svi!2s!4v1733408848189!5m2!1svi!2s" width="350" height="225" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </ul>
          </div>
      </div>
  </footer>
  <div class="copyrightText">
      <p>© Jellycat Limited 2024

          All rights reserved</p>
  </div>

  <script>
    // Hàm JavaScript để hiển thị alert khi nhấn "Tiếp tục thanh toán"
    function showAlert() {
        alert("Đặt hàng thành công!");
        return false;  // Ngừng hành động gửi form để bạn có thể thử nghiệm với alert
    }
</script>
</body>
</body>
</html>