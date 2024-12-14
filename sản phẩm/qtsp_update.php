<?php
include 'qtsp_config.php';

$id = $_GET['edit'];

if (isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_size = $_POST['product_size'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];
    $product_image_tmp_name = $_FILES['product_image1']['product_image2']['product_image3']['tmp_name'];
    $product_image_folder = 'Anh/' .$product_image1.$product_image2.$product_image3;

    if (empty($product_name) || empty($product_price) || empty($product_size) || empty($description) || empty($category) || empty($product_image1) || empty($product_image2) || empty($product_image3)) {
        $message[] = 'Hãy điền tất cả thông tin';
    } else {
        $update_data = "UPDATE products SET name='$product_name', price='$product_price', size='$product_size', description='$description', category='$category', image1='$product_image1', image2='$product_image2', image3='$product_image3' WHERE id = '$id'";
        $upload = mysqli_query($conn, $update_data);
        if ($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            updateJsonFile($conn); // Gọi hàm cập nhật JSON
            header('location:qtsp.php');
        } else {
            $message[] = 'Có lỗi xảy ra khi cập nhật sản phẩm.';
        }
    }
}

function updateJsonFile($conn) {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    $products = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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
    <title>CẬP NHẬT SẢN PHẨM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="qtsp2.css">
</head>
<body>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<span class="message">' . $msg . '</span>';
        }
    }
    ?>
    <div class="product-display">
        <div class="admin-product-form-container centered">
            <?php
            $select = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
            while ($row = mysqli_fetch_assoc($select)) {
            ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <h3 class="title">CẬP NHẬT SẢN PHẨM</h3>
                    <input type="text" class="box" name="product_name" value="<?php echo $row['name']; ?>" placeholder="Nhập tên sản phẩm...">
                    <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['price']; ?>" placeholder="Nhập giá sản phẩm...">
                    <input type="text" name="product_size" class="box" value="<?php echo $row['size']; ?>" placeholder="Nhập kích cỡ sản phẩm...">
                    <input type="text" name="description" class="box" value="<?php echo $row['size']; ?>" placeholder="Nhập mô tả sản phẩm...">
                    <input type="text" name="category" class="box" value="<?php echo $row['size']; ?>" placeholder="Nhập loại sản phẩm...">
                    <input type="file" class="box" name="product_image1" accept="image/png, image/jpeg, image/jpg" required> 
                    <input type="file" class="box" name="product_image2" accept="image/png, image/jpeg, image/jpg">
                    <input type="file" class="box" name="product_image3" accept="image/png, image/jpeg, image/jpg">
                    <input type="submit" value="Cập nhật" name="update_product" class="btn">
                    <a href="qtsp.php" class="btn">Quay lại</a>
                </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>