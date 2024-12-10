let cartIcon = document.querySelector("#cart-icon");
let cart = document.querySelector(".cart");
let closeCart = document.querySelector("#close-cart");

cartIcon.onclick = () => {
    cart.classList.add("active");
};

closeCart.onclick = () => {
    cart.classList.remove("active");
};

if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready);
} else {
    ready();
}

function ready() {
    var removeCartButtons = document.getElementsByClassName("cart-remove");
    console.log(removeCartButtons);
    for (var i = 0; i < removeCartButtons.length; i++) {
        var button = removeCartButtons[i];
        button.addEventListener('click', removeCartItem);
    }
    var quantityInputs = document.getElementsByClassName("cart-quantity");
    for (var i = 0; i < quantityInputs.length; i++) {
        var input = quantityInputs[i];
        input.addEventListener("change", quantityChanged);
    }
    var addCart = document.getElementsByClassName("add-cart");
    for (var i = 0; i < addCart.length; i++) {
        var button = addCart[i];
        button.addEventListener("click", addCartClicked);
    }
    var addCartButtons = document.getElementsByClassName("buy-btn");
    for (var i = 0; i < addCartButtons.length; i++) {
        var button = addCartButtons[i];
        button.addEventListener("click", addCartClicked);
    }

    document.getElementsByClassName("btn-buy")[0]
    .addEventListener("click", buyButtonClicked);
}

function buyButtonClicked(){
    alert('Đơn hàng của bạn đã được đặt!')
    var cartContent = document.getElementsByClassName("cart-content")[0]
    while (cartContent.hasChildNodes()){
        cartContent.removeChild(cartContent.firstChild);
    }
    updatetotal();
}



function removeCartItem(event) {
    var buttonClicked = event.target;
    buttonClicked.parentElement.remove();
    updatetotal();
}

function quantityChanged(event) {
    var input = event.target;
    if (isNaN(input.value) || input.value <= 0) {
        input.value = 1;
    }
    updatetotal();
}

function addCartClicked(event) {
    var button = event.target;
    var shopProducts = button.parentElement; // Lấy phần tử cha của nút "Add To Cart"
    var title = shopProducts.previousElementSibling.previousElementSibling.previousElementSibling.innerText;
    var price = shopProducts.previousElementSibling.previousElementSibling.innerText; // Lấy tiêu đề sản phẩm
     // Lấy giá sản phẩm
    var productImg = shopProducts.parentElement.previousElementSibling.querySelector('.product-img').src; // Lấy hình ảnh sản phẩm
    addProductToCart(title, price, productImg);
    updatetotal();
}

function addProductToCart(title, price, productImg) {
    var cartShopBox = document.createElement("div");
    cartShopBox.classList.add("cart-box");
    var cartItems = document.getElementsByClassName("cart-content")[0];
    var cartItemsNames = cartItems.getElementsByClassName("cart-product-title");
    
    for (var i = 0; i < cartItemsNames.length; i++) {
        if (cartItemsNames[i].innerText == title) {
            alert('Bạn đã thêm món đồ này vào giỏ hàng rồi!');
            return;
        }
    }
    
    var cartBoxContent = `
        <img src="${productImg}" alt="" class="cart-img">
        <div class="detail-box">
            <div class="cart-product-title">${title}</div>
            <div class="cart-price">${price}</div>
            <input type="number" value="1" class="cart-quantity">
        </div>
        <i class='bx bxs-trash-alt cart-remove'></i> `;
        
    
    cartShopBox.innerHTML = cartBoxContent;
    cartItems.append(cartShopBox);
    cartShopBox
    .getElementsByClassName('cart-remove')[0]
    .addEventListener("click", removeCartItem);
    cartShopBox
    .getElementsByClassName('cart-quantity')[0]
    .addEventListener("change", quantityChanged);
    alert('Bạn đã thêm sản phẩm thành công: ' + title);
}

function updatetotal() {
    var cartContent = document.getElementsByClassName("cart-content")[0];
    var cartBoxes = cartContent.getElementsByClassName("cart-box");
    var total = 0;
    var totalQuantity = 0; // Biến để theo dõi số lượng sản phẩm

    for (var i = 0; i < cartBoxes.length; i++) {
        var cartBox = cartBoxes[i];
        var priceElement = cartBox.getElementsByClassName("cart-price")[0];
        var quantityElement = cartBox.getElementsByClassName("cart-quantity")[0];
        var price = parseFloat(priceElement.innerText.replace("$", ""));
        var quantity = quantityElement.value;
        total += price * quantity; // Cộng dồn tổng
        totalQuantity += parseInt(quantity); // Cộng dồn số lượng
    }

    document.getElementsByClassName("total-price")[0].innerText = "$" + total; // Cập nhật tổng

    // Hiển thị thông báo về số lượng sản phẩm đã thêm
    var notification = document.getElementById("notification");
    notification.innerText = 'Bạn đã thêm ' + totalQuantity + ' sản phẩm vào giỏ hàng.';
    notification.style.display = 'block';

    // Ẩn thông báo sau 3 giây
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);

    // Ẩn giỏ hàng nếu không có sản phẩm nào
    if (cartBoxes.length === 0) {
        document.querySelector(".cart").classList.remove("active");
    }
}
var MainImg = document.getElementById("MainImg"); // Sử dụng getElementById để lấy phần tử
var smallimg = document.getElementsByClassName("small-img");

smallimg[0].onclick = function() {
    MainImg.src = smallimg[0].src;
}
smallimg[1].onclick = function() {
    MainImg.src = smallimg[1].src;
}
smallimg[2].onclick = function() {
    MainImg.src = smallimg[2].src;
}
