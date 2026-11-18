<?php
require 'config.php';
if (!empty($_SESSION['user'])) { header('Location: dashboard.php'); exit; }
$errors = [];
$username = ''; $email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? ''); $email = trim($_POST['email'] ?? '');
    $new = $_POST['new_password'] ?? ''; $conf = $_POST['confirm_password'] ?? '';
    if (!csrf_ok()) $errors[] = 'Invalid form session. Please try again.';
    if (strlen($new) < 6) $errors[] = 'New password must be at least 6 characters.';
    if ($new !== $conf) $errors[] = 'New password and confirmation do not match.';
    if (!$errors) {
        $stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ? AND email = ?');
        $stmt->bind_param('ss', $username, $email); $stmt->execute();
        $u = $stmt->get_result()->fetch_assoc();
        if (!$u) {
            $errors[] = 'No account matches that username and email.';
        } elseif (is_pending($u['password'])) {
            $errors[] = 'This account is still waiting for admin approval.';
        } else {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $up = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
            $up->bind_param('si', $hash, $u['id']); $up->execute();
            flash('Password reset successfully. You can now log in with your new password.');
            header('Location: login.php'); exit;
        }
    }
}
$auth_title = 'Forgot Password'; $auth_sub = 'Confirm your username and email, then choose a new password';
include 'includes/auth_top.php';
?>
    <?php foreach ($errors as $er): ?><div class="alert alert-error"><?= e($er) ?></div><?php endforeach; ?>
    <form method="post" autocomplete="off">
      <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
      <div class="field"><label>Username</label><input name="username" required value="<?= e($username) ?>"></div>
      <div class="field"><label>Email</label><input type="email" name="email" required value="<?= e($email) ?>"></div>
      <div class="field"><label>New Password</label><input type="password" name="new_password" minlength="6" required></div>
      <div class="field"><label>Confirm New Password</label><input type="password" name="confirm_password" required></div>
      <button class="btn" type="submit">Reset Password</button>
    </form>
    <div class="login-links"><a href="login.php">« Back to login</a></div>
<?php include 'includes/auth_bottom.php'; ?>
