<?php
require 'config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $err = "Harap isi username dan password.";
    } else {
        // ambil juga kolom role
        $stmt = $pdo->prepare("SELECT id, password_hash, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            // login sukses — simpan session
            $_SESSION['user_id'] = $user['id'];
            // opsional: simpan role di session untuk akses cepat
            $_SESSION['role'] = $user['role'];

            // redirect sesuai role
            if ($user['role'] === 'admin') {
                header('Location: admin.php');
                exit;
            } else {
                header('Location: dashboard.php');
                exit;
            }
        } else {
            $err = "Username atau password salah.";
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <form method="post">
    <h2>Login</h2>
    <?php if(!empty($err)) echo "<p style='color:red'>".htmlspecialchars($err)."</p>"; ?>
    <input name="username" type="text" placeholder="Username">
    <input name="password" type="password" placeholder="Password">
    <button>Login</button>
    <p><a href="register.php">Register</a></p>
  </form>
</body>
</html>
