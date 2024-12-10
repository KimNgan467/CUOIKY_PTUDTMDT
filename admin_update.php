<?php


@include 'config.php';


$id = $_GET['edit'];


if(isset($_POST['update_news'])){


  $news_name = $_POST['news_name'];
  $news_date = $_POST['news_date'];
  $news_author = $_POST['news_author'];
  $news_content = $_POST['news_content'];
  $news_image = $_FILES['news_image']['name'];
  $news_image_tmp_name = $_FILES['news_image']['tmp_name'];
  $news_image_folder = 'uploaded_img/'.$news_image;


  if(empty($news_name) || empty ($news_date) || empty($news_author) ||
     empty($news_content) || empty($news_image)){
     $message[] = 'Vui lòng điền vào chỗ trống!';   
  }else{


     $update_data = "UPDATE news SET name='$news_name', content='$news_content', image='$news_image'  WHERE id = '$id'";
     $upload = mysqli_query($conn, $update_data);


     if($upload){
        move_uploaded_file($news_image_tmp_name, $news_image_folder);
        header('location:admin_page.php');
     }else{
        $$message[] = 'Vui lòng điền vào chỗ trống!';
     }


  }
};


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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




<div class="admin-news-form-container centered">


  <?php
    
     $select = mysqli_query($conn, "SELECT * FROM news WHERE id = '$id'");
     while($row = mysqli_fetch_assoc($select)){


  ?>
 
  <form action="" method="post" enctype="multipart/form-data">
     <h3 class="title">THÊM TIN TỨC</h3>
     <input type="text" class="box" name="news_name" value="<?php echo $row['name']; ?>" placeholder="enter the news name">
     <input type="date" class="box" name="news_date" value="<?php echo $row['date']; ?>" placeholder="enter the news date">
     <input type="text" class="box" name="news_author" value="<?php echo $row['author']; ?>" placeholder="enter the news author">
     <textarea class="box" name="news_content" value="<?php echo $row['content']; ?>" placeholder="enter the news content"></textarea>
     <input type="file" class="box" name="news_image"  accept="image/png, image/jpeg, image/jpg">
     <input type="submit" value="update news" name="update_news" class="btn">
     <a href="admin_page.php" class="btn">Quay lại</a>
  </form>
 




  <?php }; ?>


 


</div>


</div>


</body>
</html>

