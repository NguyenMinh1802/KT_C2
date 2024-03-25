<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql_nhansu";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý dữ liệu từ biểu mẫu thêm nhân viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Ma_NV = $_POST['Ma_NV'];
    $Ten_NV = $_POST['Ten_NV'];
    $Phai = $_POST['Phai'];
    $Noi_Sinh = $_POST['Noi_Sinh'];
    $Ma_Phong = $_POST['Ma_Phong'];
    $Luong = $_POST['Luong'];

    // Thực hiện truy vấn để thêm nhân viên vào cơ sở dữ liệu
    $sql = "INSERT INTO employee (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES ('$Ma_NV', '$Ten_NV', '$Phai', '$Noi_Sinh', '$Ma_Phong', '$Luong')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm nhân viên thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân Viên</title>
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

form {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    margin: 0 auto;
}

h2 {
    text-align: center;
    color: #333;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
}

button[type="submit"]:hover {
    background-color: #45a049;
}
</style>
<body>
    <h2>Thêm Nhân Viên Mới</h2>
    <form method="post" action="/KT_C2/entities/add.nhanvien.php">
        <div>
            <label for="Ma_NV">Mã Nhân Viên:</label>
            <input type="text" id="Ma_NV" name="Ma_NV" required>
        </div>
        <div>
            <label for="Ten_NV">Tên Nhân Viên:</label>
            <input type="text" id="Ten_NV" name="Ten_NV" required>
        </div>
        <div>
            <label for="Phai">Giới Tính:</label>
            <select id="Phai" name="Phai" required>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>
        </div>
        <div>
            <label for="Noi_Sinh">Nơi Sinh:</label>
            <input type="text" id="Noi_Sinh" name="Noi_Sinh" required>
        </div>
        <div>
            <label for="Ma_Phong">Mã Phòng:</label>
            <input type="text" id="Ma_Phong" name="Ma_Phong" required>
        </div>
        <div>
            <label for="Luong">Lương:</label>
            <input type="text" id="Luong" name="Luong" required>
        </div>
        <div>
            <button type="submit">Thêm Nhân Viên</button>
        </div>
    </form>
</body>
</html>
