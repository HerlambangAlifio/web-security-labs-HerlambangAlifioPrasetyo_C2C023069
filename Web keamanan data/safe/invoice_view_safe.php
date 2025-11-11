<?php
require_once __DIR__ . '/../functions.php';
require_login();

$id = $_GET['id'] ?? '';
if (!$id) {
    echo "Provide ?id=invoice_id";
    exit;
}
$uid = $_SESSION['user_id'];

if (!policy_check('invoice', (int)$id, $uid)) {
    http_response_code(403);
    echo "Forbidden";
    exit;
}

$stmt = $pdo->prepare("SELECT i.*, u.username FROM invoices i JOIN users u ON u.id = i.owner_id WHERE i.id = ?");
$stmt->execute([(int)$id]);
$inv = $stmt->fetch();
if (!$inv) { echo "Not found"; exit; }
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Invoice View (SAFE)</title>
  <link rel="stylesheet" href="invoice_view_safe.css">
</head>
<body>
  <div class="container">
    <h2>Invoice View (SAFE)</h2>
    <div class="invoice-detail">
      <p><span>Invoice ID:</span> <?= e($inv['id']) ?></p>
      <p><span>Owner:</span> <?= e($inv['username']) ?></p>
      <p><span>Amount:</span> <?= e($inv['amount']) ?></p>
      <p><span>Description:</span> <?= e($inv['description']) ?></p>
    </div>
    <a href="../dashboard.php">← Back</a>
  </div>
</body>
</html>
