<?php
// Đường dẫn đến file JSON
$jsonFile = 'product.json';

// Kiểm tra xem file đã tồn tại chưa
if (file_exists($jsonFile)) {
    // Đọc nội dung file JSON
    $currentData = file_get_contents($jsonFile);
    $productsArray = json_decode($currentData, true);
} else {
    $productsArray = []; // Nếu file không tồn tại, khởi tạo mảng rỗng
}
?>

<?php include "head.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TRANG SẢN PHẨM</title>
    <link rel="stylesheet" href="fontawesome/css/all.css" />
    <link rel="stylesheet" href="sp.css" />
</head>
<body>
    <div class="search-left">
        <div id="search-container">
            <input type="search" id="search-input" placeholder="Tìm kiếm..." />
            <button type="submit" id="search"><i class="fa fa-search"></i></button>
            <div class="filter-condition">
                <span>Lọc sản phẩm</span>
                <select id="select">
                    <option value="Default">Mặc định</option>
                    <option value="LowToHigh">Thấp đến cao</option>
                    <option value="HighToLow">Cao đến thấp</option>
                </select>
            </div>
        </div>
        <div class="iconCart">
            <div class="totalQuantity">0</div>
            <button class="previewCart">Xem trước giỏ hàng</button>            
        </div>
    </div>
    
    <div class="container">
        <div class="listProduct">
            <?php if (!empty($productsArray)): ?>
                <?php foreach ($productsArray as $product): ?>
                    <div class="item">
                        <<a href="chitietsp.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                        <img src="Anh/<?php echo htmlspecialchars($product['image1']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                        <h2 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h2>
                </a>
                        <div class="select-size">
                            <select name="size">
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                        </div>
                        <div class="price"><?php echo htmlspecialchars($product['price']); ?>đ</div>
                        <button onclick="addCart(<?php echo $product['id']; ?>)">Thêm vào giỏ hàng</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="item">Không có sản phẩm nào.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="cart">
        <h2>GIỎ HÀNG</h2>
        <div class="listCart"></div>
        <div class="close">X</div>
        <div class="buttons">
            <div class="checkout">
                <a href="cart.php">ĐẾN TRANG GIỎ HÀNG</a>
            </div>
            <div><button class="resetCartButton">XÓA TẤT CẢ</button></div>
        </div>
    </div>
    
    <script>
        const productsArray = <?php echo json_encode($productsArray); ?>;
        if (!Array.isArray(productsArray) || productsArray.length === 0) {
            alert('Lấy JSON không thành công');
        }
    </script>
    
    <?php include 'sp_new.php'; ?>
</body>
</html>