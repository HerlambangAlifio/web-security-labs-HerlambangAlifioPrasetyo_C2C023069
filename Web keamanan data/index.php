<?php
require 'functions.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Secure Lab - Web Security Modules</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="title">
        <div class="logo">SL</div>
        <div>
          <h1>Secure Lab</h1>
          <div class="lead">Web Security Modules — learning by example</div>
        </div>
      </div>

      <div class="auth-links">
        <?php if(!is_logged_in()): ?>
          <a href="login.php">Login</a> | <a href="register.php">Register</a>
        <?php else: ?>
          <span class="note">Logged in as <?= e(current_user()['username']) ?></span>
          <a href="dashboard.php">Dashboard</a>
        <?php endif; ?>
      </div>
    </div>

    <hr>

    <div class="section-title">Modules:</div>
    <div class="modules">
      <div class="card">
        <h3>SQL Injection</h3>
        <div class="row">
          <div class="note">Demonstration of SQLi vs safe prepared statements</div>
        </div>
        <div class="links">
          <a class="badge vul" href="vulnerable/sql_login_vul.php">SQLi (vulnerable demo)</a>
          <a class="badge safe" href="safe/sql_login_safe.php">SQLi (safe demo)</a>
        </div>
      </div>

      <div class="card">
        <h3>Cross-Site Scripting (XSS)</h3>
        <div class="note">Stored & reflected XSS examples</div>
        <div class="links">
          <a class="badge vul" href="vulnerable/xss_post_vul.php">XSS (vulnerable demo)</a>
          <a class="badge safe" href="safe/xss_post_safe.php">XSS (safe demo)</a>
        </div>
      </div>

      <div class="card">
        <h3>File Upload</h3>
        <div class="note">Unsafe uploads vs safe validation/whitelist</div>
        <div class="links">
          <a class="badge vul" href="vulnerable/upload_vul.php">File Upload (vuln)</a>
          <a class="badge safe" href="safe/upload_safe.php">File Upload (safe)</a>
        </div>
      </div>

      <div class="card">
        <h3>Broken Access Control</h3>
        <div class="note">Access control mistakes and fixes</div>
        <div class="links">
          <a class="badge vul" href="vulnerable/invoice_view_vul.php">Broken Access Control (vuln)</a>
          <a class="badge safe" href="safe/invoice_view_safe.php">Broken Access Control (safe)</a>
        </div>
      </div>
    </div>

  </div>
</body>
</html>
