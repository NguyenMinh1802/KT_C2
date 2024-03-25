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

// Xử lý phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem có tồn tại giá trị 'id' được gửi từ biểu mẫu không
    if(isset($_POST['id'])) {
        // Lấy giá trị 'id' từ biểu mẫu
        $employee_id = $_POST['id'];

        // Lấy các thông tin được gửi từ biểu mẫu chỉnh sửa
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $place_of_birth = $_POST['place_of_birth'];
        $department = $_POST['department'];
        $salary = $_POST['salary'];

        // Cập nhật thông tin nhân viên trong cơ sở dữ liệu
        $sql = "UPDATE employee SET Ten_NV='$name', Phai='$gender', Noi_Sinh='$place_of_birth', Ma_Phong='$department', Luong='$salary' WHERE Ma_NV='$employee_id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: /KT_C2/entities/index.php");
            // echo "Employee information updated successfully.";
        } else {
            echo "Error updating employee information: " . $conn->error;
        }
    } else {
        echo "Employee ID not provided.";
    }
}

// Xử lý phương thức GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Kiểm tra xem có tồn tại tham số 'id' trong URL không
    if(isset($_GET['id'])) {
        // Lấy giá trị 'id' từ URL
        $employee_id = $_GET['id'];

        // Truy vấn cơ sở dữ liệu để lấy thông tin của nhân viên dựa trên 'id'
        $sql = "SELECT * FROM employee WHERE Ma_NV = '$employee_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Hiển thị thông tin nhân viên trong biểu mẫu chỉnh sửa
            $row = $result->fetch_assoc();
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="/KT_C2/entities/style.css">
                <title>Edit Employee</title>
                <!-- Bổ sung CSS và các tài nguyên khác nếu cần -->
            </head>
            <body>
                <h2>Edit Employee</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['Ma_NV']; ?>">
                    Name: <input type="text" name="name" value="<?php echo $row['Ten_NV']; ?>"><br>
                    Gender: <input type="text" name="gender" value="<?php echo $row['Phai']; ?>"><br>
                    Place of Birth: <input type="text" name="place_of_birth" value="<?php echo $row['Noi_Sinh']; ?>"><br>
                    Department: <input type="text" name="department" value="<?php echo $row['Ma_Phong']; ?>"><br>
                    Salary: <input type="text" name="salary" value="<?php echo $row['Luong']; ?>"><br>
                    <input type="submit" value="Save">
                </form>
            </body>
            </html>
            <?php
        } else {
            echo "Employee not found.";
        }
    } else {
        echo "Employee ID not provided.";
    }
}

$conn->close();
?>
