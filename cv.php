<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Xin Việc</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Roboto, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #b3e4ea;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #005f69;
            color: #fff;
            padding:15px;
            text-align: center;
            margin-bottom: 20px;
            width: 97%; /* Giảm chiều rộng khoảng 1cm */
            height: 50px;
        }
        .contact-info {
            display: flex;
            justify-content: center; /* Canh giữa */
            margin-bottom: 15px;
        }
        .contact-info div {
            display: flex;
            align-items: center;
            margin: 0 10px; /* Khoảng cách giữa các ô */
        }
        .contact-info input {
            padding: 8px;

            border: 1px solid #ccc;
            border-radius: 4px;
            max-width: 200px; /* Chiều rộng tối đa của ô nhập liệu */
            margin-left: 5px;
        }
        .contact-info i {
            margin-right: 8px;

            color: #f26f33;
        }
        .personal-info {
            display: flex;
            margin-bottom: 20px;
        }

        .name input
        {
            width: 400px;
        }
        .about input
        {
            width: 400px;
            height: 200px;
        }

        .personal-info img {
            border-radius: 50%;
            width: 300px;
            height: 300px;
            margin-right: 150px;
            margin-left: 75px;
            flex: 0.3; /* Cân bằng với thông tin */
        }
        .personal-info div {
            flex:0.3; /* Cân bằng với ảnh đại diện */
        }
        .experience, .education-skills, .activities {
            margin-bottom: 20px;
        }
        .education-skills {
            display: flex;
            justify-content: space-between;
        }
        .education-skills div {
            flex: 1;
            margin: 0 10px;
            padding: 10px;
            background: #005f69;
            color: white;
            border-radius: 5px;
        }

        .education-skills input{
            width: 265px;
        }

        h2, h3 {
            border-bottom: 2px solid #f26f33;
            padding-bottom: 5px;
        }
       
        input {
            width: 98%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        

        button {
            background-color: #005f69;
            color: white;
            padding: 10px 20px;
            border: 1px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 435px;
        }
        button:hover {
            background-color: #013439;
        }

    </style>
</head>
<body>
    <form action="submitcv.php" method="post">
    <div class="container">
        <div class="header">
            <div class="contact-info">
                <div>
                    <i class="fas fa-phone-alt"></i>
                    <input type="text" name="dienthoai" id="dienthoai" placeholder="Nhập số điện thoại..." required>
                </div>
                <div>
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Nhập email..."required>
                </div>
                <div>
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" name="diachi" id="diachi" placeholder="Nhập địa chỉ..."required>
                </div>
            </div>
        </div>

        <div class="personal-info">
            <img src="./ảnh/3ccd33ac-26e2-4a37-9903-4dda4eea3e1b-17217519687181717569526.webp" alt="Ảnh đại diện">
            <div class="name">
                <input type="text" name="hoten" id="hoten" placeholder="Nhập tên ứng viên..." required>
            <div class="about">
                <p>Giới thiệu:</p>
                <input type="text" name="mota" id="mota" placeholder="Giới thiệu về bản thân..."required>
            </div>
            </div>
        </div>

        <div class="experience">
            <h2>Kinh Nghiệm Làm Việc</h2>
            <p><strong>Tên công ty:</strong> <input type="text"  name="tencongty" id="tencongty" placeholder="Nhập tên công ty..."required></p>
            <p><strong>Thời gian làm việc:</strong> <input type="text"  name="thoigianlamviec" id="thoigianlamviec" placeholder="Nhập thời gian..."required></p>
            <p><strong>Vị trí:</strong> <input type="text"  name="vitri" id="vitri"  placeholder="Nhập vị trí..."required></p>
            <p><strong>Mô tả:</strong> <input type="text" type="motacongviec"  name="motacongviec" id="vitri"placeholder="Mô tả kinh nghiệm làm việc..."required></p>
        </div>

        <div class="education-skills">
            <div>
                <h3>Học Vấn</h3>
                <p><input type="text" name="tentruong" id="tentruong" placeholder="Nhập vào tên trường..."required></p>
                <p><input type="text"  name="chuyennganh" id="chuyennganh"  placeholder="Nhập chuyên ngành..."required></p>
                <p><input type="text"  name="thoigianhoc" id="thoigianhoc" placeholder="Thời gian học..."required></p>
            </div>
            <div>
                <h3>Kỹ Năng</h3>
                <p><input type="text"  name="tenkynang" id="tenkynang" placeholder="Nhập tên kỹ năng..."required></p>
                <p><input type="text"  name="mucdothanhthao" id="mucdothanhthao" placeholder="Mức độ thành tạo..."required></p>
            </div>
            <div>
                <h3>Chứng Chỉ</h3>
                <p><input type="text"  name="tenchungchi" id="tenchungchi"  placeholder="Nhập chứng chỉ..."required></p>
            </div>
        </div>

        <div class="activities">
            <h2>Hoạt Động</h2>
            <p><strong>Tên tổ chức:</strong> <input type="text" name="tentochuc" id="tentochuc" placeholder="Nhập tên tổ chức..."required></p>
            <p><strong>Vị trí:</strong> <input type="text" name="vitrihoatdong" id="vitrihoatdong" placeholder="Nhập vị trí..."required></p>
            <p><strong>Thời gian hoạt động:</strong> <input type="text" name="thoigianhoatdong" id="thoigianhoatdong" placeholder="Nhập thời gian..."required></p>
            <p><strong>Mô tả:</strong> <input type="text" name="motahoatdong" id="motahoatdong" placeholder="Mô tả hoạt động..."required></p>
        </div>
        <button type="submit">Gửi CV</button>
    </div>
</form>
</body>
</html>


