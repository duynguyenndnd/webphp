<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM movies WHERE id = $id";
    $result = $conn->query($sql);
    $movie = $result->fetch_assoc();
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $movie['title']; ?> - Xem Phim</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="index.php" class="logo">NETFLICK</a>
        <div class="search-box">
            <form action="index.php" method="GET">
                <input type="text" name="search" placeholder="Tìm kiếm phim...">
            </form>
        </div>
    </header>

    <main class="container">
        <div class="player-container">
            <div class="video-wrapper">
                <video controls autoplay>
                    <source src="<?php echo $movie['video_url']; ?>" type="video/mp4">
                    Trình duyệt của bạn không hỗ trợ video.
                </video>
            </div>
            
            <div class="details-grid">
                <div class="movie-main-info">
                    <h1 style="font-size: 2.5rem; margin: 0;"><?php echo $movie['title']; ?></h1>
                    <div class="movie-meta" style="font-size: 1.1rem; margin: 15px 0;">
                        <span style="border: 1px solid #666; padding: 2px 8px; border-radius: 4px;">16+</span>
                        <span style="margin-left: 15px;"><?php echo $movie['release_year']; ?></span>
                        <span style="margin-left: 15px; color: #46d369; font-weight: bold;">98% Match</span>
                    </div>
                    <div class="movie-desc">
                        <p style="font-size: 1.1rem; line-height: 1.8; color: #ccc;">
                            <?php echo $movie['description']; ?>
                        </p>
                    </div>
                </div>
                
                <div class="movie-specs">
                    <p><span style="color: #777;">Diễn viên:</span> Tên diễn viên, Tên diễn viên...</p>
                    <p><span style="color: #777;">Thể loại:</span> <?php echo $movie['genre']; ?></p>
                    <p><span style="color: #777;">Chương trình này:</span> Hấp dẫn, Kịch tính</p>
                </div>
            </div>
            
            <div style="margin-top: 50px;">
                <h3 class="section-title">Bạn cũng có thể thích</h3>
                <div class="movie-grid">
                    <?php 
                    $other_sql = "SELECT * FROM movies WHERE id != $id LIMIT 4";
                    $other_result = $conn->query($other_sql);
                    while($other_row = $other_result->fetch_assoc()): ?>
                        <div class="movie-card" onclick="location.href='watch.php?id=<?php echo $other_row['id']; ?>'">
                            <img src="<?php echo $other_row['image_url']; ?>" alt="<?php echo $other_row['title']; ?>">
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>