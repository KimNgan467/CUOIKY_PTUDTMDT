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
$dbname = "vidu"; // Đổi tên nếu cần

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn dữ liệu từ bảng tin tức
$sql = "SELECT * FROM news ORDER BY date DESC"; // Lấy tin tức mới nhất trước
$result = $conn->query($sql);
$newsList = [];

if ($result->num_rows > 0) {
    // Lấy dữ liệu cho mỗi hàng
    while ($row = $result->fetch_assoc()) {
        $newsList[] = $row;
    }
} else {
    echo "Không có tin tức nào.";
}

// Đóng kết nối
$conn->close();
?>


<html>
<head>
    <title>TRANG CHỦ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Bubbles&display=swap" rel="stylesheet">
    <style>

        * {
            padding: 0;
            margin: 0;
            
        }
        
        body{
            display: flex;
            flex-direction: column;
            min-height:3000px;
            width: 100%;
            background-color: white;
        }

        main {
    flex-grow: 1; /* Cho phép phần chính chiếm không gian còn lại */
}


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

    /*Chỉnh sửa phần giữa trang web*/
        main {
            height:2900px;
            padding: 20px;
            flex: 1;
            flex-direction: column;
            text-align: center;
        }
    /*Hiệu ứng video*/
        .TVC {
            position: relative;
            width: 100%;
            height: 100vh; 
            overflow: hidden; 
            margin:0;
            z-index: 0;
        }
        .TVC video {
            position: absolute; 
            top: 0;
            left: 0;
            width: 100%;
            height: 550px;
            object-fit: cover; 
        }
    /*Hiệu ứng chữ trên video*/
        .overlay {
            position: absolute;
            top: 68%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 1; /* Ensure it's on top of the video */
            color: black; 
        }
        .overlay h2 {
            margin-bottom: 10px;
        }
        .overlay button {
            font-size: large;
            background-color: #05719D;
            color: white;
            border: none;
            padding: 20px 40px;
            cursor: pointer;
            border-radius:7px;
        }
    /*Chỉnh dòng Best-seller/*/
    .best-seller {
            display: flex;
            justify-content: center; 
            margin-top: 0;
        }
        
        .best-seller a {
            color: #05719d;
            font-weight: bold;
            font-size: 40px; 
            font-family:'Rubik Bubbles';
            text-decoration: none; 
            cursor: pointer; 
        }

        .best-seller a:hover {
    font-size: 45px; /* Tăng kích thước chữ */
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.5); /* Thêm bóng đổ */
    text-decoration: none; /* Đảm bảo không có underline khi hover */
}
        
        .best-seller-container {
            display: flex;
            flex-direction: column; /* sắp xếp theo cột */
            align-items: center; /* căn giữa theo chiều ngang */
        }

        .best-seller-spacer { /* tạo khoảng cách */
            height: 50px; /* điều chỉnh giá trị này để thay đổi khoảng cách */
        }
    /*Chỉnh card sản phẩm*/
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));;
            grid-gap: 10px;
        }
        .product-card {
            border: none;
            position: relative;
            width: 280px;
            box-sizing: border-box;
        }
        .product-card:hover {
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--text-color);
            border-radius: 5px;
            transition: 0.4s;
            cursor: pointer;
        }
    /*Hiện chữ Best-Seller trên card sản phẩm*/
        .best-seller-label {
            position: absolute;
            top:10px;
            left:10px;
            border: 1px solid #05719D; 
            color: #05719D; 
            padding: 2px 5px; 
            border-radius: 5px; 
            margin-bottom: 5px; 
            z-index:1;
            text-decoration: none;
            background-color: white;
        }
    /*Thêm hiệu ứng chuyển ảnh và hover cho card*/
    /*Ảnh 1*/
        .image-hover1 {
            width: 100%; 
            height: 280px; 
            background-image: url('./Anh/Banana\ Front.jpg'); 
            background-size:cover;
            transition: background 0,5s ease-in-out; 
        }
        .image-hover1:hover {
            background-image: url('./Anh/Banana\ Stand.jpg'); 
        }
    /*Ảnh 2*/
        .image-hover2 {
            width: 100%; 
            height: 280px; 
            background-image: url('./Anh/Jack\ Front.jpg'); 
            background-size:cover;
            transition: background 0,5s ease-in-out; 
        }
        .image-hover2:hover {
            background-image: url('./Anh/Jack\ Left.jpg'); 
        }
    /*Ảnh 3*/
        .image-hover3 {
            width: 100%; 
            height: 280px; 
            background-image: url('./Anh/Chocolate\ Front.jpg'); 
            background-size:cover; 
            transition: background 0,5s ease-in-out; 
        }
        .image-hover3:hover {
            background-image: url('./Anh/Chocolate\ Left.jpg'); 
        }
    /*Ảnh 4*/
        .image-hover4 {
            width:100%; 
            height: 280px; 
            background-image: url('./Anh/Dragon\ Front.jpg'); 
            background-size:cover; 
            transition: background 0,5s ease-in-out; 
        }
        .image-hover4:hover {
            background-image: url('./Anh/Dragon\ Left.jpg'); 
        }
    /*Ảnh 5*/
        .image-hover5 {
            width: 100%; 
            height: 280px; 
            background-image: url('./Anh/Croissant\ Front.jpg'); 
            background-size:cover; 
            transition: background 0,5s ease-in-out; 
        }
        .image-hover5:hover {
            background-image: url('./Anh/Croissant\ Left.jpg');
        }
    /*Ảnh 6*/
        .image-hover6 {
            width: 100%; 
            height: 280px; 
            background-image: url('./Anh/Turtle\ Front.jpg'); 
            background-size:cover; 
            transition: background 0,5s ease-in-out; 
        }
        .image-hover6:hover {
            background-image: url('./Anh/Turtle\ Left.jpg'); 
        }
    /*Ảnh 7*/
        .image-hover7 {
            width: 100%; 
            height: 280px; 
            background-image: url('./Anh/Pup\ Bag\ Charm\ Front.jpg'); 
            background-size:cover; 
            transition: background 0,5s ease-in-out; 
        }
        .image-hover7:hover {
            background-image: url('./Anh/Pup\ Bag\ Charm\ Left.jpg'); 
        }
    /*Ảnh 8*/
        .image-hover8 {
            width: 100%; 
            height: 280px; 
            background-image: url('./Anh/Napping\ Cat\ Front.jpg'); 
            background-size:cover; 
            transition: background 0,5s ease-in-out; 
        }
        .image-hover8:hover {
            background-image: url('./Anh/Napping\ Cat\ Left.jpg'); 
        }
    /*Chỉnh chữ trong card sản phẩm*/
        .product-info {
            padding: 10px;
        }
        .product-info h3 {
            margin-top: 0;
        }
        .product-info p {
            color: #777;
            margin-bottom: 0;
        }
    /*Thanh cuộn*/
    ::-webkit-scrollbar {
            width: 10px; 
        }
        ::-webkit-scrollbar-track {
            background: white; 
            border-radius: 10px; 
        }
        ::-webkit-scrollbar-thumb {
            background: rgb(172, 170, 170); 
            border-radius: 10px; 
        }
        ::-webkit-scrollbar-thumb:hover {
            background: grey; 
        }
    
    /*Tin tức*/
    .christmas-container {
            display: flex;
            align-items: center; /* Vertically center content */
            width: 100%;
            max-width: 1220px;
            margin: 0 auto; /* Horizontally center container */
            background-color: #D7F9FD;
            color: black;
            padding: 40px;
        }
        .text-content-wrapper { /* Styles for the new wrapper */
            display: flex;
            flex-direction: column;
            flex: 1; /* Allow the text content to take up available space */
            padding: 20px;
        }
        .text-content {
            text-align: left; /* Center text within the text-content div */
            margin: 10px;
            font-family: 'Times New Roman', Times, serif;
        }
        .text-content h1 {
            font-size:40px;
        }
        .text-content p {
            font-size:20px;
            margin-bottom: 30px;
        }
        .button {
            background-color: #05719D;
            color: white;
            padding: 10px 15px; /* Adjust padding as needed */
            border: none;
            cursor: pointer;
            font-size: 16px; /* Adjust font size as needed */
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-family:Arial, Helvetica, sans-serif;
        }
        .button:hover {
            padding: 15px 25px; /* Tăng kích thước lên 110% */
            box-shadow: 0px 0px 10px rgba(17, 124, 247, 0.5); /* Thêm bóng đổ để tạo hiệu ứng nổi bật */
        }
        .image-content {
            flex: 1;
            display: flex;
            justify-content: center; /* Center image horizontally */
        }
        .image-content img {
            max-width: 100%;
            height: auto;
        }

        .news-section {
    margin-bottom: 30px;
    text-align: center; /* Căn giữa nội dung */
    position: relative; /* Để định vị mũi tên */
}

.news-container {
    display: flex;
    justify-content: center; /* Căn giữa các phần tử trong container */
    align-items: center; /* Căn giữa theo chiều dọc */
}

.card-wrapper {
    display: flex; /* Sắp xếp card theo hàng ngang */
    width: 90%; /* Chiều rộng của vùng chứa card */
    justify-content: center; /* Căn giữa card */
}

.news-card {
    display: none; /* Ẩn tất cả card */
    flex: 0 0 45%; /* Mỗi card chiếm 45% chiều rộng */
    margin: 10px; /* Khoảng cách giữa các card */
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s; /* Hiệu ứng khi hover */
}

.news-card.active {
    display: block; /* Hiển thị card đang hoạt động */
}

/* Hiệu ứng hover cho card */
.news-card:hover {
    transform: scale(1.05); /* Phóng to card khi hover */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Tăng độ bóng */
}

.news-image-container {
    width: 100%;
    height: 150px;
    overflow: hidden;
}

.news-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.news-content {
    padding: 15px;
}

.news-title {
    font-size: 16px;
    margin-bottom: 8px;
}

.news-description {
    font-size: 12px;
    margin-bottom: 10px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Giới hạn số dòng hiển thị */
    -webkit-box-orient: vertical;
}

.news-meta {
    font-size: 10px;
    color: #888;
}

.news-content a {
    color: #007bff;
    text-decoration: none;
}

/* Mũi tên */
.arrow {
    background-color: transparent;
    border: none;
    font-size: 24px;
    cursor: pointer;
    z-index: 1; /* Đặt lên trên vùng card */
    transition: transform 0.3s; /* Hiệu ứng khi hover */
}

.left-arrow {
    position: absolute;
    left: 10px; /* Khoảng cách từ bên trái */
}

.right-arrow {
    position: absolute;
    right: 10px; /* Khoảng cách từ bên phải */
}

/* Hiệu ứng hover cho mũi tên */
.arrow:hover {
    transform: scale(1.2); /* Phóng to mũi tên khi hover */
}
        
/*Slogan*/
.slogan {
            background-color: white;
            text-align: center;
            padding: 60px 0;
            margin: 20px 0;
            position: relative; /* Added for positioning quotes */
            font-size:large;
        }
        .quote-left {
            position: absolute;
            top: -25px;
            left: 0;
            font-size: 6em; /* Adjust size as needed */
            color: #FFA500;
            transform: rotate(-15deg); /* Adjust rotation as needed */
        }
        .quote-right {
            position: absolute;
            bottom: -85px;
            right: 0;
            font-size: 6em; /* Adjust size as needed */
            color: #FFA500;
            transform: rotate(15deg); /* Adjust rotation as needed */
        }
        .slogan-content { /* Container for slogan text */
            text-align: center;
            margin:0 auto;
            width:80%;
            padding: 30px;
        }
        .slogan-content span {
            display: block; /* Makes each span a block element for better spacing */
            margin-bottom: 20px;
        }
        .slogan-title {
            font-size: 25px; /* slightly increased font size */
        }
        .slogan-text {
            text-align: center;
            font-size: 20px; /* slightly increased font size */
        }

        /*Footer*/
        footer {
            max-width: 1200px;
            height: auto;
            padding: 100px;
            background-color:#0aa8be;
        }
        footer .container {
            width: 100%;
            display: grid;
            grid-template-columns: 3fr 1.5fr 0.5fr;
            grid-gap: 120px;
        }
        footer .container .sec h2 {
            position: relative;
            color: black;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 30px;
        }
        footer .container .sec p {
            color: rgb(36, 33, 33);
        }
        footer .container .sci {
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(4, 50px);
            gap: 40px; /* Optional: Add space between icons */
        }
        footer .container .sci li {
            list-style: none;
        }
        footer .container .sci li a {
            display: inline-block;
            width: 50px;
            height: 50px;
            background: #33cee5;
            display: grid;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 50%;
            transition: background 0.3s;
        }
        footer .container .sci li a:hover {
            background: #20a2b8; /* Hover effect */
        }
        footer .container .sci li a i {
            color: black;
            font-size: 20px;
        }
        footer .container .sci img{

        }
        footer .container .quicklinks {
            position: relative;
        }
        footer .container .quicklinks ul li a {
            color: black;
            text-decoration: none;
            font-size: 16px;
            display: block;
            margin-bottom: 10px;
        }
        footer .container .quicklinks ul li a:hover {
            text-decoration: underline;
            color: white;
        }
        footer .container .info {
            list-style: none;
        }
        footer .container .info li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        footer .container .info li span {
            margin-right: 10px;
        }
        footer .container .info li p a {
            text-decoration: none;
            color: black;
        }
        footer .container .info li p a:hover {
            text-decoration: underline;
            color: white;
        }
        .copyrightText {
            max-width: 1400px;
            padding:30px;
            background-color: black;
            text-align: center;
            color: white;
            border: 1px solid rgba(0, 0, 0, 15);
        }
        
    /*Responsive*/
    @media (max-width: 768px) {
    header {
        padding: 10px 20px; /* Giảm padding cho header */
    }

    header img {
        height: 30px; /* Giảm kích thước logo */
    }

    .header-left a {
        margin: 0 20px; /* Giảm khoảng cách giữa các liên kết */
        font-size: 14px; /* Kích thước chữ nhỏ hơn */
    }

    .header-right a {
        font-size: 18px; /* Kích thước chữ cho nút giỏ hàng và đăng nhập */
        margin-left: 15px; /* Giảm khoảng cách */
    }

    .user-info a {
        font-size: 18px; /* Kích thước chữ nhỏ hơn */
    }
        /* Video TVC */
        .TVC {
        height: 70vh; /* Giảm chiều cao video */
    }
    
    /* Chữ overlay */
    .overlay {
        top: 85%; /* Đưa lên một chút */
        transform: translate(-50%, -50%);
    }

    .overlay h2 {
        font-size: 2em; /* Giảm kích thước chữ */
    }

    .overlay button {
        font-size: large; /* Giữ kích thước chữ */
        padding: 8px 20px; /* Giảm padding */
    }

    /* Best-seller */
    .best-seller a {
        font-size: 32px; /* Giảm kích thước chữ */
    }

    /* Product card */
    .product-card {
        width: 100%; /* Để card sử dụng chiều rộng tối đa */
    }

    /* Slogan */
    .slogan {
        padding: 40px 0; /* Giảm padding */
    }

    .slogan-title {
        font-size: 22px; /* Giảm kích thước chữ */
    }

    .slogan-text {
        font-size: 18px; /* Giảm kích thước chữ */
    }

    /* Christmas container */
    .christmas-container {
        padding: 20px; /* Giảm padding */
    }

    .text-content h1 {
        font-size: 30px; /* Giảm kích thước chữ */
    }

    .text-content p {
        font-size: 18px; /* Giảm kích thước chữ */
    }
    .button {
        font-size: 14px; /* Giảm kích thước chữ */
        padding: 8px 12px; /* Giảm padding */
    }
}


@media (max-width: 480px) {
    header {
        padding: 5px 10px; /* Giảm padding thêm cho header */
    }

    header img {
        height: 25px; /* Giảm kích thước logo thêm */
    }

    .header-left a {
        margin: 0 10px; /* Giảm khoảng cách giữa các liên kết */
        font-size: 12px; /* Kích thước chữ nhỏ hơn */
    }

    .header-right a {
        font-size: 16px; /* Kích thước chữ cho nút giỏ hàng và đăng nhập */
        margin-left: 10px; /* Giảm khoảng cách */
    }

    .user-info a {
        font-size: 16px; /* Kích thước chữ nhỏ hơn */
    }
        /* Video TVC */
        .TVC {
        height: 50vh; /* Giảm chiều cao video thêm */
    }

    /* Chữ overlay */
    .overlay {
        top: 80%; /* Đưa lên một chút */
    }

    .overlay h2 {
        font-size: 1.5em; /* Giảm kích thước chữ */
    }

    .overlay button {
        font-size: medium; /* Giảm kích thước chữ */
        padding: 6px 15px; /* Giảm padding */
    }

    /* Best-seller */
    .best-seller a {
        font-size: 28px; /* Giảm kích thước chữ */
    }

    /* Product card */
    .product-card {
        width: 100%; /* Để card sử dụng chiều rộng tối đa */
    }

    /* Slogan */
    .slogan {
        padding: 30px 0; /* Giảm padding */
    }

    .slogan-title {
        font-size: 20px; /* Giảm kích thước chữ */
    }

    .slogan-text {
        font-size: 16px; /* Giảm kích thước chữ */
    }

    /* Christmas container */
    .christmas-container {
        padding: 10px; /* Giảm padding */
    }

    .text-content h1 {
        font-size: 24px; /* Giảm kích thước chữ */
    }

    .text-content p {
        font-size: 16px; /* Giảm kích thước chữ */
    }
    .button {
        font-size: 12px; /* Giảm kích thước chữ thêm */
        padding: 6px 10px; /* Giảm padding thêm */
    }
}
    </style>
</head>
<body>
    <header>
            <img src="./Anh/Logo.png">
        <div class="header-left">
            <a href="trangchu1.php"><strong>TRANG CHỦ</strong></a>
            <div class="drop-down">
            <a href="sp.php"><strong>SẢN PHẨM</strong></a>
                <div class="detail">
                    <a href="danhmucanimals.php"><strong>ANIMALS</strong></a>
                    <a href="danhmucbags&charms.php"><strong>BAGS & CHARMS</strong></a>
                    <a href="danhmucamuseables.php"><strong>AMUSEABLES</strong></a>
                    <a href="danhmucgifts.php"><strong>GIFTS</strong></a>
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

    <main>
        <div class="TVC">
            <video autoplay loop muted>
                <source src="./Anh/TVC.mp4" type="video/mp4">
            </video>
            <div class="overlay">
                <h2>Share the gift of joy this Christmas</h2>
                <a href="danhmucgifts.html">
                <button>Explore Christmas</button>
                </a>
            </div>
        </div>
        </div>
        <div class="best-seller"><a href='#'><strong>🧸 BEST-SELLERS 🧸</strong></a></div>
        <div class="best-seller-spacer"></div>  <!-- Khoảng cách dưới -->
    </div>
        <div class="product-grid">
            <div class="product-card">
            <a href="#">
                <div class="image-hover1">
                    <span class="best-seller-label">BEST-SELLER</span>
                </div>
            </a>
                <div class="product-info">
                    <h3>AMUSEABLES BANANA BAG</h3>
                    <p>$15.00</p>
                </div>
            </div>
            <div class="product-card">
                <a href="#">
                    <div class="image-hover2">
                        <span class="best-seller-label">BEST-SELLER</span>
                    </div>
                </a>
                <div class="product-info">
                    <h3>CHRISTMAS JELLYCAT JACK</h3>
                    <p>$55.00</p>
                </div>
            </div>
            <div class="product-card">
            <a href="#">
                <div class="image-hover3">
                    <span class="best-seller-label">BEST-SELLER</span>
                </div>
            </a>
                <div class="product-info">
                    <h3>AMUSEABLES HOT CHOCOLATE</h3>
                    <p>$33.00</p>
                </div>
            </div>
            <div class="product-card">
            <a href="#">
                <div class="image-hover4">
                    <span class="best-seller-label">BEST-SELLER</span>
                </div>
            </a>
                <div class="product-info">
                    <h3>SNOW DRAGON</h3>
                    <p>$35.00</p>
                </div>
            </div>
            <div class="product-card">
            <a href="#">
                <div class="image-hover5">
                    <span class="best-seller-label">BEST-SELLER</span>
                </div>
            </a>
                <div class="product-info">
                    <h3>AMUSEABLES CROISSANT</h3>
                    <p>$23.00</p>
                </div>
            </div>
             <div class="product-card">
            <a href="#">
                <div class="image-hover6">
                    <span class="best-seller-label">BEST-SELLER</span>
                </div>
            </a>
                <div class="product-info">
                    <h3>TIMMY TURTLE</h3>
                    <p>$48.00</p>
                </div>
            </div>
            <div class="product-card">
                <a href="#">
                    <div class="image-hover7">
                        <span class="best-seller-label">BEST-SELLER</span>
                    </div>
                </a>
                    <div class="product-info">
                        <h3>LITTLE PUP BAG CHARM</h3>
                        <p>$25.00</p>
                    </div>
            </div>
            <div class="product-card">
                <a href="#">
                    <div class="image-hover8">
                        <span class="best-seller-label">BEST-SELLER</span>
                    </div>
                </a>
                    <div class="product-info">
                        <h3>NAPPING NIPPER CAT</h3>
                        <p>$28.00</p>
                    </div>
            </div>
        </div>
        
        <br><br><br>


        <div class="christmas-container">
            <div class="text-content-wrapper"> 
                <div class="text-content">
                    <h1>JELLYCAT CAFE</h1>
                    <p>Quán cà phê Jellycat tại Thượng Hải là một điểm đến lý tưởng cho những ai yêu thích không gian ấm cúng và sự sáng tạo. Với thiết kế độc đáo, quán mang đến một bầu không khí vui tươi, thân thiện, phù hợp cho cả gia đình và bạn bè.</p>
                    <a href="https://eu.jellycat.com/jellycat-cafe-experience-shanghai/" class="button" target="_blank">Khám phá ngay!</a>
                </div>
            </div>
            <div class="image-content">
                <img src="./Anh/Screenshot 2024-12-04 at 22.30.00.png" alt="Christmas image">
            </div>
        </div>    

        <br><br>
        <div class="best-seller"><a href='#'><strong>🧸 HOT NEWS 🧸</strong></a></div>
        <div class="best-seller-spacer"></div>  <!-- Khoảng cách dưới -->
        <section class="news-section">
    <div class="news-container">
        <button class="arrow left-arrow">&#10094;</button> <!-- Mũi tên trái -->
        <div class="card-wrapper">
            <?php for ($i = 0; $i < 4; $i++): // Lấy 4 tin tức đầu tiên
                if (isset($newsList[$i])): ?>
                    <div class="news-card" style="display: <?= $i < 2 ? 'block' : 'none'; ?>">
                        <div class="news-image-container">
                            <?php
                                // Đảm bảo đường dẫn ảnh đầy đủ
                                $imagePath = "picture/" . htmlspecialchars($newsList[$i]['image']);
                                
                                // Kiểm tra xem ảnh có tồn tại hay không
                                if (file_exists($imagePath)) {
                                    // Nếu ảnh tồn tại, hiển thị ảnh
                                    echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($newsList[$i]['name']) . '" class="news-image">';
                                } else {
                                    // Nếu không tồn tại, hiển thị ảnh mặc định
                                    echo '<img src="default-image.jpg" alt="Default Image" class="news-image">';
                                }
                            ?>
                        </div>
                        <div class="news-content">
                            <h3 class="news-title"><?= htmlspecialchars($newsList[$i]['name']) ?></h3>
                            <p class="news-description"><?= htmlspecialchars(substr($newsList[$i]['content'], 0, 100)) ?>...</p>
                            <div class="news-meta">
                                <small>Ngày đăng: <?= htmlspecialchars($newsList[$i]['date']) ?> | Tác giả: <?= htmlspecialchars($newsList[$i]['author']) ?></small>
                            </div>
                            <a href="<?= htmlspecialchars($newsList[$i]['link']) ?>">Đọc thêm</a>
                        </div>
                    </div>
                <?php endif;
            endfor; ?>
        </div>
        <button class="arrow right-arrow">&#10095;</button> <!-- Mũi tên phải -->
    </div>
</section>

<script>
    const cards = document.querySelectorAll('.news-card');
    const totalCards = cards.length;
    let currentIndex = 0;

    // Hiển thị cặp card hiện tại
    function showCards(index) {
        cards.forEach((card, i) => {
            card.style.display = (i >= index && i < index + 2) ? 'block' : 'none'; // Chỉ hiển thị 2 card
        });
    }

    document.querySelector('.left-arrow').addEventListener('click', () => {
        currentIndex = (currentIndex > 0) ? currentIndex - 2 : totalCards - 2; // Nếu đang ở đầu thì quay về cuối
        showCards(currentIndex);
    });

    document.querySelector('.right-arrow').addEventListener('click', () => {
        currentIndex = (currentIndex < totalCards - 2) ? currentIndex + 2 : 0; // Nếu đang ở cuối thì quay về đầu
        showCards(currentIndex);
    });

    // Tự động chuyển đổi các thẻ tin tức mỗi 2 giây
    setInterval(() => {
        currentIndex = (currentIndex < totalCards - 2) ? currentIndex + 2 : 0; // Nếu đang ở cuối thì quay về đầu
        showCards(currentIndex);
    }, 2000); // Thay đổi mỗi 2000 ms (2 giây)

    // Hiển thị cặp card đầu tiên
    showCards(currentIndex);
</script>

        <div class="slogan">
            <span class="quote-left">"</span>
            <div class="slogan-content">
                <span class="slogan-title"><strong><u>Tầm Nhìn và Sứ Mệnh của Jellycat</strong></u></span>
                <span class="slogan-title"><strong><u>Mang Đến Niềm Vui và Sáng Tạo Cho Thế Giới Trẻ Em</strong></u></span>
                <span class="slogan-text">
                Jellycat hướng tới việc trở thành thương hiệu hàng đầu trong lĩnh vực đồ chơi bông và thú nhồi bông, nổi bật với thiết kế độc đáo và khả năng mang lại niềm vui cho mọi người. Sứ mệnh của chúng tôi là tạo ra những sản phẩm không chỉ đẹp mắt mà còn khuyến khích trí tưởng tượng và sự sáng tạo ở trẻ em. Chúng tôi cam kết sử dụng chất liệu cao cấp, an toàn và thân thiện với trẻ em, nhằm đảm bảo mỗi món đồ chơi đều là người bạn đồng hành đáng tin cậy. Jellycat mong muốn sản phẩm của mình sẽ góp phần tạo ra những khoảnh khắc đáng nhớ và những kỷ niệm đẹp trong mỗi gia đình, nơi mà niềm vui và sự kết nối luôn hiện hữu.
                </span>
                
            </div>
            <span class="quote-right">"</span>
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
    
    <script src = "danhmuc.js"></script>
    </body>
</html>