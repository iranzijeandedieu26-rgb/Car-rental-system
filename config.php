<?php
// ---- Database settings (change these when you deploy on a hosting service) ----
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'car_rental_system');
define('PER_PAGE', 6);   // cars per page (pagination)

session_start();
mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('<h3 style="font-family:Arial;color:#b91c1c">Database connection failed. Please check config.php</h3>');
}
$conn->set_charset('utf8mb4');

function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function require_login($role = null) {
    if (empty($_SESSION['user'])) { header('Location: login.php'); exit; }
    if ($role && $_SESSION['user']['role'] !== $role) { header('Location: dashboard.php'); exit; }
}
function is_admin() { return !empty($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'; }

function csrf_token() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}
function csrf_ok() {
    return isset($_POST['csrf']) && hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf']);
}
function flash($msg = null, $type = 'success') {
    if ($msg !== null) { $_SESSION['flash'] = [$msg, $type]; return; }
    $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f;
}

// ---- Account approval (no database change needed) ----
// A newly registered account stores its password hash with this prefix.
// While the prefix is present the account is "pending" and cannot log in.
// When an admin approves the user, the prefix is removed.
define('PENDING_PREFIX', 'PENDING:');
function is_pending($hash) { return strpos($hash, PENDING_PREFIX) === 0; }
function pending_count() {
    global $conn;
    $r = $conn->query("SELECT COUNT(*) FROM users WHERE password LIKE 'PENDING:%'");
    return $r ? (int)$r->fetch_row()[0] : 0;
}
