<?php
@include 'config.php';

if(isset($_POST['add_product'])){
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_size = $_POST['product_size'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'Ảnh/'.$product_image;

    if(empty($product_name) || empty($product_price) || empty($product_size) || empty($product_image)) {
        $message[] = 'Hãy điền tất cả thông tin';
    } else {
        // Sử dụng prepared statement để ngăn chặn SQL injection
        $stmt = $conn->prepare("INSERT INTO products (name, price, size, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sids", $product_name, $product_price, $product_size, $product_image);
        if($stmt->execute()){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            header('location:qtsp.php');
            $message[] = 'Thêm sản phẩm mới vào thành công';
        } else {
            $message[] = 'Không thể thêm sản phẩm mới vào: ' . $stmt->error; // Hiển thị lỗi cụ thể
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>QTSP_ADD</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="qtsp.css">
    </head>
    <body>
    <?php if(isset($message)){ foreach($message as $msg){ echo "<span class='message'>$msg</span>"; } } ?>
        <div class="product-display">
            <div class="admin-product-form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3 class="title">Thêm sản phẩm</h3>
                    <input type="text" class="box" name="product_name" placeholder="Nhập tên sản phẩm...">
                    <input type="number" class="box" name="product_price" placeholder="Nhập giá sản phẩm...">
                    <input type="text" name="product_size" class="box" placeholder="Nhập kích cỡ sản phẩm...">
                    <input type="file" class="box" name="product_image" accept="image/png, image/jpeg, image/jpg">
                    <input type="submit" value="+ Thêm sản phẩm" name="add_product" class="btn">
                    <a href="qtsp.php" class="btn">Trở lại trang trước</a>
                </form>
            </div>
        </div>
    </body>
</html>