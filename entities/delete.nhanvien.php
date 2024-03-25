<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql_nhansu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra xem có tồn tại tham số 'id' trong URL không
if(isset($_GET['id'])) {
    // Lấy giá trị 'id' từ URL
    $employee_id = $_GET['id'];

    // Xóa nhân viên khỏi cơ sở dữ liệu
    $sql = "DELETE FROM employee WHERE Ma_NV='$employee_id'";
    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng về trang index.php sau khi xóa thành công
        header("Location: index.php");
        exit(); // Dừng script sau khi chuyển hướng
    } else {
        echo "Error deleting employee: " . $conn->error;
    }
} else {
    echo "Employee ID not provided.";
}

$conn->close();
?>
