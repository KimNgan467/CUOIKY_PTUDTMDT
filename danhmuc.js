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
    document.getElementsByClassName("btn-buy")[0]
    .addEventListener("click", buyButtonClicked);
    document.getElementById('search').addEventListener('click', searchProducts);
}

function buyButtonClicked(){
    alert('Đơn hàng của bạn đã được đặt!')
    var cartContent = document.getElementsByClassName("cart-content")[0]
    while (cartContent.hasChildNodes()){
        cartContent.removeChild(cartContent.firstChild);
    }
    updatetotal();
}
function searchProducts() {
    let searchTerm = document.getElementById('search-input').value.toLowerCase(); // Lấy giá trị tìm kiếm
    let productBoxes = document.getElementsByClassName('product-box'); // Lấy tất cả sản phẩm

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
    var shopProducts = button.parentElement;
    var title = shopProducts.getElementsByClassName("product-title")[0].innerText;
    var price = shopProducts.getElementsByClassName("price")[0].innerText;
    var productImg = shopProducts.getElementsByClassName("product-img")[0].src;
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
let field = document.querySelector('.shop-content')
let li = Array.from(field.children);
let select = document.getElementById('select');
let ar = [];
for (let product of li) {
    const priceElement = product.getElementsByClassName("price")[0]; // Lấy phần tử giá
    const priceText = priceElement.textContent.trim();
    const priceValue = parseFloat(priceText.substring(1)); // Chuyển đổi từ chuỗi sang số
    product.setAttribute('data-price', priceValue); // Sử dụng data-price để lưu giá
    ar.push(product);
}

select.onchange = sortingValue;
function sortingValue()
{
    if(this.value == 'Default')
    {
        while (field.firstChild){
            field.removeChild(field.firstChild);
        }
        field.append(...ar);
    }
    if(this.value == 'LowToHigh')
    {
        sortElem(field, li, true);
    }
    if(this.value == 'HighToLow')
    {
        sortElem(field, li, false);
    }
}
function sortElem(field, li, asc) {
    let dm = asc ? 1 : -1;
    const sortedLi = li.sort((a, b) => {
        const ax = parseFloat(a.getAttribute('data-price'));
        const bx = parseFloat(b.getAttribute('data-price'));
        return (ax - bx) * dm; // So sánh giá
    });

    // Xóa các sản phẩm cũ và thêm sản phẩm đã sắp xếp
    while (field.firstChild) {
        field.removeChild(field.firstChild);
    }
    field.append(...sortedLi);
}