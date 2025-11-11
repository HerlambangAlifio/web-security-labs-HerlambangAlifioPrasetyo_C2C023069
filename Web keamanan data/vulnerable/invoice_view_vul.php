<?php
require_once __DIR__ . '/../functions.php';
require_login();

$id = $_GET['id'] ?? '';
if (!$id) {
    echo "Provide ?id=invoice_id";
    exit;
}
$stmt = $pdo->query("SELECT i.*, u.username FROM invoices i JOIN users u ON u.id = i.owner_id WHERE i.id = " . (int)$id);
$inv = $stmt->fetch();
if (!$inv) { echo "Not found"; exit; }
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Invoice View (VULNERABLE)</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="invoice_view_vul.css">
</head>
<body>
  <div class="container">
    <h2>Invoice View (VULNERABLE)</h2>
    <div class="vuln-hint">INTENTIONALLY VULNERABLE: this endpoint uses a direct SQL query without access policy. For lab/demo only.</div>

    <div class="invoice">
      <div class="row">
        <div class="label">Invoice #</div>
        <div class="value"><?= htmlspecialchars($inv['id']) ?></div>
      </div>

      <div class="row">
        <div class="label">Owner</div>
        <div class="value"><?= htmlspecialchars($inv['username']) ?></div>
      </div>

      <div class="row">
        <div class="label">Amount</div>
        <div class="value"><?= htmlspecialchars($inv['amount']) ?></div>
      </div>

      <div class="row">
        <div class="label">Description</div>
        <div class="value"><?= nl2br(htmlspecialchars($inv['description'])) ?></div>
      </div>
    </div>

    <p class="note"><a href="../dashboard.php">← Back</a></p>
  </div>
</body>
</html>
