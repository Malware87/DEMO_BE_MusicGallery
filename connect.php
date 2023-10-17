<?php
$host = "localhost"; // Địa chỉ máy chủ MySQL
$username = "root"; // Tên đăng nhập MySQL
$password = ""; // Mật khẩu MySQL
$database = "music_db"; // Tên cơ sở dữ liệu

// Tạo kết nối đến MySQL
$mysqli = new mysqli($host, $username, $password, $database);

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Kết nối MySQL thất bại: " . $mysqli->connect_error);
} else {
    echo "Kết nối MySQL thành công!";
}
// Truy vấn dữ liệu từ bảng songs
// $sql = "SELECT * FROM songs";
// $result = $mysqli->query($sql);

// Hiển thị danh sách bài hát
// while ($row = $result->fetch_assoc()) {
//     echo "<p>{$row['title']} - {$row['artist']}</p>";
// }
