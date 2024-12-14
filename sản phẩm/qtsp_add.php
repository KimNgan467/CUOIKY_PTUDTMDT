<?php
include "qtsp_config.php";

if(isset($_POST['add_product'])){
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_size = $_POST['product_size'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];
    $product_image_tmp_name = $_FILES['product_image1']['product_image2']['product_image3']['tmp_name'];
    $product_image_folder = 'Anh/'.$product_image1.$product_image2.$product_image3;

    if(empty($product_name) || empty($product_price) || empty($product_size) || empty($description)|| empty($category) || empty($product_image1) || empty($product_image2) || empty($product_image3)) {
        $message[] = 'Hãy điền tất cả thông tin';
    } else {
        // Sử dụng prepared statement để ngăn chặn SQL injection
        $stmt = $conn->prepare("INSERT INTO products (name, price, size, description, category, image1, image2, image3) VALUES (?, ?, ?, ?, ?, ?,?,?)");
        $stmt->bind_param("sissssss", $product_name, $product_price, $product_size, $description, $category, $product_image1, $product_image2,$product_image3);
        if($stmt->execute()){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'Thêm sản phẩm mới vào thành công';

            // Cập nhật file JSON
            updateJsonFile($conn);

            header('location:qtsp.php');
        } else {
            $message[] = 'Không thể thêm sản phẩm mới vào: ' . $stmt->error; // Hiển thị lỗi cụ thể
        }
        $stmt->close();
    }
}

function updateJsonFile($conn) {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    $products = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    // Chuyển đổi sang JSON và lưu vào file
    file_put_contents('product.json', json_encode($products, JSON_PRETTY_PRINT));
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>THÊM SẢN PHẨM</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="qtsp2.css">
    </head>
    <body>
    <?php if(isset($message)){ foreach($message as $msg){ echo "<span class='message'>$msg</span>"; } } ?>
        <div class="product-display">
            <div class="admin-product-form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3 class="title">THÊM SẢN PHẨM</h3>
                    <input type="text" class="box" name="product_name" placeholder="Nhập tên sản phẩm...">
                    <input type="number" class="box" name="product_price" placeholder="Nhập giá sản phẩm...">
                    <input type="text" name="product_size" class="box" placeholder="Nhập kích cỡ sản phẩm...">
                    <input type="text" name="description" class="box" placeholder="Nhập mô tả sản phẩm...">
                    <input type="text" name="category" class="box" placeholder="Nhập loại sản phẩm...">
                    <input type="file" class="box" name="product_image1" accept="image/png, image/jpeg, image/jpg" required>
                    <input type="file" class="box" name="product_image2" accept="image/png, image/jpeg, image/jpg">
                    <input type="file" class="box" name="product_image3" accept="image/png, image/jpeg, image/jpg">
                    <input type="submit" value="Thêm sản phẩm" name="add_product" class="btn">
                    <a href="qtsp.php" class="btn">Quay lại</a>
                </form>
            </div>
        </div>
    </body>
</html>