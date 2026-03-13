<?php
include 'config.php';

// Xử lý thêm phim
if (isset($_POST['add_movie'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $year = $_POST['release_year'];
    $genre = $_POST['genre'];
    $img = $_POST['image_url'];
    $video = $_POST['video_url'];

    $sql = "INSERT INTO movies (title, description, release_year, genre, image_url, video_url) 
            VALUES ('$title', '$desc', $year, '$genre', '$img', '$video')";
    $conn->query($sql);
}

// Xử lý xóa phim
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM movies WHERE id = $id");
}

$movies = $conn->query("SELECT * FROM movies ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Quản lý phim</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-container { padding: 40px; margin-top: 80px; }
        .form-add { background: #222; padding: 20px; border-radius: 8px; margin-bottom: 40px; }
        .form-add input, .form-add textarea { 
            width: 100%; padding: 10px; margin: 10px 0; background: #333; border: 1px solid #444; color: white; 
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #333; }
        .btn-delete { color: #ff4444; text-decoration: none; }
    </style>
</head>
<body>
    <header>
        <a href="index.php" class="logo">ADMIN PANEL</a>
        <a href="index.php" class="btn">Xem Website</a>
    </header>

    <div class="admin-container">
<?php
include 'config.php';
session_start();

// Kiểm tra quyền Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Xử lý thêm phim với Upload hoặc URL
if (isset($_POST['add_movie'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $year = $_POST['release_year'];
    $genre = $_POST['genre'];
    $img = $_POST['image_url'];
    $rate = $_POST['rating'];
    $dur = $_POST['duration'];
    $is_f = isset($_POST['is_featured']) ? 1 : 0;
    
    $video_type = $_POST['video_type'];
    $video_url = "";

    if ($video_type == 'url') {
        $video_url = $_POST['video_url'];
    } else {
        // Xử lý upload file
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES["video_file"]["name"]);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["video_file"]["tmp_name"], $target_file)) {
            $video_url = $target_file;
        }
    }

    if($is_f) $conn->query("UPDATE movies SET is_featured = 0");
    
    $sql = "INSERT INTO movies (title, description, release_year, genre, image_url, video_url, video_type, rating, duration, is_featured) 
            VALUES ('$title', '$desc', $year, '$genre', '$img', '$video_url', '$video_type', $rate, '$dur', $is_f)";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - CineStream</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-nav { display: flex; justify-content: space-between; align-items: center; padding: 10px 5%; background: #111; position: fixed; width: 90%; top: 0; z-index: 1001; }
        .form-add { background: #1a1a1a; padding: 30px; border-radius: 12px; margin: 100px auto 40px; max-width: 800px; border: 1px solid #333; }
        .form-add input, .form-add textarea, .form-add select { 
            width: 100%; padding: 12px; margin: 10px 0; background: #000; border: 1px solid #444; color: white; border-radius: 4px; box-sizing: border-box;
        }
    </style>
    <script>
        function toggleVideoInput() {
            var type = document.getElementById('video_type').value;
            document.getElementById('url_input').style.display = (type === 'url' ? 'block' : 'none');
            document.getElementById('file_input').style.display = (type === 'file' ? 'block' : 'none');
        }
    </script>
</head>
<body>
    <div class="admin-nav">
        <a href="index.php" class="logo">ADMIN PANEL</a>
        <div style="display: flex; gap: 20px; align-items: center;">
            <span>Xin chào, Admin</span>
            <a href="logout.php" class="btn-info" style="padding: 5px 15px;">Đăng xuất</a>
        </div>
    </div>

    <div class="form-add">
        <h2>Thêm Phim Mới Chuyên Nghiệp</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Tiêu đề phim" required>
            <textarea name="description" placeholder="Mô tả phim"></textarea>
            
            <div style="display: flex; gap: 10px;">
                <input type="number" name="release_year" placeholder="Năm" style="flex: 1;">
                <input type="text" name="genre" placeholder="Thể loại" style="flex: 1;">
            </div>

            <div style="display: flex; gap: 10px;">
                <input type="text" name="duration" placeholder="Thời lượng (vd: 2h 15m)" style="flex: 1;">
                <input type="number" step="0.1" name="rating" placeholder="Rating (vd: 8.5)" style="flex: 1;">
            </div>

            <input type="text" name="image_url" placeholder="Link ảnh Poster">
            
            <label>Nguồn Video:</label>
            <select name="video_type" id="video_type" onchange="toggleVideoInput()">
                <option value="url">Sử dụng URL (Youtube/Direct Link)</option>
                <option value="file">Tải lên tệp MP4 từ máy tính</option>
            </select>

            <div id="url_input">
                <input type="text" name="video_url" placeholder="Nhập URL video (.mp4)">
            </div>
            <div id="file_input" style="display: none;">
                <input type="file" name="video_file" accept=".mp4">
                <p style="color: #777; font-size: 0.8rem;">Lưu ý: Kiểm tra giới hạn upload của XAMPP (php.ini) nếu file lớn.</p>
            </div>

            <label><input type="checkbox" name="is_featured" value="1" style="width: auto;"> Phim Nổi Bật</label>
            
            <button type="submit" name="add_movie" class="btn-play" style="width: 100%; border: none; cursor: pointer; justify-content: center; margin-top: 20px;">XÁC NHẬN THÊM PHIM</button>
        </form>
    </div>
</body>
</html>

        <h2>Danh sách phim hiện tại</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Năm</th>
                    <th>Thể loại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $movies->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['release_year']; ?></td>
                    <td><?php echo $row['genre']; ?></td>
                    <td>
                        <a href="admin.php?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>