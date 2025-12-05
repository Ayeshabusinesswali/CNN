<?php 
require 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if(!$article) {
    die("Article not found");
}

// Related articles
$related = $pdo->prepare("SELECT * FROM articles WHERE category = ? AND id != ? ORDER BY created_at DESC LIMIT 3");
$related->execute([$article['category'], $id]);
$related_articles = $related->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?> - Global News</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',Arial,sans-serif; }
        body { background:#f4f4f4; color:#333; line-height:1.8; }
        header { background:#c00; color:white; padding:1.5rem 0; text-align:center; }
        header h1 { font-size:2rem; }
        nav { background:#111; padding:1rem 0; }
        nav ul { list-style:none; display:flex; justify-content:center; }
        nav ul li a { color:white; text-decoration:none; font-weight:bold; padding:0.8rem 1.5rem; }
        nav ul li a:hover { background:#c00; }
        .container { max-width:900px; margin:2rem auto; padding:0 1rem; }
        .article { background:white; padding:2.5rem; border-radius:8px; box-shadow:0 4px 20px rgba(0,0,0,0.1); }
        .article img { width:100%; border-radius:8px; margin:1.5rem 0; }
        .article h1 { font-size:2.5rem; color:#c00; margin-bottom:1rem; }
        .article .meta { color:#777; font-size:0.95rem; margin-bottom:2rem; }
        .article p { margin-bottom:1.5rem; font-size:1.1rem; }
        .related { margin-top:3rem; }
        .related h3 { color:#c00; margin-bottom:1.5rem; font-size:1.8rem; }
        .related-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(280px,1fr)); gap:1.5rem; }
        .related-card { background:white; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
        .related-card img { width:100%; height:160px; object-fit:cover; }
        .related-card .content { padding:1rem; }
        .related-card h4 { font-size:1.1rem; margin-bottom:0.5rem; }
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
        <div class="article">
            <h1><?= htmlspecialchars($article['title']) ?></h1>
            <div class="meta">
                Category: <?= ucfirst($article['category']) ?> • 
                <?= date('F d, Y', strtotime($article['created_at'])) ?>
            </div>
            <?php if($article['image']): ?>
                <img src="images/<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
            <?php endif; ?>
            <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
        </div>

        <?php if(count($related_articles) > 0): ?>
        <div class="related">
            <h3>Related Articles</h3>
            <div class="related-grid">
                <?php foreach($related_articles as $rel): ?>
                <div class="related-card">
                    <?php if($rel['image']): ?>
                        <img src="images/<?= $rel['image'] ?>" alt="">
                    <?php endif; ?>
                    <div class="content">
                        <h4><?= htmlspecialchars($rel['title']) ?></h4>
                        <a href="article.php?id=<?= $rel['id'] ?>" style="color:#c00; font-size:0.9rem;">Read →</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 Global News. All rights reserved.</p>
    </footer>
</body>
</html>
