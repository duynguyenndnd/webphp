<?php
/**
 * CẤU HÌNH KẾT NỐI CƠ SỞ DỮ LIỆU AIVEN CLOUD
 */
$host = "mysql-2f94d1e6-eaut-57ce.f.aivencloud.com";
$username = "avnadmin";
$password = "AVNS_yM30tKmcVPXAmLuowQm"; 
$dbname = "defaultdb";
$port = "23755";

// Aiven yêu cầu SSL để kết nối an toàn
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL); 

if (!mysqli_real_connect($conn, $host, $username, $password, $dbname, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Kết nối tới Aiven thất bại: " . mysqli_connect_error());
}

$conn->set_charset("utf8");
?>