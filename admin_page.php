<?php

@include 'config.php';

if(isset($_POST['add_news'])){

   $news_name = $_POST['news_name'];
   $news_date = $_POST['news_date'];
   $news_author = $_POST['news_author'];
   $news_content = $_POST['news_content'];
   $news_image = $_FILES['news_image']['name'];
   $news_image_tmp_name = $_FILES['news_image']['tmp_name'];
   $news_image_folder = 'uploaded_img/'.$news_image;

   if(empty($news_name) ||  empty ($news_date) || empty($news_author) || empty($news_content) || empty($news_image)){
      $message[] = 'please fill out all';
   }else{
      $insert = "INSERT INTO news(name, date, author, content, image) VALUES('$news_name', '$news_date', '$news_author', '$news_content', '$news_image')";
      $upload = mysqli_query($conn,$insert);
      if($upload){
         move_uploaded_file($news_image_tmp_name, $news_image_folder);
         $message[] = 'Tin tức đã được cập nhật!';
      }else{
         $message[] = 'Không thể thêm tin tức!';
      }
   }

};

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM news WHERE id = $id");
   header('location:admin_page.php');
};

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>

<?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}

?>
   
<div class="container">

   <div class="admin-news-form-container">

      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
         <h3>Thêm tin tức mới</h3>
         <input type="text" placeholder="Nhập tên tin tức" name="news_name" class="box">
         <input type="date" name="news_date" class="box">
         <input type="text" placeholder="Nhập tên tác giả" name="news_author" class="box">
         <textarea placeholder="Nhập nội dung" name="news_content" class="box"></textarea>
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="news_image" class="box">
         <input type="submit" class="btn" name="add_news" value="Thêm tin tức">
      </form>

   </div>

   <?php

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
            <th>Quản lý</th>
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['author']; ?></td>
            <td><?php echo $row['content']; ?>/-</td>
            <td>
               <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> Sửa </a>
               <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> Xoá </a>
            </td>
         </tr>
      <?php } ?>
      </table>
   </div>

</div>


</body>
</html>