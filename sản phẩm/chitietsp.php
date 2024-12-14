<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vidu";

// Kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // "i" cho kiểu integer
$stmt->execute();
$result = $stmt->get_result();

$json_data = file_get_contents('product.json');
$products_json = json_decode($json_data, true);
$product_from_json = null;

foreach ($products_json as $product) {
if ($product['id'] == $id) {
    $product_from_json = $product;
    break;
}
}
?>

<html>
<head>
    <link rel="stylesheet" href="chitiet.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
</head>

    <?php include 'head.php'; ?>


    <div class="iconCart">
                <button id = "view-cart-button">Xem trước giỏ hàng</button>
                <div class="totalQuantity">0</div>
            </div>
    <body>

    <section class="container sproduct my-5 pt-5">
        <div class="row mt-5">
            <div class="col-lg-5 col-md-12 col-12">
            <?php
            if ($result->num_rows > 0) {
                // Hiển thị sản phẩm
                while ($row = $result->fetch_assoc()) {
                    // Hiển thị hình ảnh sản phẩm
                    echo '<img class="product-img" id="MainImg" src="Anh/' . htmlspecialchars($row['image1']) . '" />';
                    echo '<div class="small-img-group">';
                    echo '<div class="small-img-col">';
                    echo '<img width="70%" class="small-img" src="Anh/' . htmlspecialchars($row['image1']) . '" />';
                    echo '</div>';
                    echo '<div class="small-img-col">';
                    echo '<img width="70%" class="small-img" src="Anh/' . htmlspecialchars($row['image2']) . '" />';
                    echo '</div>';
                    echo '<div class="small-img-col">';
                    echo '<img width="70%" class="small-img" src="Anh/' . htmlspecialchars($row['image3']) . '" />';
                    echo '</div>';
                    // Có thể thêm các hình ảnh phụ khác nếu cần
                    echo '</div>';
                    echo '</div>';
        echo '<div class="product">';
        echo '<h3 class="product-title">' . htmlspecialchars($row["name"]) . '</h3>';
        echo '<h4 class="price">$' . htmlspecialchars($row["price"]) . '</h4>';
        echo '<select class="my-3" id="size-select-' . htmlspecialchars($row["id"]) . '">';
        echo '<option>Select Size</option>';
        echo '<option>M</option>';
        echo '<option>L</option>';
        echo '<option>XL</option>';
        echo '</select>';
        echo '<div class="add-to-cart">';
        echo '<button onclick="addCart(' . htmlspecialchars($row["id"]) . ')">Thêm vào giỏ hàng</button>';
        echo '</div>';
        echo '<h4 class="mt-5 mb-5">Product Details</h4>';
        echo '<p>' . htmlspecialchars($row["description"]) . '</p>';
        echo '</div>'; // Đóng div.product
    }
} else {
    echo "Không tìm thấy sản phẩm.";
}

?>
</div>
</section>
<div class="cart" id = "cartPopup">
        <h2>GIỎ HÀNG</h2>
        <div class="listCart">
            <!-- Giỏ hàng sẽ được cập nhật động -->
        </div>
        <div class="close">X</div>
        <div class="buttons">            
            <div class="checkout">
                <a href="cart.php">ĐẾN TRANG GIỎ HÀNG</a>
            </div>
            <div><button class="resetCartButton">XÓA TẤT CẢ</button></div>
        </div>
    </div>
    


    <script> 
const products = <?php echo json_encode($products_json); ?>; // Sử dụng dữ liệu từ PHP

let listCart = [];

// Kiểm tra giỏ hàng từ cookie
function checkCart() {
    const cookieValue = document.cookie
        .split("; ")
        .find((row) => row.startsWith("listCart="));
    if (cookieValue) {
        try {
            listCart = JSON.parse(decodeURIComponent(cookieValue.split("=")[1]));
        } catch (e) {
            console.error("Lỗi phân tích giỏ hàng từ cookie:", e);
            listCart = []; // Nếu lỗi, khởi tạo giỏ hàng trống
        }
    } else {
        listCart = []; // Nếu không có cookie, khởi tạo giỏ hàng trống
    }
}

// Thêm sản phẩm vào giỏ hàng
function addCart(idProduct) {
    let sizeSelect = document.getElementById(`size-select-${idProduct}`);
    let selectedSize = sizeSelect.value;

    if (selectedSize === "Select Size") {
        alert("Vui lòng chọn kích thước!");
        return;
    }

    // Tìm sản phẩm trong danh sách sản phẩm
    let dataProduct = products.find(product => product.id == idProduct);

    // Kiểm tra giỏ hàng hiện tại
    checkCart();

    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
    let existingProduct = listCart.find(
        (item) => item.id === idProduct && item.size === selectedSize
    );

    if (existingProduct) {
        // Tăng số lượng nếu đã tồn tại sản phẩm cùng kích thước
        existingProduct.quantity++;
    } else {
        // Thêm sản phẩm mới nếu chưa tồn tại
        listCart.push({ ...dataProduct, quantity: 1, size: selectedSize });
    }

    // Lưu lại cookie
    let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
    document.cookie = `listCart=${encodeURIComponent(JSON.stringify(listCart))}; ${timeSave}; path=/;`;

    // Cập nhật giao diện giỏ hàng
    addCartToHTML();
}

// Hàm khởi tạo
window.onload = function() {
    init();
};

function init() {
    checkCart(); // Kiểm tra cookie giỏ hàng
    addCartToHTML(); // Hiển thị giỏ hàng từ cookie
}

// Cập nhật hiển thị giỏ hàng
function addCartToHTML() {
    let listCartHTML = document.querySelector(".listCart");
    listCartHTML.innerHTML = "";

    let totalHTML = document.querySelector(".totalQuantity");
    let totalQuantity = 0;

    if (listCart.length > 0) {
        listCart.forEach((product) => {
            let newCart = document.createElement("div");
            newCart.classList.add("item");
            newCart.innerHTML = `
                <img src="Anh/${product.image1}" alt="">
                <div class="content">
                    <div class="name">${product.name}</div>
                    <div class="price">$${product.price}/1 sản phẩm</div>
                    <div class="size">Size: ${product.size}</div>
                </div>
                <div class="quantity">
                    <button class = "change" onclick="changeQuantity('${product.id}', '${product.size}', '-')">-</button>
                    <span class="value">${product.quantity}</span>
                    <button class = "change" onclick="changeQuantity('${product.id}', '${product.size}', '+')">+</button>
                    <button class = "remove" onclick="removeFromCart('${product.id}-${product.size}')">Xóa</button>
                </div>`;
            listCartHTML.appendChild(newCart);
            totalQuantity += product.quantity;
        });
    }
    totalHTML.innerText = totalQuantity; // Cập nhật số lượng trong giỏ hàng
}

function changeQuantity(id, size, type) {
    let product = listCart.find(item => item.id == id && item.size == size);

    if (product) {
        if (type === "+") {
            product.quantity++;
        } else if (type === "-") {
            product.quantity--;
            if (product.quantity <= 0) {
                // Xóa sản phẩm nếu số lượng <= 0
                listCart = listCart.filter(item => !(item.id === id && item.size === size));
            }
        }
    }

    // Lưu lại cookie
    let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
    document.cookie = `listCart=${encodeURIComponent(JSON.stringify(listCart))}; ${timeSave}; path=/;`;

    // Cập nhật lại giao diện giỏ hàng
    addCartToHTML();
}


let iconCart = document.querySelector(".iconCart");
let cart = document.querySelector(".cart");
let container = document.querySelector(".container");
let close = document.querySelector(".close");

iconCart.addEventListener("click", () => {
  if (cart.style.right == "-100%") {
    cart.style.right = "0";
    container.style.transform = "translateX(-400px)";
  } else {
    cart.style.right = "-100%";
    container.style.transform = "translateX(0)";
  }
});
close.addEventListener("click", () => {
  cart.style.right = "-100%";
  container.style.transform = "translateX(0)";
});

// Xóa sản phẩm khỏi giỏ hàng
function removeFromCart(index) {
    listCart.splice(index, 1); // Xóa sản phẩm khỏi giỏ hàng

    // Cập nhật cookie
    let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
    document.cookie = `listCart=${encodeURIComponent(JSON.stringify(listCart))}; ${timeSave}; path=/;`;

    // Cập nhật lại giao diện giỏ hàng
    addCartToHTML();
}

// Ví dụ: Gọi hàm resetCart khi nhấn nút "Reset Cart"
let resetButton = document.querySelector(".resetCartButton"); // Giả sử bạn có một nút với class này
resetButton.addEventListener("click", resetCart);
// Hàm reset giỏ hàng
function resetCart() {
  listCart = []; // Xóa tất cả sản phẩm trong giỏ hàng

  // Cập nhật cookie
  let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
  document.cookie = "listCart=[]; " + timeSave + "; path=/;";

  // Cập nhật lại giao diện giỏ hàng
  addCartToHTML();
}


</script>
</body>
</html>