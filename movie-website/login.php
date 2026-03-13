<?php
include 'config.php';
session_start();

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Kiểm tra mật khẩu đã mã hóa
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Sai mật khẩu!";
        }
    } else {
        $error = "Tài khoản không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<!-- Giữ nguyên phần head và giao diện bên dưới -->
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - CineStream</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-card { max-width: 400px; margin: 150px auto; background: #1a1a1a; padding: 40px; border-radius: 12px; border: 1px solid #333; }
        .login-card input { width: 100%; padding: 12px; margin: 15px 0; background: #000; border: 1px solid #444; color: white; border-radius: 4px; box-sizing: border-box; }
        .error { color: #ff4444; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 style="color: #00d1b2; text-align: center;">Đăng nhập</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit" name="login" class="btn-play" style="width: 100%; justify-content: center; border: none; cursor: pointer;">Đăng nhập</button>
        </form>
        <p style="text-align: center; margin-top: 20px; font-size: 0.9rem; color: #777;">
            Chưa có tài khoản? <a href="register.php" style="color: #00d1b2; text-decoration: none;">Đăng ký ngay</a>
        </p>
    </div>
</body>
</html>