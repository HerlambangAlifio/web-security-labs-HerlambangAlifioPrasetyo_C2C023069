<?php
require 'functions.php';
require_login();
$u = current_user();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dashboard - Secure Lab</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="title">
        <div class="logo">SL</div>
        <div>
          <h1>Dashboard</h1>
          <div class="lead">Welcome to Secure Lab — your learning workspace</div>
        </div>
      </div>

      <div class="auth-links">
        <span class="note">Hello, <?= e($u['username']) ?></span>
        <span style="margin-left:10px;" class="badge <?= $u['role'] === 'admin' ? 'safe' : '' ?>">
          <?= e($u['role']) ?>
        </span>
        <a style="margin-left:14px;" href="logout.php">Logout</a>
      </div>
    </div>

    <hr>

    <div class="section-title">Available Modules</div>

    <div class="modules">
      <div class="card">
        <h3>SQL Injection</h3>
        <div class="note">Try both vulnerable and fixed login demos</div>
        <div class="links">
          <a class="badge vul" href="vulnerable/sql_login_vul.php">SQLi (vulnerable)</a>
          <a class="badge safe" href="safe/sql_login_safe.php">SQLi (safe)</a>
        </div>
      </div>

      <div class="card">
        <h3>Cross-Site Scripting</h3>
        <div class="note">Stored & reflected XSS examples</div>
        <div class="links">
          <a class="badge vul" href="vulnerable/xss_post_vul.php">XSS (vulnerable)</a>
          <a class="badge safe" href="safe/xss_post_safe.php">XSS (safe)</a>
        </div>
      </div>

      <div class="card">
        <h3>File Upload</h3>
        <div class="note">Unsafe uploads vs whitelist validation</div>
        <div class="links">
          <a class="badge vul" href="vulnerable/upload_vul.php">Upload (vuln)</a>
          <a class="badge safe" href="safe/upload_safe.php">Upload (safe)</a>
        </div>
      </div>

      <div class="card">
        <h3>Broken Access Control</h3>
        <div class="note">IDOR and access control demonstration</div>
        <div class="links">
          <a class="badge vul" href="vulnerable/invoice_view_vul.php">IDOR (vuln)</a>
          <a class="badge safe" href="safe/invoice_view_safe.php">IDOR (safe)</a>
        </div>
      </div>
    </div>

    <hr>

    <div style="display:flex;gap:18px;align-items:flex-start;flex-wrap:wrap;margin-top:8px;">
      <div style="flex:1;min-width:260px;">
        <div class="card">
          <h3>Your Quick Links</h3>
          <ul style="margin:8px 0 0 18px;padding:0;color:var(--muted);">
            <li><a href="vulnerable/sql_login_vul.php">SQLi vulnerable</a></li>
            <li><a href="safe/sql_login_safe.php">SQLi safe</a></li>
            <li><a href="vulnerable/xss_post_vul.php">XSS vulnerable</a></li>
            <li><a href="safe/xss_post_safe.php">XSS safe</a></li>
            <li><a href="vulnerable/upload_vul.php">Upload vulnerable</a></li>
            <li><a href="safe/upload_safe.php">Upload safe</a></li>
            <li><a href="vulnerable/invoice_view_vul.php">IDOR vulnerable</a></li>
            <li><a href="safe/invoice_view_safe.php">IDOR safe</a></li>
          </ul>
        </div>
      </div>

      <?php if ($u['role'] === 'admin'): ?>
        <div style="min-width:260px;">
          <div class="card">
            <h3>Admin Panel</h3>
            <div class="note">Administrative functions</div>
            <div style="margin-top:10px;">
              <a class="badge safe" href="admin.php">Open Admin Panel</a>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>

  </div>
</body>
</html>
