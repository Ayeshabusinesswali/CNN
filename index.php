<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global News - Breaking & Latest</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',Arial,sans-serif; }
        body { background:#f4f4f4; color:#333; line-height:1.6; }
        header { background:#c00; color:white; padding:1rem 0; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.2); }
        header h1 { font-size:2.5rem; }
        nav { background:#111; padding:1rem 0; }
        nav ul { list-style:none; display:flex; justify-content:center; flex-wrap:wrap; }
        nav ul li { margin:0 1rem; }
        nav ul li a { color:white; text-decoration:none; font-weight:bold; font-size:1.1rem; padding:0.5rem 1rem; border-radius:4px; transition:0.3s; }
        nav ul li a:hover { background:#c00; }
        .container { max-width:1200px; margin:2rem auto; padding:0 1rem; }
        .featured { background:white; border-radius:8px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.1); margin-bottom:2rem; }
        .featured img { width:100%; height:400px; object-fit:cover; }
        .featured-content { padding:2rem; }
        .featured h2 { font-size:2.2rem; margin-bottom:1rem; color:#c00; }
        .featured p { font-size:1.1rem; margin-bottom:1rem; }
        .btn { display:inline-block; background:#c00; color:white; padding:0.8rem 1.5rem; text-decoration:none; border-radius:4px; font-weight:bold; transition:0.3s; }
        .btn:hover { background:#a00; }
        .categories { display:grid; grid-template-columns:repeat(auto-fit, minmax(280px,1fr)); gap:1.5rem; margin-top:2rem; }
        .category-card { background:white; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1); transition:0.3s; }
        .category-card:hover { transform:translateY(-10px); box-shadow:0 10px 20px rgba(0,0,0,0.15); }
        .category-card img { width:100%; height:200px; object-fit:cover; }
        .card-content { padding:1.5rem; }
        .card-content h3 { font-size:1.4rem; margin-bottom:0.8rem; color:#c00; }
        .card-content p { font-size:0.95rem; color:#555; }
        footer { background:#111; color:white; text-align:center; padding:2rem 0; margin-top:3rem; }
        @media (max-width:768px) {
            header h1 { font-size:2rem; }
            .featured img { height:250px; }
            .featured h2 { font-size:1.8rem; }
        }
    </style>
</head>
<body>
    <header>
        <h1>GLOBAL NEWS</h1>
        <p>Breaking News • World • Politics • Sports • Tech</p>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#" onclick="goToCategory('World')">World</a></li>
            <li><a href="#" onclick="goToCategory('Sports')">Sports</a></li>
            <li><a href="#" onclick="goToCategory('Technology')">Technology</a></li>
            <li><a href="#" onclick="goToCategory('Entertainment')">Entertainment</a></li>
            <li><a href="#" onclick="goToCategory('Politics')">Politics</a></li>
        </ul>
    </nav>

    <div class="container">
        <?php
        $featured = $pdo->query("SELECT * FROM articles WHERE featured = 1 ORDER BY created_at DESC LIMIT 1")->fetch();
        if($featured):
        ?>
        <div class="featured">
            <?php if($featured['image']): ?>
                <img src="images/<?= $featured['image'] ?>" alt="<?= htmlspecialchars($featured['title']) ?>">
            <?php endif; ?>
            <div class="featured-content">
                <h2><?= htmlspecialchars($featured['title']) ?></h2>
                <p><?= htmlspecialchars($featured['short_desc']) ?></p>
                <a href="article.php?id=<?= $featured['id'] ?>" class="btn">Read More</a>
            </div>
        </div>
        <?php endif; ?>

        <h2 style="margin:2rem 0; color:#c00; font-size:2rem;">Latest News</h2>
        <div class="categories">
            <?php
            $stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC LIMIT 6");
            while($row = $stmt->fetch()):
            ?>
            <div class="category-card">
                <?php if($row['image']): ?>
                    <img src="images/<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                <?php endif; ?>
                <div class="card-content">
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p><small><?= ucfirst($row['category']) ?></small></p>
                    <p><?= htmlspecialchars($row['short_desc']) ?></p>
                    <a href="article.php?id=<?= $row['id'] ?>" class="btn" style="font-size:0.9rem; padding:0.6rem 1rem;">Read Article</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Global News. All rights reserved.</p>
    </footer>

    <script>
        function goToCategory(cat) {
            window.location.href = 'category.php?cat=' + cat;
        }
    </script>
</body>
</html>
