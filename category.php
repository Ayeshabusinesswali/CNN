<?php require 'db.php'; 
$cat = isset($_GET['cat']) ? $_GET['cat'] : 'World';
$stmt = $pdo->prepare("SELECT * FROM articles WHERE category = ? ORDER BY created_at DESC");
$stmt->execute([$cat]);
$articles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($cat) ?> News - Global News</title>
    <style>
        /* Same CSS as index.php - repeated for internal CSS */
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',Arial,sans-serif; }
        body { background:#f4f4f4; color:#333; line-height:1.6; }
        header { background:#c00; color:white; padding:1rem 0; text-align:center; }
        header h1 { font-size:2.5rem; }
        nav { background:#111; padding:1rem 0; }
        nav ul { list-style:none; display:flex; justify-content:center; flex-wrap:wrap; }
        nav ul li { margin:0 1rem; }
        nav ul li a { color:white; text-decoration:none; font-weight:bold; padding:0.5rem 1rem; border-radius:4px; }
        nav ul li a:hover { background:#c00; }
        .container { max-width:1200px; margin:2rem auto; padding:0 1rem; }
        .categories { display:grid; grid-template-columns:repeat(auto-fit, minmax(300px,1fr)); gap:2rem; }
        .category-card { background:white; border-radius:8px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.1); transition:0.3s; }
        .category-card:hover { transform:translateY(-8px); }
        .category-card img { width:100%; height:220px; object-fit:cover; }
        .card-content { padding:1.5rem; }
        .card-content h3 { font-size:1.4rem; margin-bottom:0.8rem; color:#c00; }
        .btn { display:inline-block; background:#c00; color:white; padding:0.7rem 1.2rem; text-decoration:none; border-radius:4px; margin-top:1rem; }
        .btn:hover { background:#a00; }
        footer { background:#111; color:white; text-align:center; padding:2rem 0; margin-top:3rem; }
    </style>
</head>
<body>
    <header>
        <h1>GLOBAL NEWS</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#" onclick="history.back()">Back</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2 style="font-size:2.2rem; color:#c00; margin-bottom:1.5rem; text-align:center;">
            <?= htmlspecialchars($cat) ?> News
        </h2>
        <div class="categories">
            <?php foreach($articles as $article): ?>
            <div class="category-card">
                <?php if($article['image']): ?>
                    <img src="images/<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                <?php endif; ?>
                <div class="card-content">
                    <h3><?= htmlspecialchars($article['title']) ?></h3>
                    <p><small><?= date('M d, Y', strtotime($article['created_at'])) ?></small></p>
                    <p><?= htmlspecialchars($article['short_desc']) ?></p>
                    <a href="article.php?id=<?= $article['id'] ?>" class="btn">Read Full Article</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Global News</p>
    </footer>
</body>
</html>
