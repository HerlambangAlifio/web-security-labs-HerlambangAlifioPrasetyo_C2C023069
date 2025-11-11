<?php
require_once __DIR__ . '/../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        echo "<p>Login success (safe). User ID: " . htmlspecialchars($user['id']) . "</p>";
    } else {
        echo "<p>Login failed.</p>";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>SQL Safe Login (Prepared Statements)</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="sql_login_safe.css">
</head>
<body>
  <div class="container">
    <h2>SQL Safe Login (Prepared Statements)</h2>

    <div class="form">
      <?php if (!empty($msg)): ?>
        <div class="msg <?= $msg_type ?? 'success' ?>"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <form method="post">
        <label>Username</label>
        <input name="username" type="text" required>

        <label>Password</label>
        <input name="password" type="password" required>

        <button>Login</button>
      </form>

      <p class="note"><a href="../index.php">← Back</a></p>
    </div>
  </div>
</body>
</html>
