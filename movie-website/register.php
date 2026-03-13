<?php
include 'config.php';
session_start();

if (isset($_POST['register'])) {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // Mặc định là user

    // Kiểm tra username tồn tại
    $check = $conn->query("SELECT * FROM users WHERE username = '$user'");
    if ($check->num_rows > 0) {
        $error = "Tên đăng nhập đã tồn tại!";
    } else {
        $sql = "INSERT INTO users (username, password, role) VALUES ('$user', '$pass', '$role')";
        if ($conn->query($sql)) {
            $success = "Đăng ký thành công! <a href='login.php' style='color:#00d1b2'>Đăng nhập ngay</a>";
        } else {
            $error = "Lỗi đăng ký!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - CineStream</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-card { max-width: 400px; margin: 100px auto; background: #1a1a1a; padding: 40px; border-radius: 12px; border: 1px solid #333; }
        .login-card input { width: 100%; padding: 12px; margin: 15px 0; background: #000; border: 1px solid #444; color: white; border-radius: 4px; box-sizing: border-box; }
        .error { color: #ff4444; font-size: 0.9rem; margin-bottom: 10px; }
        .success { color: #00d1b2; font-size: 0.9rem; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 style="color: #00d1b2; text-align: center;">Tạo tài khoản</h2>
        <?php 
            if(isset($error)) echo "<p class='error'>$error</p>"; 
            if(isset($success)) echo "<p class='success'>$success</p>";
        ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required minlength="6">
            <button type="submit" name="register" class="btn-play" style="width: 100%; border: none; cursor: pointer; justify-content: center;">Đăng ký</button>
        </form>
        <p style="text-align: center; margin-top: 20px; font-size: 0.9rem; color: #777;">
            Đã có tài khoản? <a href="login.php" style="color: #00d1b2; text-decoration: none;">Đăng nhập</a>
        </p>
    </div>
</body>
</html>