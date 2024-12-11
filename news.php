<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức & Sự kiện</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
    <style>

    html {
            font-size: 55%;
        }
        body {
            font-family: Tahoma,  sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: left;
            font-size: 24px;
            color: #f76d16;
            margin-bottom: 20px;
        }
        .news-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .news-item {
            position: relative;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Giúp ẩn phần vượt ra ngoài */
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .news-meta {
            font-size: 12px;
            color: #666;
        }
        .news-item:hover {
            transform: translateY(-5px); /* Nâng khung lên khi hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .image-placeholder {
            width: 100%;
            height: 250px;
            background-color: #f0f0f0;
            margin-bottom: 10px;
            overflow: hidden; /* Ẩn phần vượt ra ngoài */
        }
        .image-placeholder img {
            width: 100%;
            height: 250px; /* Giữ tỷ lệ hình ảnh */
            object-fit: cover;
        }
        .news-type {
            font-size: 14px;
            color: #666;
        }
        .news-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .more-news {
            text-align: center;
            margin-top: 20px;
            text-decoration-line: none;
        }
        .more-news:hover {
            text-align: center;
            margin-top: 20px;
            text-decoration-line:underline ;
            color:#c44b01

        }
        .more-news a {
            color: #f76d16;
        }
        a {
            text-decoration: none; /* Bỏ gạch dưới cho tất cả các thẻ a */
        }
        @media (max-width: 768px) {
            h1 {
                text-align: center;
                font-size: 20px;
            }

            .news-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .news-item {
                padding: 10px;
            }

            .image-placeholder {
                height: 250px;
            }

            .news-name {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 18px;
                margin-bottom: 15px;
            }

            .container {
                padding: 10px;
            }

            .news-item {
                padding: 8px;
            }

            .image-placeholder {
                height: 220px;
            }

            .news-type, .news-name {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tin tức & sự kiện</h1>
        <div class="news-grid">
            <div class="news-item">
                <a href="tintuc1.html" target="_blank">
                    <div class="image-placeholder">
                        <img src="picture/sh-cafe-activation-4.jpg" alt="Tên tin tức 1">
                    </div>
                    <p class="news-type">Sự kiện</p>
                    <div class="news-meta">Ngày đăng: 09/12/2024 | Tác giả: Jelly cat</div>
                    <p class="news-name">Trải Nghiệm Jellycat CAFÉ tại Trung Tâm Kerry Jing An, Thượng Hải</p>
                </a>
            </div>
            <div class="news-item">
                <a href="https://advertisingvietnam.com/jellycat-va-hanh-trinh-chinh-phuc-trai-tim-khach-hang-cua-hang-pop-up-thu-hut-hang-nghin-luot-ghe-tham-boi-trai-nghiem-lam-gau-bong-chan-that-p25377" target="_blank">
                    <div class="image-placeholder">
                        <img src="picture/Screenshot 2024-12-04 at 21.52.14.png" alt="Tên tin tức 2">
                    </div>
                    <p class="news-type">Tin tức</p>
                    <div class="news-meta">Ngày đăng: 20/10/2024 | Tác giả: Kim Yến</div>
                    <p class="news-name">Gấu bông và hành trình chinh phục trái tim khách hàng | Chúc mừng 20-10</p>
                </a>
            </div>
            <div class="news-item">
                <a href="https://lifestyle.znews.vn/jellycat-la-gi-ma-duoc-lo-lem-chao-yeu-thich-post1500529.html" target="_blank">
                    <div class="image-placeholder">
                        <img src="picture/tho.webp" alt="Tên tin tức 3">
                    </div>
                    <p class="news-type">Tin tức</p>
                    <div class="news-meta">Ngày đăng: 09/10/2024 | Tác giả: Linh Vũ</div>
                    <p class="news-name">Hết Labubu đến Jellycat gây sốt</p>
                    
                </a>
            </div>
            <div class="news-item">
                <a href="https://vnexpress.net/chu-cho-de-thuong-nhat-the-gioi-bi-nham-la-gau-bong-4013339.html" target="_blank">
                    <div class="image-placeholder">
                        <img src="Picture/cho.jpg" alt="Tên tin tức 4">
                    </div>
                    <p class="news-type">Tin tức</p>
                    <div class="news-meta">Ngày đăng: 09/09/2024 | Tác giả: Minh Trang</div>
                    <p class="news-name">Mê gấu bông "biết đi" nên mình chọn mua Jellycat: Trải nghiệm siêu chill </p>
                </a>
            </div>
            <div class="news-item">
                <a href="https://cany.vn/blog/gau-bong-jellycat-co-gi-thu-vi-ma-em-pam-yeu-oi-lai-me-den-vay" target="_blank">
                    <div class="image-placeholder">
                        <img src="picture/pam.png" alt="Tên tin tức 5">
                    </div>
                    <p class="news-type">Tin tức</p>
                    <div class="news-meta">Ngày đăng: 09/08/2024 | Tác giả: Thuỳ Dung</div>
                    <p class="news-name">Gấu bông Pamyeuoi có gì đặc biệt?</p>
                </a>
            </div>
            <div class="news-item">
                <a href="https://vietcetera.com/vn/anh-chang-thu-gian-bieu-tuong-moi-cua-loi-song-cu-chill-di" target="_blank">
                    <div class="image-placeholder">
                        <img src="picture/chill.png" alt="Tên tin tức 6">
                    </div>
                    <p class="news-type">Sự kiện</p>
                    <div class="news-meta">Ngày đăng: 09/07/2024 | Tác giả: Rachel Vo</div>
                    <p class="news-name">Chill Noel Guy: Hãy mua gấu bông</p>
                </a>
            </div>
        </div>
        <div class="more-news">
            <a href="news2.php">Xem thêm tin tức</a>
        </div>
    </div>
</body>
</html>