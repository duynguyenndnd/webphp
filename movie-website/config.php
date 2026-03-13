<?php
/**
 * CẤU HÌNH KẾT NỐI CƠ SỞ DỮ LIỆU AIVEN CLOUD MỚI
 */
$host = "mysql-37d294a6-duydnguyennd-2be4.f.aivencloud.com";
$username = "avnadmin";
$password = "AVNS_7y8MvenRD9fqWkGb4Xb"; 
$dbname = "defaultdb";
$port = "22099";

// Aiven yêu cầu SSL để kết nối an toàn
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL); 

if (!mysqli_real_connect($conn, $host, $username, $password, $dbname, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Kết nối tới Aiven thất bại: " . mysqli_connect_error());
}

$conn->set_charset("utf8");
?>