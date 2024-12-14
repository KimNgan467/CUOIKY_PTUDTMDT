<script>
 document.addEventListener("DOMContentLoaded", function() {
        const products = <?php echo json_encode($categories['bags&charms'] ?? []); ?>; // sửa key 'Animals' thành 'animals'

        const productContainer = document.querySelector('.shop.container');

        // Xóa nội dung hiện tại
        productContainer.innerHTML = '';

        // Kiểm tra nếu có sản phẩm trong danh mục Animals
        if (products.length > 0) {
            products.forEach(product => {
                const productBox = document.createElement('div');
                productBox.classList.add('product-item');
                
                productBox.innerHTML = `
                    <img src="Anh/${product.image1}" alt="${product.name}" class="product-img">
                    <h2 class="product-title">${product.name}</h2>
                    <span class="price">${product.price}₫</span>
                     <button onclick="addCart(${product.id})">Thêm vào giỏ hàng</button>
                     <div class="select-size">
              <select class="size-select" id="size-select-${product.id}">
                  <option value="M">M</option>
                  <option value="L">L</option>
                  <option value="XL">XL</option>
              </select>
                        </div>
                `;
                
                productContainer.appendChild(productBox);
            });
        } else {
            productContainer.innerHTML = '<p>Không có sản phẩm nào trong danh mục này.</p>';
        }
    });
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

document.getElementById('search').addEventListener('click', searchProducts);

let products = null;
let listCart = [];
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
init();

//show data in list HTML
function addDataToHTML() {
  //remove datas default in html
  let listProductHTML = document.querySelector(".listProduct");
  listProductHTML.innerHTML = "";

  //add new datas
  if (products != null) {
    products.forEach((product) => {
      let newProduct = document.createElement("div");
      newProduct.classList.add("item");
      newProduct.innerHTML = `<img src="Anh/${product.image1}" alt="">
            <h2 class="product-title">${product.name}</h2>
            <div class="price">$${product.price}</div>
            <button onclick="addCart(${product.id})">Thêm vào giỏ hàng</button>`;
      listProductHTML.appendChild(newProduct);
    });
  }
}

//and i get cookie data cart
function checkCart() {
    const cookieValue = document.cookie
        .split("; ")
        .find((row) => row.startsWith("listCart="));
    if (cookieValue) {
        try {
            listCart = JSON.parse(decodeURIComponent(cookieValue.split("=")[1]));
        } catch (e) {
            console.error("Lỗi phân tích giỏ hàng từ cookie:", e);
            listCart = []; // Nếu lỗi, khởi tạo giỏ hàng trống dưới dạng mảng
        }
    } else {
        listCart = []; // Nếu không có cookie, khởi tạo giỏ hàng trống dưới dạng mảng
    }
}

function addCart($idProduct) {
    let sizeSelect = document.getElementById(`size-select-${$idProduct}`);
    let selectedSize = sizeSelect.value;

    // Kiểm tra giỏ hàng hiện tại
    checkCart();

    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng với cùng kích thước chưa
    let existingProduct = listCart.find(
        (item) => item.id === $idProduct && item.size === selectedSize
    );

    if (existingProduct) {
        existingProduct.quantity++; // Tăng số lượng nếu đã tồn tại
    } else {
        // Thêm sản phẩm mới nếu chưa tồn tại
        let dataProduct = products.find(product => product.id == $idProduct);
        listCart.push({ ...dataProduct, quantity: 1, size: selectedSize });
    }

    // Ghi lại vào cookie
    let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
    document.cookie = `listCart=${encodeURIComponent(JSON.stringify(listCart))}; ${timeSave}; path=/;`;

    // Cập nhật giao diện giỏ hàng
    addCartToHTML();
}
window.onload = function() {
    init();
};


addCartToHTML();
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


function addCartToHTML() {
    let listCartHTML = document.querySelector(".listCart");
    listCartHTML.innerHTML = "";

    let totalHTML = document.querySelector(".totalQuantity");
    let totalQuantity = 0;

    if (listCart.length > 0) {
        // Nhóm theo ID sản phẩm và kích thước
        let groupedCart = listCart.reduce((acc, product) => {
            let key = `${product.id}-${product.size}`;
            if (!acc[key]) {
                acc[key] = { ...product };
            } else {
                acc[key].quantity += product.quantity;
            }
            return acc;
        }, {});

        Object.values(groupedCart).forEach((product) => {
            let newCart = document.createElement("div");
            newCart.classList.add("item");
            newCart.innerHTML = `
                <img src="Anh/${product.image1}" alt="">
                <div class="content">
                    <div class="name">${product.name}</div>
                    <div class="price">${product.price}₫/1 sản phẩm</div>
                    <div class="size">Size: ${product.size}</div>
                </div>
                <div class="quantity">
                    <button onclick="changeQuantity(${listCart.indexOf(product)}, '-')">-</button>
                    <span class="value">${product.quantity}</span>
                    <button onclick="changeQuantity(${listCart.indexOf(product)}, '+')">+</button>
                    <button onclick="removeFromCart(${listCart.indexOf(product)})">Xóa</button>
                </div>`;
            listCartHTML.appendChild(newCart);
            totalQuantity += product.quantity;
        });
    }
    totalHTML.innerText = totalQuantity; // Cập nhật tổng số lượng trong giỏ hàng
}


function changeQuantity(index, type) {
    if (type === "+") {
        listCart[index].quantity++;
    } else if (type === "-") {
        listCart[index].quantity--;
        if (listCart[index].quantity <= 0) {
            listCart.splice(index, 1); // Xóa sản phẩm nếu số lượng <= 0
        }
    }

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

function searchProducts() {
    let searchTerm = document.getElementById('search-input').value.toLowerCase();
    let productBoxes = document.getElementsByClassName('product-item'); // Lấy tất cả các sản phẩm

    // Duyệt qua tất cả các sản phẩm
    for (let i = 0; i < productBoxes.length; i++) {
        let productName = productBoxes[i].getElementsByClassName('product-title')[0].innerText.toLowerCase(); // Lấy tên sản phẩm

        // Kiểm tra xem tên sản phẩm có chứa từ khóa tìm kiếm không
        if (productName.includes(searchTerm)) {
            productBoxes[i].style.display = ''; // Hiển thị sản phẩm nếu có trong tìm kiếm
        } else {
            productBoxes[i].style.display = 'none'; // Ẩn sản phẩm nếu không có trong tìm kiếm
        }
    }
}





function removeFromCart(index) {
    listCart.splice(index, 1); // Xóa sản phẩm khỏi giỏ hàng

    // Cập nhật cookie
    let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
    document.cookie = `listCart=${encodeURIComponent(JSON.stringify(listCart))}; ${timeSave}; path=/;`;

    // Cập nhật lại giao diện giỏ hàng
    addCartToHTML();
}


document.addEventListener("DOMContentLoaded", function() {
    const products = <?php echo json_encode($categories['bags&charms'] ?? []); ?>; // Sử dụng JSON từ PHP
    const productContainer = document.querySelector('.shop.container');
    const selectFilter = document.getElementById('select');

    function displayProducts(productsToDisplay) {
        // Xóa nội dung hiện tại
        productContainer.innerHTML = '';

        // Kiểm tra nếu có sản phẩm
        if (productsToDisplay.length > 0) {
            productsToDisplay.forEach(product => {
                const productBox = document.createElement('div');
                productBox.classList.add('product-item');
            
                productBox.innerHTML = `
                <div class = "productbox">
                <div class = "productitem">
                <a href="chitietsp.php?id=${product.id}">
                    <img style = "width: 50%;" src="Anh/${product.image1}" alt="${product.name}" class="product-img">
                    <h2 style = "margin-top: 5px;" class="product-title">${product.name}</h2>
                    <span class="price">${product.price}₫</span>
                    </a>
                    <button onclick="addCart(${product.id})">Thêm vào giỏ hàng</button>
                    <div class="select-size">
                        <select class="size-select" id="size-select-${product.id}">
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>
                    </div>
                    </div>
                    </div>
                `;
                
                productContainer.appendChild(productBox);
            });
        } else {
            productContainer.innerHTML = '<p>Không có sản phẩm nào trong danh mục này.</p>';
        }
    }

    function filterProducts() {
        const selectedOption = selectFilter.value;
        let sortedProducts = [...products]; // Tạo bản sao của mảng sản phẩm

        if (selectedOption === 'LowToHigh') {
            sortedProducts.sort((a, b) => a.price - b.price);
        } else if (selectedOption === 'HighToLow') {
            sortedProducts.sort((a, b) => b.price - a.price);
        }

        displayProducts(sortedProducts); // Hiển thị sản phẩm đã được sắp xếp
    }

    // Hiển thị sản phẩm ban đầu
    displayProducts(products);
    
    // Lắng nghe sự kiện thay đổi trên select
    selectFilter.addEventListener('change', filterProducts);
});

console.log(listCart);

window.onload = function() {
    init();
};
</script>

   

