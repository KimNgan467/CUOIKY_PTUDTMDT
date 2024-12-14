<?php

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

$id = $_GET['edit'];

if(isset($_POST['update_news'])){

    $news_name = mysqli_real_escape_string($conn, $_POST['news_name']);
    $news_date = mysqli_real_escape_string($conn, $_POST['news_date']);
    $news_author = mysqli_real_escape_string($conn, $_POST['news_author']);
    $news_content = mysqli_real_escape_string($conn, $_POST['news_content']);
    $news_link = mysqli_real_escape_string($conn, $_POST['news_link']);
    $news_image = mysqli_real_escape_string($conn, $_FILES['news_image']['name']);
    $news_image_tmp_name = $_FILES['news_image']['tmp_name'];
    $news_image_folder = 'picture/'.$news_image;

    // Kiểm tra các trường không được bỏ trống
    if(empty($news_name) || empty($news_date) || empty($news_author) || 
       empty($news_content) || empty($news_image) || empty($news_link)) {
        $message[] = 'Vui lòng điền vào chỗ trống!';   
    } else {
        // Cập nhật dữ liệu vào cơ sở dữ liệu
        $update_data = "UPDATE news SET name='$news_name', date='$news_date', author='$news_author', content='$news_content', link='$news_link', image='$news_image' WHERE id = '$id'";
        
        // Thực hiện truy vấn
        $upload = mysqli_query($conn, $update_data);

        // Kiểm tra kết quả truy vấn
        if($upload) {
            move_uploaded_file($news_image_tmp_name, $news_image_folder);
            header('location:qttintuc_add.php');
            exit();
        } else {
            // Hiển thị thông báo lỗi cụ thể
            $message[] = 'Có lỗi xảy ra khi cập nhật: ' . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="qttintuc2.css">
    <title>CẬP NHẬT TIN TỨC</title>
</head>
<body>

<?php
// Hiển thị thông báo lỗi nếu có
if(isset($message)){
    foreach($message as $msg){
        echo '<span class="message">'.$msg.'</span>';
    }
}
?>

<div class="container">
    <div class="admin-news-form-container centered">
        <?php
        // Lấy dữ liệu từ cơ sở dữ liệu để hiển thị trong form
        $select = mysqli_query($conn, "SELECT * FROM news WHERE id = '$id'");
        while($row = mysqli_fetch_assoc($select)){
        ?>
            <form action="" method="post" enctype="multipart/form-data">
                <h3 class="title">CẬP NHẬT TIN TỨC</h3>
                <input type="text" class="box" name="news_name" value="<?php echo htmlspecialchars($row['name']); ?>" placeholder="Nhập tên tin tức">
                <input type="date" class="box" name="news_date" value="<?php echo htmlspecialchars($row['date']); ?>" placeholder="Nhập ngày tin tức">
                <input type="text" class="box" name="news_author" value="<?php echo htmlspecialchars($row['author']); ?>" placeholder="Nhập tác giả tin tức">
                <textarea class="box" name="news_content" placeholder="Nhập nội dung"><?php echo htmlspecialchars($row['content']); ?></textarea>
                <input type="text" class="box" name="news_link" value="<?php echo htmlspecialchars($row['link']); ?>" placeholder="Nhập link bài viết">
                <input type="file" class="box" name="news_image" accept="image/png, image/jpeg, image/jpg">
                <input type="submit" value="Cập nhật" name="update_news" class="btn">
                <a href="qttintuc_add.php" class="btn">Quay lại</a>
            </form>
        <?php }; ?>
    </div>
</div>

</body>
</html>