<?php
require_once __DIR__ . "/../config/connection.php";

class UserModel
{

    public function getAllUsers($limit, $offset)
{
    $connection = getConnection();

    $sql = "SELECT * FROM khachhang LIMIT ? OFFSET ?";
    $statement = $connection->prepare($sql);
    $statement->bind_param("ii", $limit, $offset); // `ii` là kiểu dữ liệu integer
    $statement->execute();

    $result = $statement->get_result();
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    $statement->close();
    $connection->close();

    return $users; // Trả về danh sách người dùng
}

public function getTotalUsers()
{
    $connection = getConnection();

    $sql = "SELECT COUNT(*) as total FROM khachhang";
    $result = $connection->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total']; // Trả về tổng số người dùng
    }

    $connection->close();
    return 0; // Trả về 0 nếu không có người dùng
}

    public function isExistUsername($username)
    {
        $connection = getConnection();

        $statement = $connection->prepare("SELECT * FROM khachhang WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();

        $queryResult = $statement->get_result();    // Return Query Associative Array 
        $isExist = ($queryResult->fetch_assoc() ? true : false);

        $statement->close();
        $connection->close();
        return $isExist;
    }

    public function isExistEmail($email)
    {
        $connection = getConnection();
        $sql = "SELECT COUNT(*) as count FROM khachhang WHERE email = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $connection->close();

        return $result['count'] > 0; // Trả về true nếu email đã tồn tại
    }

    public function isCurrentPasswordMatched($username, $currentPassword)
    {
        $connection = getConnection();

        $statement = $connection->prepare("SELECT * FROM khachhang WHERE username = ? AND password = ?");
        $statement->bind_param("ss", $username, $currentPassword);
        $statement->execute();

        $queryResult = $statement->get_result();
        $isExist = ($queryResult->fetch_assoc() ? true : false); // return string 

        $statement->close();
        $connection->close();
        return $isExist;
    }

    public function getAccount($username, $password) {
        $connection = getConnection();

        $statement = $connection->prepare("SELECT * FROM khachhang WHERE username = ? AND password = ? AND trang_thai_tai_khoan = 1");
        $statement->bind_param("ss", $username, $password);
        $statement->execute();

        $queryResult = $statement->get_result();
        $account = $queryResult->fetch_assoc(); // return associative array 

        $statement->close();
        $connection->close();
        return $account;
    }

    public function addUser($hoten, $email, $username, $password, $status , $quyenhan)
    {
        $connection = getConnection();

        $sql = "INSERT INTO khachhang (ten_khach_hang, email, username, khachhang.password, trang_thai_tai_khoan, quyen_han)
                VALUES (?,?,?,?,?,?)";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssssis", $hoten, $email, $username, $password, $status , $quyenhan);
        $statement->execute();

        return ($statement->affected_rows > 0 ? true : false);
    }

    public function updateUserInfo($hoten, $email, $username , $quyenhan , $trangthai) {
        $connection = getConnection();

        $sql = "UPDATE khachhang SET ten_khach_hang = ?, email = ? , quyen_han = ? , trang_thai_tai_khoan = ? WHERE username = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssssi", $hoten, $email, $username);
        $statement->execute();

        return ($statement->affected_rows > 0 ? true : false);
    }

    
    public function updateUserInfoAndPassword($hoten, $email, $username, $newPassword) {
        $connection = getConnection();
        
        $sql = "UPDATE khachhang SET ten_khach_hang = ?, email = ?, khachhang.password = ? WHERE username = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssss", $hoten, $email, $newPassword, $username);
        $statement->execute();

        return ($statement->affected_rows > 0 ? true : false);
    }

    public function getUserById($id)
    {
        $connection = getConnection(); // Kết nối cơ sở dữ liệu

        $sql = "SELECT * FROM khachhang WHERE ma_khach_hang = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $id); // `i` là kiểu dữ liệu integer
        $statement->execute();

        $result = $statement->get_result();
        $user = $result->fetch_assoc(); // Lấy bản ghi đầu tiên dưới dạng mảng kết hợp

        $statement->close();
        $connection->close();

        return $user; // Trả về thông tin người dùng
    }
    public function updateUserInfoAndPasswordFromAdmin($hoten, $email, $username, $password, $quyenhan, $trangthai) {
        $connection = getConnection();

        $sql = "UPDATE khachhang 
                SET ten_khach_hang = ?, 
                    email = ?, 
                    password = ?, 
                    quyen_han = ?, 
                    trang_thai_tai_khoan = ? 
                WHERE username = ?";
        
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssssis", $hoten, $email, $password, $quyenhan, $trangthai, $username);
        $statement->execute();

        return ($statement->affected_rows > 0);
    }

    public function countAdmins() {
        $connection = getConnection();
        $stmt = $connection->prepare("SELECT COUNT(*) as admin_count FROM khachhang WHERE quyen_han = 'admin'");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['admin_count'];
    }

    public function getUserRoleByUsername($username) {
        $connection = getConnection();
        $stmt = $connection->prepare("SELECT quyen_han FROM khachhang WHERE username = ?");
        $stmt->bind_param("s", $username);  // 's' là kiểu dữ liệu string
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['quyen_han'] ?? null;  // Trả về quyền hạn hoặc null nếu không tìm thấy
    }

    public function searchUsers($keyword, $limit, $offset) {
        $connection = getConnection();
        $keyword = "%$keyword%";
        $sql = "SELECT * FROM khachhang WHERE username LIKE ? OR ten_khach_hang LIKE ? LIMIT ? OFFSET ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssii", $keyword, $keyword, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $stmt->close();
        $connection->close();
        return $users;
    }

    public function getTotalSearchUsers($keyword) {
        $connection = getConnection();
        $keyword = "%$keyword%";
        $sql = "SELECT COUNT(*) as total FROM khachhang WHERE username LIKE ? OR ten_khach_hang LIKE ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $connection->close();
        return $row['total'];
    }

}
