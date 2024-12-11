<html>
<head>
    <title>trangthanhtoan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="trangthanhtoan.css">
</head>
<body>
    <header>
            <img src="./Ảnh/Logo.png">
        <div class="header-left">
            <a href="#"><strong>TRANG CHỦ</strong></a>
            <div class="drop-down">
            <a href="#"><strong>SẢN PHẨM</strong></a>
                <div class="detail">
                    <a href="#"><strong>ANIMALS</strong></a>
                    <a href="#"><strong>BAGS & CHARMS</strong></a>
                    <a href="#"><strong>AMUSEABLES</strong></a>
                </div>
            </div>
            <a href="#"><strong>GIỎ HÀNG</strong></a>
            <a href="#"><strong>THANH TOÁN</strong></a>
            <a href="#"><strong>TIN TỨC</strong></a>
        </div>
        <div class="header-right">
            <div class="search-bar">
                <form action="#" method="get">
                    <input type="text" name="timkiem" placeholder="Tìm kiếm...">
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
                <i class="fa fa-shopping-cart"></i>
                <i class="fa fa-user"></i>
            </div>
        </div>
    </header>

    <main>
        

<div class="row">
  <div class="col-65">
    <div class="container">
      <!-- <form action="newbill.php" method="post" onsubmit="return showAlert()">  -->
      <form action="newbill.php" method="post">
        <div class="row">
          <div class="col-50">
            <h3>Thông tin đặt hàng</h3>
            <label for="fname"><i class="fa fa-user"></i> Họ và Tên</label>
            <input type="text" id="fname" name="firstname" placeholder="Nhập tại đây...." required>
            
            <label for="email"><i class="fa fa-envelope"></i> Địa chỉ Email</label>
            <input type="text" id="email" name="email" placeholder="Nhập tại đây...." required>
            
            <label for="adr"><i class="fa fa-address-card-o"></i> Địa chỉ nhận hàng</label>
            <input type="text" id="adr" name="address" placeholder="Nhập tại đây...." required>
            
            <label for="city"><i class="fa fa-institution"></i> Thành phố</label>
            <input type="text" id="city" name="city" placeholder="Nhập tại đây...." required>

            <div class="row">
              <div class="col-50">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="phone" placeholder="Nhập tại đây...." required>
              </div>
              <div class="col-50">
                <label for="note">Ghi chú (Nếu có)</label>
                <input type="text" id="note" name="note" placeholder="Nhập tại đây....">
              </div>
            </div>
          </div>



          
        </div>
        <label>
          <input type="checkbox" checked="checked" name="sameadr"> Địa chỉ giao hàng giống như địa chỉ thanh toán
        </label>
        <input type="submit" value="HOÀN THÀNH THANH TOÁN" name="dongydathang" class="btn">
      <!-- </form>
    </div>
  </div> -->
    <div class="col-35">
        <div class="container">
        <h4>Đơn đặt hàng <span class="totalQuantity" style="color:black"><i class="fa fa-shopping-cart"></i> <b>4</b></span></h4>
        <!-- thêm vào -->
        <div class="item">
            <input type="hidden" name="product_id[]" value="${product.id}"> <!-- ID sản phẩm -->
            <img src="Image/A2CL__32714.1.jpg" alt="">
            <div class="info">
                <div class="name">PRODUCT 1</div>
                <div class="price">22000đ/1 sản phẩm</div>
            </div>            
            <!-- <div class="quantity">1</div> -->
            <div class="quantity">
                <!-- <button>-</button> -->
                <span class="value">3</span>
                <!-- <button>+</button> -->
            </div>
            <div class="returnPrice" name="totalPrice">50000đ</div>
            <!-- <div class="remove"><i class="fa-solid fa-trash-can"></i></div> -->
        </div> <!--thêm đến đây-->

        <!-- <p><a href="#">Sản phẩm 1</a> <span class="price">$15</span></p>
        <p><a href="#">Sản phẩm 2</a> <span class="price">$5</span></p>
        <p><a href="#">Sản phẩm 3</a> <span class="price">$8</span></p>
        <p><a href="#">Sản phẩm 4</a> <span class="price">$2</span></p> -->
        <hr>
        <p>Tổng cộng <span class="totalPrice" style="color:black"><b>$30</b></span></p>
        </div>
    </div>
</form>
</div>
</div>
</div>
<script>
    // Giả sử giỏ hàng đã được lưu trong localStorage dưới dạng JSON (bạn có thể thay đổi cách lưu trữ)
    // const cart = [
    //     { name: "Sản phẩm 1", price: 15.00 },
    //     { name: "Sản phẩm 2", price: 10.00 },
    //     { name: "Sản phẩm 3", price: 5.00 },
    //     { name: "Sản phẩm 4", price: 8.00 }
    // ];

    let listCart = [];
    //get data cart from cookie
function checkCart() {
    var cookieValue = document.cookie
    .split('; ')
    .find (row => row.startsWith('listCart='));
    if (cookieValue) {
        listCart = JSON.parse(cookieValue.split('=')[1]);
    }
}
checkCart();
addCartToHTML();
function addCartToHTML() {
    //clear data from html
    let listCartHTML = document.querySelector('.item');
    listCartHTML.innerHTML = '';
    let totalQuantityHTML = document.querySelector('.totalQuantity');
    let totalPriceHTML = document.querySelector('.totalPrice');

    let totalQuantity = 0;
    let totalPrice = 0;

    //if has product in cart
    if (listCart) {
        listCart.forEach(product => {
            if (product) {
                let newP = document.createElement('div');
                newP.classList.add('item');
                newP.innerHTML =
                    `<input type="hidden" name="product_id[]" value="${product.id}"> <!-- ID sản phẩm -->
                    <img src="${product.image}" alt="">
                    <div class="info">
                        <div class="name">${product.name}</div>
                        <div class="price">${product.price}đ/1 sản phẩm</div>
                    </div>
                    <div class="quantity">
                        <span class="value">
                        ${product.quantity}</span>
                    </div>
                    <div class="returnPrice" name="totalPrice">
                        ${product.price * product.quantity}đ
                    </div>`;
                    listCartHTML.appendChild(newP);
                    totalQuantity = totalQuantity + product.quantity;
                    totalPrice = totalPrice + (product.price * product.quantity);
            }
        })
    }
    totalQuantityHTML.innerText = totalQuantity;
    totalPriceHTML.innerText = totalPrice + 'đ';
}

    // Hàm hiển thị các sản phẩm trong giỏ hàng
    // function displayCartItems() {
    //     const cartItemsContainer = document.getElementById('cart-items');
    //     cartItemsContainer.innerHTML = ''; // Xóa các phần tử hiện tại

    //     let totalPrice = 0;
    //     cart.forEach(item => {
    //         const cartItemDiv = document.createElement('div');
    //         cartItemDiv.classList.add('cart-item');
    //         cartItemDiv.innerHTML = `
    //             <span>${item.name}</span>
    //             <span class="price">$${item.price.toFixed(2)}</span>
    //         `;
    //         cartItemsContainer.appendChild(cartItemDiv);
    //         totalPrice += item.price;
    //     });

    //     // Cập nhật tổng giá trị giỏ hàng
    //     const totalPriceElement = document.getElementById('total-price');
    //     totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
    // }

    // Hiển thị các sản phẩm khi trang tải
    window.onload = displayCartItems;
</script>
    </main>
    <footer>
      <div class="container1">
          <div class="sec aboutus">
              <h2>Về chúng tôi</h2>
              <p>
                  Jellycat là một công ty nổi tiếng toàn cầu, chuyên thiết kế và sản xuất các món đồ chơi nhồi bông cao cấp, đặc biệt là những chú thú nhồi bông dễ thương và độc đáo. Được thành lập vào năm 1999 tại London, Jellycat đã nhanh chóng chiếm được cảm tình của khách hàng trên toàn thế giới nhờ vào chất lượng vượt trội và sự sáng tạo không ngừng. 
                  Với cam kết phát triển bền vững và trách nhiệm đối với cộng đồng, Jellycat tiếp tục khẳng định vị thế vững chắc trong ngành công nghiệp đồ chơi nhồi bông.
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
                  
                  <li>
                      <a href="https://lifestyle.znews.vn/jellycat-la-gi-ma-duoc-lo-lem-chao-yeu-thich-post1500529.html">Hết Labubu đến Jellycat gây sốt</a>
                  </li>

                  <li>
                      <a href="https://vnexpress.net/chu-cho-de-thuong-nhat-the-gioi-bi-nham-la-gau-bong-4013339.html">Mê gấu bông "biết đi" nên mình chọn mua Jellycat: Trải nghiệm siêu chill</a>
                  </li>
                  
                  <li>
                      <a href="https://vietcetera.com/vn/anh-chang-thu-gian-bieu-tuong-moi-cua-loi-song-cu-chill-di">Chill Noel Guy: Hãy mua gấu bông</a>
                  </li>

                  <li>
                      <a href="https://cany.vn/blog/gau-bong-jellycat-co-gi-thu-vi-ma-em-pam-yeu-oi-lai-me-den-vay">Gấu bông Pamyeuoi có gì đặc biệt?</a>
                  </li>
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
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125428.95859731767!2d106.52416244335936!3d10.761053200000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ee4595019ad%3A0xf2a1b15c6af2c1a6!2zxJDhuqFpIGjhu41jIEtpbmggdOG6vyBUUC4gSOG7kyBDaMOtIE1pbmggKFVFSCkgLSBDxqEgc-G7nyBC!5e0!3m2!1svi!2s!4v1733408848189!5m2!1svi!2s" width="350" height="225" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </ul>
          </div>
      </div>
  </footer>
  <div class="copyrightText">
      <p>© Jellycat Limited 2024

          All rights reserved</p>
  </div>

  <script>
    // Hàm JavaScript để hiển thị alert khi nhấn "Tiếp tục thanh toán"
    function showAlert() {
        alert("Đặt hàng thành công!");
        return false;  // Ngừng hành động gửi form để bạn có thể thử nghiệm với alert
    }
</script>
</body>
</body>
</html>