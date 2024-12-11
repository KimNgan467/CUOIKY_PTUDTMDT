<?php

@include 'config.php';

$id = $_GET['edit'];

if(isset($_POST['update_product'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_size = $_POST['product_size'];
   $product_image = $_FILES['product_image']['name'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'Ảnh/'.$product_image;

if(empty($product_name) || empty($product_price) || empty($product_size) || empty($product_image)){
      $message[] = 'Hãy điền tất cả thông tin';    
   }else{
      $update_data = "UPDATE products SET name='$product_name', price='$product_price', size='$product_size', image='$product_image'  WHERE id = '$id'";
      $upload = mysqli_query($conn, $update_data);
if($upload){
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         header('location:qtsp.php');
      } else{
         $$message[] = 'Hãy điền tất cả thông tin'; 
      }
   }
};
?>
<!DOCTYPE html>
<html>
    <head>
        <title>QTSP_UPDATE</title>
        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- custom css file link  -->
        <link rel="stylesheet" href="qtsp.css">
    </head>
    <body>
    <?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
   ?>
   <div class="product-display">
    <div class="admin-product-form-container centered">
   <?php
        $select = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
        while($row = mysqli_fetch_assoc($select)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="title">Sửa sản phẩm</h3>
      <input type="text" class="box" name="product_name" value="<?php echo $row['name']; ?>" placeholder="Nhập tên sản phẩm...">
      <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['price']; ?>" placeholder="Nhập giá sản phẩm...">
      <input type="text" name="product_size" class="box" value="<?php echo $row['size']; ?>" placeholder="Nhập kích cỡ sản phẩm...">
      <input type="file" class="box" name="product_image"  accept="image/png, image/jpeg, image/jpg">
      <input type="submit" value="Sửa sản phẩm" name="update_product" class="btn">
      <a href="qtsp.php" class="btn">Trở lại trang trước</a>
   </form>
   <?php }; ?>
   </body>
   </html>