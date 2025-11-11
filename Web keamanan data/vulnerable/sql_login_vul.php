<?php
require_once __DIR__ . '/../config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT id FROM users WHERE username = '$username' AND password_hash = '$password' LIMIT 1";
    try {
        $res = $pdo->query($sql)->fetch();
        if ($res) {
            echo "<p>Login success (vulnerable demo). User ID: " . htmlspecialchars($res['id']) . "</p>";
        } else {
            echo "<p>Login failed.</p>";
        }
    } catch (Exception $e) {
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>SQLi Vulnerable Login (DEMO)</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="sql_login_vul.css">
</head>
<body>
  <div class="container">
    <h2>SQLi Vulnerable Login (DEMO ONLY)</h2>

    <div class="vuln-hint">This page is intentionally vulnerable for learning. Do NOT deploy in production.</div>

    <div class="form">
      <?php if (!empty($msg)): ?>
        <div class="msg <?= $msg_type ?? 'error' ?>"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <form method="post">
        <label>Username</label>
        <input name="username" type="text" required>

        <label>Password</label>
        <input name="password" type="text" required>

        <button>Login (vuln)</button>
      </form>
      <p class="note"><a href="../index.php">← Back</a></p>
    </div>
  </div>
</body>
</html>
