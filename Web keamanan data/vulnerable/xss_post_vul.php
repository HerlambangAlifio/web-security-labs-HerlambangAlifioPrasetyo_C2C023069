<?php
require_once __DIR__ . '/../functions.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $body = $_POST['body'] ?? '';
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, body) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $title, $body]);
    echo "<p>Post saved (vulnerable)</p>";
}
$posts = $pdo->query("SELECT p.*, u.username FROM posts p JOIN users u ON u.id = p.user_id ORDER BY p.id DESC LIMIT 20")->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>XSS Stored - Vulnerable</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="xss_post_vul.css">
</head>
<body>
  <div class="container">
    <h2>XSS Stored - Vulnerable</h2>
    <div class="vuln-hint">INTENTIONALLY VULNERABLE — this page echoes raw HTML. For lab/demo use only. Do NOT deploy.</div>

    <div class="form">
      <form method="post">
        <label>Title:</label>
        <input name="title" type="text" required>

        <label>Body (HTML allowed):</label>
        <textarea name="body" rows="6" required></textarea>

        <button>Submit</button>
      </form>
    </div>

    <hr>

    <h3>Posts</h3>
    <div class="posts">
      <?php foreach($posts as $p): ?>
        <div class="post">
          <strong><?= htmlspecialchars($p['username']) ?> — <?= htmlspecialchars($p['title']) ?></strong>
          <div class="raw-content">
            <?= $p['body'] /* intentionally raw - vulnerable */ ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <p class="note"><a href="../index.php">← Back</a></p>
  </div>
</body>
</html>
