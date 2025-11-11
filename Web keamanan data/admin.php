<?php
require_once 'functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $owner = (int)$_POST['owner'];
    $amount = (float)$_POST['amount'];
    $desc = $_POST['description'] ?? '';
    $stmt = $pdo->prepare("INSERT INTO invoices (owner_id, amount, description) VALUES (?, ?, ?)");
    $stmt->execute([$owner, $amount, $desc]);
    $msg = "Invoice created";
}
$users = $pdo->query("SELECT id, username FROM users")->fetchAll();
$invoices = $pdo->query("SELECT i.*, u.username FROM invoices i JOIN users u ON u.id = i.owner_id ORDER BY i.id DESC LIMIT 50")->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Panel - Secure Lab</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="container">
    <h2>Admin Panel</h2>
    <p><a href="dashboard.php">← Back to Dashboard</a></p>

    <?php if(!empty($msg)): ?>
      <div class="msg"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <h3>Create Invoice</h3>
    <form method="post">
      <label>Owner:</label>
      <select name="owner" required>
        <?php foreach($users as $u): ?>
          <option value="<?= (int)$u['id'] ?>"><?= e($u['username']) ?></option>
        <?php endforeach; ?>
      </select>

      <label>Amount:</label>
      <input name="amount" type="number" step="0.01" value="0.00" required>

      <label>Description:</label>
      <input name="description" type="text" placeholder="Invoice description">

      <button>Create Invoice</button>
    </form>

    <h3>Recent Invoices</h3>
    <div class="invoice-list">
      <?php foreach($invoices as $inv): ?>
        <div class="invoice-card">
          <span>#<?= e($inv['id']) ?></span>
          Owner: <?= e($inv['username']) ?><br>
          Amount: <b><?= e($inv['amount']) ?></b>
          <small><?= e($inv['description']) ?></small>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
