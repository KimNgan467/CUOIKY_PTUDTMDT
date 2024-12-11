<?php
    include "thuvien.php";

    if(isset($_POST['dongydathang'])&&($_POST['dongydathang'])){
        //lấy thông tin KH từ form để tạo đơn hàng
        $customer_name=$_POST['firstname'];
        $email=$_POST['email'];
        $address=$_POST['address'];
        $city=$_POST['city'];
        $phone=$_POST['phone'];
        $note=$_POST['note'];
        
        // Lấy giỏ hàng từ cookie
        $items = loadCartFromCookie(); // Đọc giỏ hàng từ cookie

        // Kiểm tra xem giỏ hàng có sản phẩm không
        if (empty($items)) {
            echo "Giỏ hàng của bạn trống. Vui lòng thêm sản phẩm trước khi đặt hàng.";
            exit; // Dừng thực thi nếu giỏ hàng trống
        }

        // Tính tổng giá trị đơn hàng
        $totalPrice = calculateTotalPrice($items);

        //insert đơn hàng - tạo đơn hàng mới
        $idbill=taodonhang($customer_name, $email, $address, $city, $phone, $note, $totalPrice);


        //insert vào bảng giỏ hàng

        // Kiểm tra xem $items có phải là một mảng không
        if (is_array($items)) {
            foreach ($items as $item) {
                // Kiểm tra xem $item có phải là một mảng và chứa các thuộc tính cần thiết không
                if (is_array($item) && isset($item['name'], $item['price'], $item['quantity'])) {
                    $product_name = $item['name'];               
                    $quantity = $item['quantity'];
                    $price = $item['price'];
                    $order_date = date('Y-m-d H:i:s');
                    $total_amount = $totalPrice; //$totalPrice đã được tính toán trước đó
                    // $customer_id = $pdo->lastInsertId();
                    // $customer_id = taodonhang($customer_name, $email, $address, $city, $phone, $note, $totalPrice);                    // Gọi hàm taogiohang
                    taogiohang($product_name, $quantity, $price, $order_date, $total_amount, $idbill);
                }
            }
        } else {
            echo "Biến items không phải là một mảng hợp lệ.";
        }

        //show confirm đơn hàng
        $ttkh = '
            <!DOCTYPE html>
            <html lang="vi">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Thông tin đặt hàng</title>
                <style>
                    .input-box {
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        padding: 10px;
                        margin-bottom: 15px;
                        background-color: #f9f9f9;
                        min-height: 40px;
                        
                    }
                    .row {
                        display: flex;
                        justify-content: space-between;
                    }
                    .col-50 {
                        flex: 0 0 48%;
                    }
                </style>
            </head>
            <body>
                <h3>Bạn đã đặt hàng thành công <h3> <br>
                <h1>Mã đơn hàng: '.$idbill.'</h1>
                <h2>Thông tin đặt hàng</h2>
                
                <label for="fname"><i class="fa fa-user"></i> Họ và Tên</label>
                <div class="input-box">'.$customer_name.'</div>
                
                <label for="email"><i class="fa fa-envelope"></i> Địa chỉ Email</label>
                <div class="input-box">'.$email.'</div>
                
                <label for="adr"><i class="fa fa-address-card-o"></i> Địa chỉ nhận hàng</label>
                <div class="input-box">'.$address.'</div>            
                
                <label for="city"><i class="fa fa-institution"></i> Thành phố</label>
                <div class="input-box">'.$city.'</div>

                <div class="row">
                    <div class="col-50">
                        <label for="phone">Số điện thoại</label>
                        <div class="input-box">'.$phone.'</div>
                    </div>
                    <div class="col-50">
                        <label for="note">Ghi chú (Nếu có)</label>
                        <div class="input-box">'.$note.'</div>
                    </div>
                </div>
            </body>
            </html>
            ';
            $ttgh = addCartToHTML($items);



        //unset giỏ hàng session
        // unset($items);        

        //unset giỏ hàng
        // echo "Bạn đã tạo thành công. Đơn hàng của bạn là";

    }
    
// $items = loadCartFromCookie(); // Lấy giỏ hàng từ cookie
// Kiểm tra xem $items có phải là mảng không
// if (is_array($items) && sizeof($items) > 0) {
//     // Tiến hành xử lý giỏ hàng
// } else {
//     echo "Giỏ hàng trống hoặc không hợp lệ.";
//     exit; // Dừng thực thi nếu giỏ hàng không hợp lệ
// }

// $items = loadCartFromCookie(); // Giả sử bạn lấy giỏ hàng từ cookie

// if (is_array($items)) {
//     echo "<pre>";
//     print_r($items);
//     echo "</pre>";
// } else {
//     echo "Biến items không phải là mảng.";
// }
?>

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
        <div class="row">
          <div class="col-50">
            <!-- <h3>Thông tin đặt hàng</h3> -->
            <?php echo $ttkh; ?>
          </div>          
        </div>
        
      <!-- </form>
    </div>
  </div> -->
    <div class="col-35">
        <div class="container">
        <!-- <h2>Đơn đặt hàng <span class="totalQuantity" style="color:black"><i class="fa fa-shopping-cart"></i> <b>4</b></span></h2> -->
        <!-- thêm vào -->
        <?php 
            echo $ttgh;

            // <hr>
            // <p>Tổng cộng <span class="totalPrice" style="color:black"><b>$30</b></span></p>
            ?>
        </div>
    </div>

</div>
</div>
</div>
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
</body>
</body>
</html>