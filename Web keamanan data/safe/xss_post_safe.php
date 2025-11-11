<?php
require_once __DIR__ . '/../functions.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $body = $_POST['body'] ?? '';
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, body) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $title, $body]);
    echo "<p>Post saved (safe)</p>";
}
$posts = $pdo->query("SELECT p.*, u.username FROM posts p JOIN users u ON u.id = p.user_id ORDER BY p.id DESC LIMIT 20")->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>XSS Stored - Safe</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="xss_post_safe.css">
</head>
<body>
  <div class="container">
    <h2>XSS Stored - Safe (Escape on Output)</h2>

    <form method="post">
      <label>Title:</label>
      <input name="title" type="text" required>

      <label>Body (text only):</label>
      <textarea name="body" rows="6" required></textarea>

      <button>Submit</button>
    </form>

    <div class="posts">
      <h3>Recent Posts</h3>
      <?php foreach($posts as $p): ?>
        <div class="post">
          <strong><?= e($p['username']) ?> — <?= e($p['title']) ?></strong>
          <div><?= nl2br(e($p['body'])) ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <p><a href="../index.php">← Back</a></p>
  </div>
</body>
</html>
