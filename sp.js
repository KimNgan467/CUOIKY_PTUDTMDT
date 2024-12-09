
let iconCart = document.querySelector('.iconCart');
let cart = document.querySelector('.cart');
let container = document.querySelector('.container');
let close = document.querySelector('.close');

iconCart.addEventListener('click', ()=> {
    if(cart.style.right == '-100%') {
        cart.style.right = '0';
        container.style.transform = 'translateX(-400px)';
    }else {
        cart.style.right = '-100%';
        container.style.transform = 'translateX(0)';
    }
})
close.addEventListener ('click', ()=> {
    cart.style.right = '-100%';
    container.style.transform = 'translateX(0)';
})

let products = null;
// //get data from file json
fetch ('product.json')
.then(response => response.json())
.then(data => {
    products = data;
    addDataToHTML();
})

//show data in list HTML
function addDataToHTML() {
    //remove datas default in html
    let listProductHTML = document.querySelector('.listProduct');
    listProductHTML.innerHTML ='';

    //add new datas
    if(products != null) {
        products.forEach(product => {
            let newProduct = document.createElement('div');
            newProduct.classList.add('item');
            newProduct.innerHTML =
            `<img src="${product.image}" alt="">
            <h2>${product.name}</h2>
            <div class="price">$${product.price}</div>
            <button onclick="addCart(${product.id})">Thêm vào giỏ hàng</button>`;
            listProductHTML.appendChild(newProduct);
        });
    }
}
let listCart = [];
//and i get cookie data cart
function checkCart() {
    var cookieValue = document.cookie
    .split('; ')
    .find(row => row.startsWith('listCart='));
    if (cookieValue) {
        listCart = JSON.parse(cookieValue.split('=')[1]);
    }
}
checkCart();
function addCart($idProduct) {
    let productCopy = JSON.parse(JSON.stringify(products));
//     //if this product is not in the cart
    if(!listCart[$idProduct]) {
        let dataProduct = productCopy.filter(
            product => product.id == $idProduct
        ) [0];
//         //add data product in cart
        listCart[$idProduct] = dataProduct;
        listCart[$idProduct].quantity = 1
    } else {
        //if this product is alredy in the cart
        //I just increase the quantity
        listCart[$idProduct].quantity++;
    }
    //i will save datas cart in cookie
    //to save this datas cart when i turn off the computer
    let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
    document.cookie = "listCart="+JSON.stringify(listCart)+"; "+timeSave+"; path=/;";
    addCartToHTML();
}
addCartToHTML();
function addCartToHTML() {
    //clear data default
    let listCartHTML = document.querySelector('.listCart');
    listCartHTML.innerHTML = '';

    let totalHTML = document.querySelector('.totalQuantity');
    let totalQuantity = 0;

    if(listCart) {
        listCart.forEach(product => {
            if(product) {
                let newCart = document.createElement('div');
                newCart.classList.add('item');
                newCart.innerHTML =
                `<img src="${product.image}" alt="">
                <div class="content">
                    <div class="name">
                    ${product.name}
                    </div>
                    <div class="price">
                        $${product.price}/1 product
                    </div>
                </div>
                <div class="quantity">
                    <button onclick="changeQuantity(${product.id}, '-')">-</button>
                    <span class="value">
                    ${product.quantity}</span>
                    <button onclick="changeQuantity(${product.id}, '+')">+</button>
                </div>`;
                listCartHTML.appendChild(newCart);
                totalQuantity = totalQuantity + product.quantity;
            }
        })
    }
    totalHTML.innerText = totalQuantity; //làm cho số trên giỏ hàng thay đổi theo số lượng

}
function  changeQuantity($idProduct, $type) {
    switch ($type) {
        case '+':
            listCart[$idProduct].quantity++;
            break;
        case '-':
            listCart[$idProduct].quantity--;
            if (listCart[$idProduct].quantity <= 0) {
                delete listCart[$idProduct];
            }
            break;

        default:
            break
    }
    //save new data in cookie
    let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
    document.cookie = "listCart="+JSON.stringify(listCart)+"; "+timeSave+"; path=/;";


    //reload list cart in HTML
    addCartToHTML();
}

// Ví dụ: Gọi hàm resetCart khi nhấn nút "Reset Cart"
let resetButton = document.querySelector('.resetCartButton'); // Giả sử bạn có một nút với class này
resetButton.addEventListener('click', resetCart);
// Hàm reset giỏ hàng
function resetCart() {
    listCart = []; // Xóa tất cả sản phẩm trong giỏ hàng

    // Cập nhật cookie
    let timeSave = "expires=Thu, 31 Dec 2025 23:59:59 UTC";
    document.cookie = "listCart=[]; " + timeSave + "; path=/;";

    // Cập nhật lại giao diện giỏ hàng
    addCartToHTML();
}



console.log(listCart);
  
