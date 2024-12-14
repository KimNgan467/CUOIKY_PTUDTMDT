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

if (isset($_POST['add_news'])) {
    $news_name = $_POST['news_name'];
    $news_date = $_POST['news_date'];
    $news_author = $_POST['news_author'];
    $news_content = $_POST['news_content'];
    $news_link = $_POST['news_link']; // Lấy link từ form
    $news_image = $_FILES['news_image']['name'];
    $news_image_tmp_name = $_FILES['news_image']['tmp_name'];
    $news_image_folder = 'picture/' . $news_image;

    // Kiểm tra xem các trường có rỗng không
    if (empty($news_name) || empty($news_date) || empty($news_author) || empty($news_content) || empty($news_link) || empty($news_image)) {
        $message[] = 'Vui lòng điền đầy đủ thông tin!';
    } else {
        // Kiểm tra tải ảnh lên thành công
        if ($_FILES['news_image']['error'] === UPLOAD_ERR_OK) {
            // Sử dụng Prepared Statement để bảo vệ khỏi SQL Injection
            $insert = $conn->prepare("INSERT INTO news (name, date, author, content, link, image) VALUES (?, ?, ?, ?, ?, ?)");
            $insert->bind_param("ssssss", $news_name, $news_date, $news_author, $news_content, $news_link, $news_image);
            
            if ($insert->execute()) {
                // Di chuyển ảnh vào thư mục
                move_uploaded_file($news_image_tmp_name, $news_image_folder);
                $message[] = 'Tin tức đã được thêm thành công!';
            } else {
                $message[] = 'Không thể thêm tin tức! Lỗi: ' . $insert->error;
            }

            // Đóng Prepared Statement
            $insert->close();
        } else {
            $message[] = 'Lỗi khi tải ảnh lên: ' . $_FILES['news_image']['error'];
        }
    }
}

// Xử lý xóa tin tức
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = $conn->prepare("DELETE FROM news WHERE id = ?");
    $delete->bind_param("i", $id);
    
    if ($delete->execute()) {
        header('Location: qttintuc_add.php');
        exit();
    } else {
        $message[] = 'Không thể xóa tin tức! Lỗi: ' . $delete->error;
    }

    // Đóng Prepared Statement
    $delete->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>THÊM TIN TỨC</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link rel="stylesheet" href="qttintuc2.css">
</head>
<body>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<span class="message">' . $msg . '</span>';
    }
}
?>

<div class="container">
   <div class="admin-news-form-container">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
         <h3>Thêm tin tức mới</h3>
         <input type="text" placeholder="Nhập tên tin tức" name="news_name" class="box" required>
         <input type="date" name="news_date" class="box" required>
         <input type="text" placeholder="Nhập tên tác giả" name="news_author" class="box" required>
         <textarea class="box" name="news_content" placeholder="Nhập nội dung" required></textarea>
         <input type="text" placeholder="Nhập link bài viết" name="news_link" class="box" required>
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="news_image" class="box" required>
         <input type="submit" class="btn" name="add_news" value="Thêm tin tức">
         <a href="qttintuc.php" class="btn">Quay lại</a>
      </form>
   </div>

   <?php
   // Lấy tất cả tin tức
   $select = mysqli_query($conn, "SELECT * FROM news");
   ?>
   <div class="news-display">
      <table class="news-display-table">
         <thead>
         <tr>
            <th>Ảnh</th>
            <th>Tin tức</th>
            <th>Ngày thêm</th>
            <th>Tác giả</th>
            <th>Nội dung</th>
            <th>Link</th>
            <th>Quản lý</th>
         </tr>
         </thead>
         <?php while ($row = mysqli_fetch_assoc($select)) { ?>
         <tr>
            <td><img src="picture/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><?php echo $row['content']; ?></td>
            <td><a href="<?php echo $row['link']; ?>" target="_blank">Xem bài viết</a></td>
            <td>
               <a href="qttintuc_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> Sửa </a>
               <a href="qttintuc_add.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> Xóa </a>
            </td>
         </tr>
         <?php } ?>
      </table>
   </div>
</div>

</body>
</html>