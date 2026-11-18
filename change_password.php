<?php
require 'config.php';
require_login();
$page_title = 'Change Password'; $active = 'password';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['old_password'] ?? ''; $new = $_POST['new_password'] ?? ''; $conf = $_POST['confirm_password'] ?? '';
    $uid = $_SESSION['user']['id'];
    $stmt = $conn->prepare('SELECT password FROM users WHERE id = ?');
    $stmt->bind_param('i', $uid); $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!csrf_ok()) $errors[] = 'Invalid form session. Please try again.';
    if (!$row || !password_verify($old, $row['password'])) $errors[] = 'Current password is incorrect.';
    if (strlen($new) < 6) $errors[] = 'New password must be at least 6 characters.';
    if ($new !== $conf) $errors[] = 'New password and confirmation do not match.';
    if ($new === $old && $new !== '') $errors[] = 'New password must be different from the current one.';
    if (!$errors) {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->bind_param('si', $hash, $uid); $stmt->execute();
        flash('Password changed successfully.');
        header('Location: change_password.php'); exit;
    }
}
include 'includes/header.php';
?>
<div class="card" style="max-width:520px">
  <h2>🔑 Update your password</h2>
  <?php foreach ($errors as $er): ?><div class="alert alert-error"><?= e($er) ?></div><?php endforeach; ?>
  <form method="post">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div style="margin-bottom:16px"><label>Current Password</label><input type="password" name="old_password" required></div>
    <div style="margin-bottom:16px"><label>New Password</label><input type="password" name="new_password" required minlength="6"></div>
    <div style="margin-bottom:20px"><label>Confirm New Password</label><input type="password" name="confirm_password" required></div>
    <button class="btn btn-green" type="submit">Change Password</button>
  </form>
</div>
<?php include 'includes/footer.php'; ?>
