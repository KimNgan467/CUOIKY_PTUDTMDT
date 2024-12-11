<?php

@include 'config.php';

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header('location:qtsp.php');
};
?>

<!DOCTYPE html>
<html>
    <head>
        <title>QTSP</title>
        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- custom css file link  -->
        <link rel="stylesheet" href="qtsp.css">
    </head>
    <body>  
    <?php
    if(isset($message)){
        foreach($message as $message){
        echo '<span class="message">'.$message.'</span>';
        }
    }
    ?>
    <div class="management">
        <div class="left-menu">
                        <div class="menu-heading"><strong>Trang quản trị</strong></div>
                        <div class="menu-items">
                            <ul>
                                <li><a href="#">Thông tin admin</a></li>
                                <li><a href="#">Tin tức</a></li>
                                <li><a href="qtsp.php">Sản phẩm</a></li>
                                <li><a href="#">Đơn hàng</a></li>
                            </ul>
                        </div>
                        </div>
    <?php
        $select = mysqli_query($conn, "SELECT * FROM products");
    ?>
        <div class="product-display">
            <div class="adding">
        <a href="qtsp_add.php?add=<?php $_SERVER['PHP_SELF'] ?>" class="btn">+ Thêm sản phẩm</a>
        </div>
        <table class="product-display-table">
            <tr>
        <th>Ảnh sản phẩm</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Kích cỡ</th>
        <th>Thao tác</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="Ảnh/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td>$<?php echo $row['price']; ?>/-</td>
            <td><?php echo $row['size']; ?></td>
            <td>
               <a href="qtsp_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> Sửa </a>
               <a href="qtsp.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> Xoá </a>
            </td>
         </tr>
      <?php } ?>
        </table>
        </div>
    </div>
    </div>
</body>
</html>
