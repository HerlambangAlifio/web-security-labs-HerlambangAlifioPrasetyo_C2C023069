<?php
require_once __DIR__ . '/../functions.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['file'])) { echo "No file"; exit; }
    $f = $_FILES['file'];
    $dest = __DIR__ . '/../uploads/' . basename($f['name']);
    if (move_uploaded_file($f['tmp_name'], $dest)) {
        $stmt = $pdo->prepare("INSERT INTO uploads (user_id, filename, original_name, mime_type, size) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], basename($f['name']), $f['name'], $f['type'], $f['size']]);
        echo "Uploaded (vulnerable) as " . htmlspecialchars($f['name']);
    } else {
        echo "Upload failed";
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>File Upload - Vulnerable</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="upload_vul.css">
</head>
<body>
  <div class="container">
    <h2>File Upload - Vulnerable</h2>

    <div class="vuln-hint">INTENTIONALLY VULNERABLE — no validation, stores files directly to uploads/. For lab use only.</div>

    <div class="form">
      <form method="post" enctype="multipart/form-data">
        <label>Choose file:</label>
        <input type="file" name="file" required>
        <button>Upload</button>
      </form>
    </div>

    <p class="note">Note: this endpoint does NOT validate MIME/extension and stores files directly into uploads/</p>
    <p><a href="../index.php">← Back</a></p>
  </div>
</body>
</html>
