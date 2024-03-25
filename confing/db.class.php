<?php

/**
 * Lớp xử lý kết nối và truy vấn cơ sở dữ liệu
 */
class DB
{
    // biến kết nối CSDL
    protected static $connection;

    // hàm khởi tạo kết nối
    public function connect()
    {
        // kết nối tới CSDL trong trường hợp kết nối chưa được khởi tạo
        if (!isset(self::$connection)) {
            // lấy thông tin kết nối từ tập tin config.ini
            $config = parse_ini_file("config.ini");
            self::$connection = new mysqli("localhost", $config["username"], $config["password"], $config["databasename"]);
        }

        // xử lý lỗi nếu không kết nối được tới CSDL
        if (self::$connection == false) {
            // xử lý ghi file tại đây
            return false;
        }
        return self::$connection;
    }

    // hàm thực hiện xử lý câu lệnh truy vấn
    public function query_execute($queryString)
    {
        // khởi tạo kết nối
        $connection = $this->connect();
        // thực hiện execute truy vấn
        $connection->query("SET NAMES utf8");
        $result = $connection->query($queryString);
        $connection->close();
        return $result;
    }

    // hàm thực hiện trả về một mảng danh sách kết quả
    public function select_to_array($queryString)
    {
        $row = array();
        $result = $this->query_execute($queryString);
        if (!$result)
            return false;
        while($item = $result->fetch_assoc()) {
            $row[] = $item;
        }
        return $row;
    }
}
