<!DOCTYPE html>
<html>
<head>
    <title>Employee Information</title>
    <link rel="stylesheet" href="/KT_C2/entities/style.css">
</head>
<body>
    <h1>THÔNG TIN NHÂN VIÊN</h1>
    <a class="add-employee" href="/KT_C2/entities/add.nhanvien.php">Thêm nhân viên</a>
    
    <table>
        <tr>
            <th>Mã Nhân Viên</th>
            <th>Tên Nhân Viên</th>
            <th>Giới tính</th>
            <th>Nơi Sinh</th>
            <th>Tên Phòng</th>
            <th>Lương</th>
            <th>Action</th>
        </tr>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ql_nhansu";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Số lượng bản ghi trên mỗi trang
        $records_per_page = 5;

        // Xác định trang hiện tại
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        // Xác định vị trí bắt đầu của bản ghi cho trang hiện tại
        $start_from = ($page - 1) * $records_per_page;

        // Truy vấn dữ liệu từ bảng employees cho trang hiện tại
        $sql = "SELECT * FROM employee LIMIT $start_from, $records_per_page";
        $result = $conn->query($sql);

        // Hiển thị dữ liệu
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["Ma_NV"]."</td>";
                echo "<td>".$row["Ten_NV"]."</td>";
                // echo "<td>".$row["Phai"]."</td>";
                echo "<td><img class='gender-image' src='/KT_C2/images/" . ($row["Phai"] == "NU" ? "woman.jpg" : "man.jpg") . "' alt='Phai'></td>";
                echo "<td>".$row["Noi_Sinh"]."</td>";
                echo "<td>".$row["Ma_Phong"]."</td>";
                echo "<td>".$row["Luong"]."</td>";
                echo "<td class='action-links'>";
                echo "<a href='/KT_C2/entities/edit.nhanvien.php?id=".$row["Ma_NV"]."'>Edit</a>";
                echo "<a href='/KT_C2/entities/delete.nhanvien.php?id=".$row["Ma_NV"]."' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>0 results</td></tr>";
        }

        $sql_count = "SELECT COUNT(*) AS total FROM employee";
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $total_records = $row_count['total'];

        // Tính tổng số trang
        $total_pages = ceil($total_records / $records_per_page);

        // Hiển thị các liên kết phân trang
        echo "<ul class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li><a href='index.php?page=".$i."'>".$i."</a></li>";
        }
        echo "</ul>";

        
        
        $conn->close();
        ?>
    </table>

    
</body>
</html>
