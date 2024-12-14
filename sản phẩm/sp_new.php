<script>
let iconCart = document.querySelector(".iconCart");
let cart = document.querySelector(".cart");
let container = document.querySelector(".container");
let close = document.querySelector(".close");


iconCart.addEventListener("click", () => {
    if (cart.style.right === "-100%") {
        cart.style.right = "0";
        cart.style.zIndex = "9999"; // Đặt z-index khi mở
    } else {
        cart.style.right = "-100%";
        cart.style.zIndex = ""; // Đặt lại z-index khi đóng
    }
    container.style.transform = cart.style.right === "0" ? "translateX(-400px)" : "translateX(0)";
});

close.addEventListener("click", () => {
    cart.style.right = "-100%";
    container.style.transform = "translateX(0)";
});


let products = null;
let listCart = [];


function checkCart() {
    const cookieValue = document.cookie.split("; ").find(row => row.startsWith("listCart="));
    if (cookieValue) {
        try {
            listCart = JSON.parse(cookieValue.split("=")[1]);
        } catch (e) {
            console.error("Error parsing cart from cookie:", e);
            listCart = []; // Nếu có lỗi, đặt lại listCart thành mảng rỗng
        }
    } else {
        listCart = []; // Nếu không có cookie, khởi tạo listCart rỗng
    }
}

// Hàm khởi tạo trang
function init() {
    checkCart(); // Kiểm tra cookie giỏ hàng
    fetch("product.json")
        .then((response) => response.json())
        .then((data) => {
            products = data;
            addDataToHTML();
            addCartToHTML(); // Hiển thị giỏ hàng từ cookie
        });
}

// Gọi hàm khởi tạo
init();

function addDataToHTML() {
    let listProductHTML = document.querySelector(".listProduct");
    listProductHTML.innerHTML = "";

    if (products != null) {
        products.forEach((product) => {
            let newProduct = document.createElement("div");
            newProduct.classList.add("item");
            newProduct.innerHTML = `
            <a href="chitietsp.php?id=${product.id}">
            <img src="Anh/${product.image1}" alt="">
                <h2 class="product-title">${product.name}</h2>
                <div class="price">$${product.price}</div>
                </a>
                <div class="select-size">
                    <select class="size-select" id="size-select-${product.id}">
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                </div>
                <button onclick="addCart(${product.id})">Thêm vào giỏ hàng</button>`;
            listProductHTML.appendChild(newProduct);
        });
    }
}

function addCart(idProduct) {
    let sizeSelect = document.getElementById(`size-select-${idProduct}`);
    let selectedSize = sizeSelect.value;

    let productCopy = JSON.parse(JSON.stringify(products));
    let dataProduct = productCopy.find(product => product.id == idProduct);

    // Tạo một đối tượng sản phẩm với kích thước và số lượng
    let productEntry = { ...dataProduct, quantity: 1, size: selectedSize };

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    const existingProductIndex = listCart.findIndex(item => item.id === idProduct && item.size === selectedSize);

    if (existingProductIndex === -1) {
        // Nếu sản phẩm chưa có, thêm vào mảng
        listCart.push(productEntry);
    } else {
        // Nếu sản phẩm đã có, tăng số lượng
        listCart[existingProductIndex].quantity++;
    }

    // Cập nhật cookie
    let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
    document.cookie = "listCart=" + JSON.stringify(listCart) + "; " + timeSave + "; path=/;";
    addCartToHTML();
}

// Khởi tạo khi trang được tải
window.onload = function() {
    init();
};

function addCartToHTML() {
    let listCartHTML = document.querySelector(".listCart");
    listCartHTML.innerHTML = "";

    let totalHTML = document.querySelector(".totalQuantity");
    let totalQuantity = 0;


    // Nhóm sản phẩm theo ID và kích thước
    let groupedCart = listCart.reduce((acc, product) => {
        let key = `${product.id}-${product.size}`;
        if (!acc[key]) {
            acc[key] = { ...product }; // Thêm sản phẩm mới
        } else {
            acc[key].quantity += product.quantity; // Cộng số lượng
        }
        return acc;
    }, {});

    // Hiển thị sản phẩm trong giỏ hàng
    for (let key in groupedCart) {
        let product = groupedCart[key];
        let newCart = document.createElement("div");
        newCart.classList.add("item");
        newCart.innerHTML = 
              `<img src="Anh/${product.image1}" alt="">
                <div class="content">
                    <div class="name">${product.name}</div>
                    <div class="price">$${product.price}/1 sản phẩm</div>
                    <div class="size">Size: ${product.size}</div>
                </div>
                <div class="quantity">
                    <button class="change" onclick="changeQuantity('${key}', '-')">-</button>
                    <span class="value">${product.quantity}</span>
                    <button class="change" onclick="changeQuantity('${key}', '+')">+</button>
                    <button class="remove" onclick="removeFromCart('${key}')">Xóa</button>
                </div>`;
        listCartHTML.appendChild(newCart);
        totalQuantity += product.quantity;
    }

    totalHTML.innerText = totalQuantity;

}


function removeFromCart(key) {
    listCart = listCart.filter(product => `${product.id}-${product.size}` !== key); // Xóa sản phẩm theo key
    let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
    document.cookie = "listCart=" + JSON.stringify(listCart) + "; " + timeSave + "; path=/;";
    addCartToHTML();
}

function changeQuantity(key, type) {
    const index = listCart.findIndex(product => `${product.id}-${product.size}` === key);
    if (index > -1) {
        if (type === "+") {
            listCart[index].quantity++;
        } else if (type === "-") {
            listCart[index].quantity--;
            if (listCart[index].quantity <= 0) {
                removeFromCart(key); // Xóa sản phẩm nếu số lượng <= 0
                return;
            }
        }

        let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
        document.cookie = "listCart=" + JSON.stringify(listCart) + "; " + timeSave + "; path=/;";
        addCartToHTML();
    }
}

document.querySelector(".resetCartButton").addEventListener("click", resetCart);

function resetCart() {
    // Xóa tất cả cookie liên quan đến giỏ hàng
    document.cookie = "listCart=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    listCart = []; // Đặt lại listCart thành đối tượng rỗng
    addCartToHTML();
}

function searchProducts() {
    let searchTerm = document.getElementById('search-input').value.toLowerCase();
    let productBoxes = document.getElementsByClassName('item');

    for (let i = 0; i < productBoxes.length; i++) {
        let productName = productBoxes[i].getElementsByClassName('product-title')[0].innerText.toLowerCase();
        productBoxes[i].style.display = productName.includes(searchTerm) ? '' : 'none';
    }
}

document.getElementById('search').addEventListener('click', searchProducts);

document.getElementById('select').addEventListener('change', filterProducts);

function filterProducts() {
    let sortValue = document.getElementById('select').value;
    let sortedProducts = [...products];

    if (sortValue === 'LowToHigh') {
        sortedProducts.sort((a, b) => a.price - b.price);
    } else if (sortValue === 'HighToLow') {
        sortedProducts.sort((a, b) => b.price - a.price);
    }

    displayProducts(sortedProducts);
}

function displayProducts(productsToDisplay) {
    let listProductHTML = document.querySelector(".listProduct");
    listProductHTML.innerHTML = "";

    productsToDisplay.forEach((product) => {
        let newProduct = document.createElement("div");
        newProduct.classList.add("item");
        newProduct.innerHTML = `<img src="Anh/${product.image1}" alt="">
            <h2 class="product-title">${product.name}</h2>
            <div class="price">$${product.price}</div>
            <div class="select-size">
              <select class="size-select" id="size-select-${product.id}">
                  <option value="M">M</option>
                  <option value="L">L</option>
                  <option value="XL">XL</option>
              </select>
            </div>
            <button onclick="addCart(${product.id})">Thêm vào giỏ hàng</button>`;
        listProductHTML.appendChild(newProduct);
    });
}

window.onload = function() {
    // Gọi init để khởi tạo dữ liệu
    init();
};
</script>