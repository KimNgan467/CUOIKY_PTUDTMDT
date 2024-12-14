<script>
let listCart = {};

function checkCart() {
  const cookieValue = document.cookie
    .split("; ")
    .find((row) => row.startsWith("listCart="))?.split("=")[1];

  if (cookieValue) {
    try {
      // Giải mã và phân tích JSON
      listCart = JSON.parse(decodeURIComponent(cookieValue));
    } catch (e) {
      console.error("Error parsing cart from cookie:", e, "Value:", cookieValue);
      listCart = []; // Nếu lỗi, khởi tạo mảng trống
    }
  } else {
    listCart = []; // Nếu không có cookie, khởi tạo mảng trống
  }
}

checkCart();
addCartToHTML();

function addCartToHTML() {
  // Clear data from HTML
  let listCartHTML = document.querySelector(".returnCart .list");
  listCartHTML.innerHTML = "";
  let totalQuantityHTML = document.querySelector(".totalQuantity");
  let totalPriceHTML = document.querySelector(".totalPrice");

  let totalQuantity = 0;
  let totalPrice = 0;

    // Nếu có sản phẩm trong giỏ hàng
    if (listCart.length > 0) {
    listCart.forEach((product) => {
      if (product) {
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
                    <button class="change" onclick="changeQuantity('${product.id}-${product.size}', '-')">-</button>
                    <span class="value">${product.quantity}</span>
                    <button class="change" onclick="changeQuantity('${product.id}-${product.size}', '+')">+</button>
                    <button class="remove" onclick="removeFromCart('${product.id}-${product.size}')">Xóa</button>
                </div>`;
        listCartHTML.appendChild(newCart);
        totalQuantity += product.quantity;
        totalPrice += product.price * product.quantity;
      }
    });
  }
  totalQuantityHTML.innerText = totalQuantity;
  totalPriceHTML.innerText = totalPrice + "đ";
}


function changeQuantity(idAndSize, type) {
  let [id, size] = idAndSize.split("-");

  // Tìm sản phẩm trong giỏ hàng dựa trên id và size
  let product = listCart.find(item => item.id == id && item.size == size);
  
  if (product) {
    // Tăng hoặc giảm số lượng
    if (type === "+") {
      product.quantity++;
    } else if (type === "-") {
      product.quantity--;
      if (product.quantity <= 0) {
        removeFromCart(idAndSize); // Xóa sản phẩm nếu số lượng <= 0
        return;
      }
    }
  }

  // Cập nhật cookie
  let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
  document.cookie = "listCart=" + JSON.stringify(listCart) + "; " + timeSave + "; path=/;";
  
  // Cập nhật lại giao diện giỏ hàng
  addCartToHTML();
}

// Xóa sản phẩm khỏi giỏ hàng
function removeFromCart(idAndSize) {
  let [id, size] = idAndSize.split("-");
  listCart = listCart.filter(item => !(item.id == id && item.size == size)); // Xóa sản phẩm khỏi giỏ hàng

  // Cập nhật cookie
  let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
  document.cookie = "listCart=" + JSON.stringify(listCart) + "; " + timeSave + "; path=/;";
  
  // Cập nhật lại giao diện giỏ hàng
  addCartToHTML();
}
</script>