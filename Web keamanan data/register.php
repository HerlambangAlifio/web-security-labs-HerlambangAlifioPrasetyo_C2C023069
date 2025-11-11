<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $err = '';

    // Validasi panjang input
    if (strlen($username) < 3 || strlen($password) < 6) {
        $err = "Username minimal 3 karakter dan password minimal 6 karakter.";
    } else {
        // ✅ Tentukan role berdasarkan awalan password
        if (str_starts_with($password, 'ADMIN')) {
            $role = 'admin';
            // Hapus kata ADMIN di awal password
            $password = substr($password, 5);
        } else {
            $role = 'user';
        }

        // Hash password (setelah kata ADMIN dihapus)
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Simpan ke database
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$username, $hash, $role]);

            // ✅ Redirect sesuai role
            if ($role === 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: dashboard.php'); // arahkan ke dashboard user
            }
            exit;
        } catch (Exception $e) {
            $err = "Gagal membuat akun (kemungkinan username sudah digunakan).";
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register</title>
  <link rel="stylesheet" href="register.css">
</head>
<body>
  <form method="post">
    <h2>Register (Lab)</h2>
    <?php if(!empty($err)) echo "<p style='color:red'>".htmlspecialchars($err)."</p>"; ?>
    <input name="username" type="text" placeholder="Username (min 3)" required>
    <input name="password" type="password" placeholder="Password (min 6)" required>
    <button type="submit">Register</button>
    <p><a href="login.php">Login</a></p>
  </form>
</body>
</html>
