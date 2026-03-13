<?php
include 'config.php';
session_start();

// Bắt buộc đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineStream - Xem Phim Online</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="index.php" class="logo">CINESTREAM</a>
        <nav>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="?genre=Action">Action</a></li>
                <li><a href="?genre=Sci-Fi">Sci-Fi</a></li>
                <li><a href="?genre=Thriller">Thriller</a></li>
                <li><a href="?genre=Animation">Animation</a></li>
                <li><a href="?genre=Drama">Drama</a></li>
                <li><a href="?genre=Comedy">Comedy</a></li>
            </ul>
        </nav>
        <div style="display: flex; gap: 15px; align-items: center;">
            <div class="search-container">
                <form action="index.php" method="GET">
                    <input type="text" name="search" placeholder="Tìm kiếm phim...">
                </form>
            </div>
            <span style="font-size: 0.8rem; color: #00d1b2;">Chào, <?php echo $_SESSION['username']; ?></span>
            <?php if($_SESSION['role'] == 'admin'): ?>
                <a href="admin.php" style="color: #fff; font-size: 0.8rem; text-decoration: none; border: 1px solid #444; padding: 2px 8px; border-radius: 4px;">Admin</a>
            <?php endif; ?>
            <a href="logout.php" style="color: #ff4444; font-size: 0.8rem; text-decoration: none;">Thoát</a>
        </div>
    </header>
            <form action="index.php" method="GET">
                <input type="text" name="search" placeholder="Tìm kiếm phim...">
            </form>
        </div>
    </header>

    <section class="hero">
        <?php 
        $hero_sql = "SELECT * FROM movies WHERE is_featured = 1 LIMIT 1";
        $hero_result = $conn->query($hero_sql);
        $hero = $hero_result->fetch_assoc();
        
        if($hero):
        ?>
        <div class="hero-tag">PHIM NỔI BẬT</div>
        <h1><?php echo $hero['title']; ?></h1>
        <div class="hero-meta">
            <span class="rating-star">★ <?php echo $hero['rating']; ?></span>
            <span><?php echo $hero['release_year']; ?></span>
            <span><?php echo $hero['duration']; ?></span>
            <span style="border: 1px solid #444; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;"><?php echo strtoupper($hero['genre']); ?></span>
        </div>
        <p class="hero-desc"><?php echo $hero['description']; ?></p>
        <div class="hero-btns">
            <a href="watch.php?id=<?php echo $hero['id']; ?>" class="btn-play">▶ Xem Ngay</a>
            <a href="#" class="btn-info">ⓘ Chi Tiết</a>
        </div>
        <style>
            .hero { background: linear-gradient(rgba(0,0,0,0.3), var(--bg-dark)), url('<?php echo $hero['image_url']; ?>'); background-size: cover; background-position: center; }
        </style>
        <?php endif; ?>
    </section>

    <main class="container">
        <div class="section-header">
            <h2>Tất cả phim</h2>
            <div class="line"></div>
        </div>
        
        <div class="movie-grid">
            <?php 
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $genre = isset($_GET['genre']) ? $_GET['genre'] : '';
            
            $sql = "SELECT * FROM movies WHERE title LIKE '%$search%'";
            if($genre) $sql .= " AND genre = '$genre'";
            $sql .= " ORDER BY created_at DESC";
            
            $result = $conn->query($sql);

            if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="movie-card" onclick="location.href='watch.php?id=<?php echo $row['id']; ?>'">
                        <div class="rating-badge">★ <?php echo $row['rating']; ?></div>
                        <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['title']; ?>">
                        <div class="movie-card-info">
                            <h3><?php echo $row['title']; ?></h3>
                            <div class="movie-card-meta">
                                <?php echo $row['release_year']; ?> • <?php echo $row['duration']; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Không tìm thấy phim yêu cầu.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="footer-logo">CINESTREAM</div>
        <p>Trải nghiệm điện ảnh đỉnh cao ngay tại nhà. Hàng ngàn bộ phim hấp dẫn đang chờ đón bạn.</p>
    </footer>
</body>

    <footer>
        <p>&copy; 2026 Movie Website - Coding with AI</p>
    </footer>
</body>
</html>