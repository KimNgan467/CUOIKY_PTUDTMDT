<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Nhập Thông Tin</title>
</head>
<body>
    <h2>Nhập Thông Tin Cá Nhân, Học Vấn, Kinh Nghiệm và Kỹ Năng</h2>
    <form action="submitcv.php" method="post">
        <h3>Thông Tin Cá Nhân</h3>
        <label for="hoten">Họ Tên:</label>
        <input type="text" name="hoten" id="hoten" required placeholder="Nhập họ tên"><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required placeholder="Nhập email"><br><br>

        <label for="dienthoai">Số Điện Thoại:</label>
        <input type="text" name="dienthoai" id="dienthoai" required placeholder="Nhập số điện thoại" maxlength="15"><br><br>

        <label for="diachi">Địa Chỉ:</label>
        <textarea name="diachi" id="diachi" required placeholder="Nhập địa chỉ"></textarea><br><br>

        <label for="mota">Mô Tả:</label>
        <textarea name="mota" id="mota" required placeholder="Mô tả thêm về bản thân"></textarea><br><br>

        <h3>Thông Tin Học Vấn</h3>
        <label for="tentruong">Tên Trường:</label>
        <input type="text" name="tentruong" id="tentruong" required placeholder="Nhập tên trường"><br><br>

        <label for="chuyennganh">Chuyên Ngành:</label>
        <input type="text" name="chuyennganh" id="chuyennganh" required placeholder="Nhập chuyên ngành"><br><br>

        <label for="thoigianhoc">Thời Gian Học:</label>
        <input type="text" name="thoigianhoc" id="thoigianhoc" required placeholder="Thời gian học"><br><br>

        <h3>Thông Tin Kinh Nghiệm Làm Việc</h3>
        <label for="tencongty">Tên Công Ty:</label>
        <input type="text" name="tencongty" id="tencongty" required placeholder="Nhập tên công ty"><br><br>

        <label for="vitri">Vị Trí:</label>
        <input type="text" name="vitri" id="vitri" required placeholder="Nhập vị trí công việc"><br><br>

        <label for="thoigianlamviec">Thời Gian Làm Việc:</label>
        <input type="text" name="thoigianlamviec" id="thoigianlamviec" required placeholder="Thời gian làm việc"><br><br>

        <label for="motacongviec">Mô Tả Công Việc:</label>
        <textarea name="motacongviec" id="motacongviec" required placeholder="Mô tả công việc"></textarea><br><br>

        <h3>Kỹ Năng</h3>
        <label for="tenkynang">Tên Kỹ Năng:</label>
        <input type="text" name="tenkynang" id="tenkynang" required placeholder="Nhập kỹ năng"><br><br>

        <label for="mucdothanhthao">Mức Độ Thành Thạo:</label>
        <input type="text" name="mucdothanhthao" id="mucdothanhthao" required placeholder="Nhập mức độ thành thạo"><br><br>

        <button type="submit">Gửi</button>
    </form>
</body>
</html>
