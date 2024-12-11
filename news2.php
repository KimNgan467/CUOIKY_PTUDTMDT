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
        a {
            text-decoration: none; /* Bỏ gạch dưới cho tất cả các thẻ a */
        }
        .back{
            text-align: center;
            margin-top: 20px;
            text-decoration-line: none;
        }
        .back:hover {
            text-align: center;
            margin-top: 20px;
            text-decoration-line:underline ;
            color:#c44b01

        }
        .back a {
            color: #f76d16;
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
        <h1 class="title">Tin tức & sự kiện</h1>
        <div class="news-grid">
            <div class="news-item">
                <a href="tintuc2.html" target="_blank">
                    <div class="image-placeholder">
                        <img src="picture/gau-noel.jpg" alt="Tên tin tức 1">
                    </div>
                    <p class="news-type">Sự kiện</p>
                    <div class="news-meta">Ngày đăng: 09/06/2024 | Tác giả: Jelly Cat</div>
                    <p class="news-name">Trải nghiệm Jellycat mùa Noel</p>
                </a>
            </div>
            <div class="news-item">
                <a href="https://vietcetera.com/vn/gen-z-viet-nam-lac-quan-nhat-dong-nam-a" target="_blank">
                    <div class="image-placeholder">
                        <img src="picture/vietnam.png" alt="Tên tin tức 1">
                    </div>
                    <p class="news-type">Tin tức</p>
                    <div class="news-meta">Ngày đăng: 09/05/2024 | Tác giả: Hien Le</div>
                    <p class="news-name">Gen Z Việt Nam lạc quan nhất Đông Nam Á?
                    </p>
                </a>
            </div>
            <div class="news-item">
                <a href="https://vietcetera.com/vn/manifest-la-gi-ma-nhieu-nguoi-thanh-tam-muon-thu-hut" target="_blank">
                    <div class="image-placeholder">
                        <img src="picture/1-1-.webp" alt="Tên tin tức 1">
                    </div>
                    <p class="news-type">Tin tức</p>
                    <div class="news-meta">Ngày đăng: 09/04/2024 | Tác giả: Rachel Vo</div>
                    <p class="news-name">Manifest là gì mà nhiều người thành tâm muốn thu hút?</p>
                </a>
            </div>
        </div>
    </div>
    <div class="back"> <a href="news.php">Quay trở lại</a></div>
</body>
</html>
