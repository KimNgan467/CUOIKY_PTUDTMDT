<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem bảng dữ liệu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #b3e4ea;
            margin: 0;
            padding: 0;
            font-size: 20px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #005f69;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #e96e38;
            cursor: pointer;
        }
        td {
            color: black;
        }
        tr:hover td {
            color: white;
            font-weight: bold;
        }

    </style>
</head>
<body>
<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ptudtmdt";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Hàm hiển thị dữ liệu từ một bảng
function displayTable($conn, $tableName, $columns) {
    // Truy vấn dữ liệu từ bảng
    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<h2>Bảng: $tableName</h2>";
        echo "<table border='1'><tr>";

        // Hiển thị tiêu đề cột
        foreach ($columns as $column) {
            echo "<th>" . $column . "</th>";
        }
        echo "</tr>";

        // Hiển thị dữ liệu của các dòng trong bảng
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table><br>";
    } else {
        echo "Không có dữ liệu trong bảng $tableName!<br><br>";
    }
}

// Hiển thị dữ liệu từ các bảng
displayTable($conn, 'personal_info', ['ID', 'Họ Tên', 'Email', 'Số Điện Thoại', 'Địa Chỉ', 'Mô Tả']);
displayTable($conn, 'education', ['Tên Trường', 'Chuyên Ngành', 'Thời Gian Học']);
displayTable($conn, 'experience', ['Tên Công Ty', 'Vị Trí', 'Thời Gian Làm Việc', 'Mô Tả Công Việc']);
displayTable($conn, 'skills', ['Tên Kỹ Năng', 'Mức Độ Thành Thạo']);
displayTable($conn, 'certificates', ['Tên Chứng Chỉ']);
displayTable($conn, 'activities', ['Tên Tổ Chức', 'Vị Trí Hoạt Động', 'Thời Gian Hoạt Động', 'Mô Tả Hoạt Động']);
// Đóng kết nối
$conn->close();
?>

</body>
</html>
