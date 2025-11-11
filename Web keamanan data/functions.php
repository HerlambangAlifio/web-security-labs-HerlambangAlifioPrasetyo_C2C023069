<?php
require_once __DIR__ . '/config.php';

function is_logged_in() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['user_id']);
}

function current_user() {
    global $pdo;
    if (!is_logged_in()) return null;
    static $user = null;
    if ($user === null) {
        $stmt = $pdo->prepare("SELECT id, username, role FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch() ?: null;
    }
    return $user;
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function require_admin() {
    $u = current_user();
    if (!$u || $u['role'] !== 'admin') {
        http_response_code(403);
        echo "Forbidden: Admin only";
        exit;
    }
}

function e($s) {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function policy_check($resourceType, $resourceId, $userId) {
    global $pdo;
    if (!$resourceId) return false;
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id=?");
    $stmt->execute([$userId]);
    $role = $stmt->fetchColumn();
    if ($role === 'admin') return true;

    if ($resourceType === 'invoice') {
        $stmt = $pdo->prepare("SELECT owner_id FROM invoices WHERE id=?");
        $stmt->execute([$resourceId]);
        $owner = $stmt->fetchColumn();
        return ($owner && (int)$owner === (int)$userId);
    }

    return false;
}
