<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BT1</title>
    <style>
    h1 {font-size: small;text-decoration: underline;}
    section {
        padding: 20px;
        margin: 10px auto;
        max-width: 1100px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        background-color: #f4f4f4;
        color: #333;
    }
</style>
</head>
<header style="font-size: 25px; text-align:center; font-weight:bold">  
    BÀI TẬP PHP CƠ BẢN - MÔN PTUDTMDT 
</header>
<body>
<section id="cau1">
    <h1>Câu 1: Tính tổng của 2 số. Nhập vào hai số nguyên và in ra tổng của chúng.</h1>
    <form method="post">
    <input type="number" name="number1" required placeholder="Nhập vào số thứ nhất:">
    <input type="number" name="number2" required placeholder="Nhập vào số thứ hai:">
    <input type="submit" value="=">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number1 = (int)$_POST['number1'];
    $number2 = (int)$_POST['number2'];
    $sum = $number1 + $number2;
    echo "<h2 > $number1 + $number2 = $sum</h2>";
    echo "<h2> Vậy tổng 2 số nguyên trên = $sum</h2>";
}
?>
</section>

</body>
</html>

