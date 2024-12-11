<?php
function taogiohang($product_name, $quantity, $price, $order_date, $total_amount, $customer_id){
    $conn=ketnoidb();
    $sql = "INSERT INTO cart (product_name, quantity, price, order_date, total_amount, customer_id)
    VALUES ('$product_name', '$quantity', '$price', '$order_date', '$total_amount', '$customer_id')";
    // use exec() because no results are returned
    $conn->exec($sql);    
    //phải đóng kết nối lại
    $conn = null;
    
}

function taodonhang($customer_name, $email, $address, $city, $phone, $note, $totalPrice){
    $conn=ketnoidb();
    $sql = "INSERT INTO bill (customer_name, email, address, city, phone, note, totalPrice)
    VALUES ('$customer_name', '$email', '$address', '$city', '$phone', '$note', '$totalPrice')";
    // use exec() because no results are returned
    $conn->exec($sql);
    $last_id = $conn->lastInsertId();
    
    //phải đóng kết nối lại
    $conn = null;
    return $last_id;
}

function ketnoidb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "order";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

// Thêm hàm loadCartFromCookie vào thuvien.php
// function loadCartFromCookie() {
//     if (isset($_COOKIE['listCart'])) {
//         return json_decode($_COOKIE['listCart'], true); // Giải mã JSON thành mảng
//     }
//     return []; // Trả về mảng rỗng nếu cookie không tồn tại
// }
function loadCartFromCookie() {
    if (isset($_COOKIE['listCart'])) {
        $items = json_decode($_COOKIE['listCart'], true);
        if (is_array($items)) {
            // Lọc ra các mục không hợp lệ
            $validItems = [];
            foreach ($items as $item) {
                if (is_array($item) && isset($item['name'], $item['price'], $item['quantity'])) {
                    $validItems[] = $item;
                }
            }
            return $validItems; // Trả về mảng hợp lệ
        } else {
            echo "Dữ liệu trong cookie không hợp lệ.";
        }
    }
    return []; // Trả về mảng rỗng nếu cookie không tồn tại
}

function calculateTotalPrice($items) {
    $totalPrice = 0;
    foreach ($items as $item) {
        if (isset($item['price']) && isset($item['quantity'])) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
    }
    return $totalPrice;
}


// Định nghĩa hàm addCartToHTML
// function addCartToHTML($items) {
//     $html = '<h2>Thông tin giỏ hàng:</h2><ul>';
//     foreach ($items as $item) {
//         // Kiểm tra xem $item có phải là một mảng và có các khóa cần thiết không
//         if (is_array($item) && isset($item['name'], $item['quantity'], $item['price'])) {
//             $html .= '<li>' . htmlspecialchars($item['name']) . ' - Số lượng: ' . htmlspecialchars($item['quantity']) . ' - Giá: ' . htmlspecialchars($item['price']) . '</li>';
//         } else {
//             $html .= '<li>Thông tin sản phẩm không hợp lệ: ' . htmlspecialchars(print_r($item, true)) . '</li>';
//         }
//     }
//     $html .= '</ul>';
//     return $html;
// }

function addCartToHTML($items) {
    $html = '<h2>Thông tin giỏ hàng</h2>';
    $html .= '<table style="width: 100%; border-collapse: collapse;">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Sản phẩm</th>';
    $html .= '<th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Tên sản phẩm</th>';
    $html .= '<th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Số lượng</th>';
    $html .= '<th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Thành tiền</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    $totalOrderValue = 0; // Biến để tính tổng giá trị đơn hàng

    foreach ($items as $item) {
        if (is_array($item) && isset($item['name'], $item['quantity'], $item['price'], $item['image'], $item['id'])) {
            $totalPrice = htmlspecialchars($item['price']) * htmlspecialchars($item['quantity']);
            $totalOrderValue += $totalPrice; // Cộng dồn vào tổng giá trị đơn hàng

            $html .= '<tr>';
            $html .= '<td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><img src="' . htmlspecialchars($item['image']) . '" alt="" style="width: 50px;"></td>';
            $html .= '<td style="border: 1px solid #ddd; padding: 8px; text-align: center;">' . htmlspecialchars($item['name']) . '</td>';
            $html .= '<td style="border: 1px solid #ddd; padding: 8px; text-align: center;">';
            $html .= '<div style="display: flex; align-items: center;">';
            $html .= '<span class="value" style="margin: 0 10px; text-align: center;">' . htmlspecialchars($item['quantity']) . '</span>';
            $html .= '</div>';
            $html .= '</td>';
            $html .= '<td style="border: 1px solid #ddd; padding: 8px; text-align: center;">' . $totalPrice . 'đ</td>';
            $html .= '</tr>';
        } else {
            $html .= '<tr><td colspan="4" style="border: 1px solid #ddd; padding: 8px;">Thông tin sản phẩm không hợp lệ.</td></tr>';
        }
    }

    $html .= '</tbody>';
    $html .= '</table>';

    // Thêm phần tổng giá trị đơn hàng
    $html .= '<p>Tổng cộng <span class="totalPrice" style="color:black"><b>' . $totalOrderValue . 'đ</b></span></p>';
    
    return $html;
}




?>