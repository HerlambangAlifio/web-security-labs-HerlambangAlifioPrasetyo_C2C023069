<?php
require_once __DIR__ . '/../functions.php';
require_login();

$OUTSIDE_UPLOAD_DIR = __DIR__ . '/../uploads/';
$allowedExt = ['jpg','jpeg','png','pdf'];
$allowedMimes = ['image/jpeg','image/png','application/pdf'];
$maxSize = 5 * 1024 * 1024;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['file'])) { echo "No file"; exit; }
    $f = $_FILES['file'];
    if ($f['error'] !== UPLOAD_ERR_OK) { echo "Upload error"; exit; }
    if ($f['size'] > $maxSize) { echo "File too large"; exit; }

    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) { echo "Invalid extension"; exit; }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($f['tmp_name']);
    if (!in_array($mime, $allowedMimes)) { echo "Invalid MIME type"; exit; }

    if (strpos($mime, 'image/') === 0) {
        if (!getimagesize($f['tmp_name'])) { echo "Not a valid image"; exit; }
    }

    $safeName = bin2hex(random_bytes(12)) . '.' . $ext;
    $dest = $OUTSIDE_UPLOAD_DIR . $safeName;
    if (!move_uploaded_file($f['tmp_name'], $dest)) { echo "Move failed"; exit; }

    @chmod($dest, 0640);

    $stmt = $pdo->prepare("INSERT INTO uploads (user_id, filename, original_name, mime_type, size) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $safeName, $f['name'], $mime, $f['size']]);
    echo "Upload successful (safe). File id: " . $pdo->lastInsertId();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>File Upload - Safe</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="upload_safe.css">
</head>
<body>
  <div class="container">
    <h2>File Upload - Safe</h2>

    <form method="post" enctype="multipart/form-data">
      <label>Choose file (jpg/png/pdf only, max 5MB):</label>
      <input type="file" name="file" required>
      <button>Upload</button>
    </form>

    <p>Files are stored with randomized names and MIME sniffed.  
    In production, store outside webroot and serve via proxy with proper Content-Type headers.</p>

    <p><a href="../index.php">← Back</a></p>
  </div>
</body>
</html>
