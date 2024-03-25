<?php
// Bắt đầu session
session_start();

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

// Xử lý đăng nhập nếu người dùng đã gửi form
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    // Truy vấn cơ sở dữ liệu để kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Lưu thông tin người dùng vào session
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Chuyển hướng người dùng đến trang chính
        header("Location: index.php");
        exit;
    } else {
        // Sai tên đăng nhập hoặc mật khẩu, hiển thị thông báo lỗi
        $error = "Tên đăng nhập hoặc mật khẩu không chính xác.";
    }
}

// Xử lý đăng xuất
if(isset($_GET['logout'])) {
    // Xóa tất cả các session
    session_unset();
    // Hủy session
    session_destroy();
    // Chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>
<style>
    
    body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0 auto;
    padding: 0;
    max-width: 400px;
    
}

.container {
    width: 300px;
    margin: 100px auto;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

h2 {
    text-align: center;
    color: #333;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
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

.error {
    color: red;
    margin-top: 10px;
}

</style>
<body>
    <h2>Đăng nhập</h2>
    <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="Username">Tên đăng nhập:</label>
            <input type="text" id="Username" name="Username" required>
        </div>
        <div>
            <label for="Password">Mật khẩu:</label>
            <input type="Password" id="Password" name="Password" required>
        </div>
        <div>
            <button type="submit">Đăng nhập</button>
        </div>
    </form>

    <?php if(isset($_SESSION['Username']) && $_SESSION['Role'] === 'admin') { ?>
        <p>Bạn đã đăng nhập với tên đăng nhập: <?php echo $_SESSION['username']; ?></p>
        <p><a href="index.php?logout=true">Đăng xuất</a></p>
        <!-- Hiển thị các chức năng thêm, xoá, sửa nhân viên -->
        <!-- Nơi này bạn có thể đặt các liên kết hoặc nút để điều hướng người dùng đến các chức năng -->
    <?php } ?>  
</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
