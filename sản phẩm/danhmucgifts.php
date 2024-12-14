<?php
$jsonFile = 'product.json';
if (file_exists($jsonFile)) {
    $currentData = file_get_contents($jsonFile);
    $productsArray = json_decode($currentData, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Lỗi đọc file JSON: " . json_last_error_msg());
    }
} else {
    $productsArray = []; // Nếu file không tồn tại, khởi tạo mảng rỗng
}

// Nhóm sản phẩm theo danh mục
$categories = [];
foreach ($productsArray as $product) {
    $category = strtolower($product['category']); // Chuyển danh mục về chữ thường
    if (!isset($categories[$category])) {
        $categories[$category] = [];
    }
    $categories[$category][] = $product; // Thêm sản phẩm vào danh mục
}
?>
<html>
<head>
    <link rel="stylesheet" href="danhmucanimals.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<header>
    <img src="Anh/logo.png">
    <div class="header-left">
        <a href="#"><strong>TRANG CHỦ</strong></a>
        <div class="drop-down">
            <a href="sp.php"><strong>SẢN PHẨM</strong></a>
            <div class="detail">
                <a href="danhmucanimals.php"><strong>ANIMALS</strong></a>
                <a href="danhmucbags&charms.php"><strong>BAGS & CHARMS</strong></a>
                <a href="danhmucamuseables.php"><strong>AMUSEABLES</strong></a>
                <a href="danhmucgifts.php"><strong>GIFTS</strong></a>
            </div>
        </div>
        <a href="#"><strong>TIN TỨC</strong></a>
    </div>
    <div class="header-right">
        <a href="#"><i class="fa fa-shopping-cart" id="cart-icon"></i></a>
        <a href="#"><i class="fa fa-user"></i></a>
    </div>
</header>

<div class="search-sort">
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
            <div class="iconCart">
                <button>Xem trước giỏ hàng</button>
                <div class="totalQuantity">0</div>
            </div>
        </div>
    </div>
    
    <section class="shop container">
        <h2> Danh mục Gifts </h2>
        <?php foreach ($categories as $category => $products): ?>
            <h2>Danh Mục: <?php echo htmlspecialchars($category); ?></h2>
            <div class="listProduct">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="productbox">
                        <div class="product-item">
                        <a href="chitietsp.php?id=<?php echo htmlspecialchars($product['id']); ?>">
                            <img style = "width: 50%;" class="product-img" src="Image/<?php echo htmlspecialchars($product['image1']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            
                                <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>

                            <div class="price">$<?php echo htmlspecialchars($product['price']); ?></div>
                    </a>
                    <div class="select-size">
                                <select class="size-select" id="size-select-<?php echo htmlspecialchars($product['id']); ?>">
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                </select>
                            </div>
                            <button onclick="addCart(<?php echo htmlspecialchars($product['id']); ?>)">Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>
    <div class="cart">
    <div class = "close_cart">
    
        <h2>GIỎ HÀNG</h2>
        <div class="close">X</div>
        </div>

        <div class="listCart">
        
            <!-- Giỏ hàng sẽ được cập nhật động -->
        </div>
        
        
        <div class="buttons">            
            <div class="checkout">
                <a href="cart.php">ĐẾN TRANG GIỎ HÀNG</a>
            </div>
            <div><button class="resetCartButton">XÓA TẤT CẢ</button></div>
        </div>
    </div>
</div>
<div class="list-page">
    <div class="item"><a href="Danhmucanimals.php">1</a></div>
    <div class="item"><a href="danhmucamuseables.php">2</a></div>
    <div class="item"><a href="danhmucbags&charms.php">3</a></div>
    <div class="item"><a href="danhmucgifts.php">4</a></div>
</div>
<footer>
    <div class="container">
        <div class="sec aboutus">
            <h2>Về chúng tôi</h2>
            <p>
                Jellycat là một công ty nổi tiếng toàn cầu, chuyên thiết kế và sản xuất các món đồ chơi nhồi bông cao cấp...
            </p>
            <ul class="sci">
                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-tiktok"></i></a></li>
                <li><a href="#"><i class="fa-solid fa-x"></i></a></li>
            </ul>
        </div>
        <div class="sec quicklinks">
            <h2>Tin tức</h2>
            <ul>
                <li><a href="#">Hết Labubu đến Jellycat gây sốt</a></li>
                <!-- Các liên kết khác -->
            </ul>
        </div>
        <div class="sec contact">
            <h2>Liên hệ</h2>
            <ul class="info">
                <li>
                    <span><i class="fa-solid fa-phone"></i></span>
                    <p><a href="tel:+12345678">+ 123 456 78</a></p>
                </li>
                <li>
                    <span><i class="fa-regular fa-envelope"></i></span>
                    <p><a href="mailto:ptudtmdt@gmail.com">ptudtmdt@gmail.com</a></p>
                </li>
            </ul>
        </div>
    </div>
</footer>
<div class="copyrightText">
    <p>© Jellycat Limited 2024 All rights reserved</p>
</div>
<script>
    const productsArray = <?php echo json_encode($productsArray); ?>;
    if (!Array.isArray(productsArray) || productsArray.length === 0) {
        alert('Lấy JSON không thành công');
    }
</script>
<?php include 'danhmucgifts_js.php';?>
</body>
</html>