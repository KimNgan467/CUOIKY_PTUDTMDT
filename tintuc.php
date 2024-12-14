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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vidu";

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}


// Cấu hình phân trang
$news_per_page = 6; // 2 hàng x 3 tin tức mỗi hàng
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;
$offset = ($current_page - 1) * $news_per_page;

// Truy vấn lấy tin tức
$query = "SELECT * FROM news ORDER BY date DESC LIMIT $news_per_page OFFSET $offset";
$result = mysqli_query($conn, $query);

// Truy vấn tổng số tin tức
$total_news_query = "SELECT COUNT(*) as total FROM news";
$total_result = mysqli_query($conn, $total_news_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_news = $total_row['total'];
$total_pages = ceil($total_news / $news_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ tin tức</title>
    <link rel="stylesheet" href="tintuc (3).css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    <div class="news-container">
        <h1>Tin tức mới nhất</h1>
        <div class="news-grid">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='news-item'>";
                    echo "<img src='picture/" . htmlspecialchars($row['image']) . "' alt='News Image'>";
                    echo "<div class='news-content'>";
                    echo "<h2 class='news-title'>" . htmlspecialchars($row['name']) . "</h2>";
                    echo "<p class='news-meta'>Ngày: " . htmlspecialchars($row['date']) . " | Tác giả: " . htmlspecialchars($row['author']) . "</p>";
                    echo "<p class='news-text'>" . htmlspecialchars(mb_substr($row['content'], 0, 200)) . "...</p>";
                    echo "<a href='" . htmlspecialchars($row['link']) . "' class='news-link' target='_blank'>Đọc thêm</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Hiện chưa có tin tức nào.</p>";
            }
            ?>
        </div>
        <div class="pagination">
            <?php
            if ($total_pages > 1) {
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $current_page) {
                        echo "<span class='current-page'>$i</span>";
                    } else {
                        echo "<a href='?page=$i' class='page-link'>$i</a>";
                    }
                }
            }
            ?>
        </div>
    </div>
</main>
<footer>
        <div class="container">
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
                    <li><img src="Anh/Logo.png" width="250px" height="70px" alt="Logo"></li>
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
                </ul>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125428.95859731767!2d106.52416244335936!3d10.761053200000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ee4595019ad%3A0xf2a1b15c6af2c1a6!2zxJDhuqFpIGjhu41jIEtpbmggdOG6vyBUUC4gSOG7kyBDaMOtIE1pbmggKFVFSCkgLSBDxqEgc-G7nyBC!5e0!3m2!1svi!2s!4v1733408848189!5m2!1svi!2s" width="350" height="225" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </footer>
    <div class="copyrightText">
        <p>© Jellycat Limited 2024 All rights reserved</p>
    </div>
</body>
</html>
