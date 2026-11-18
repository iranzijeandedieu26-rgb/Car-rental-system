<?php
require 'config.php';
require_login('admin');
$page_title = 'Add New User'; $active = 'users';
$f = ['full_name'=>'','username'=>'','email'=>'','role'=>'customer'];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($f as $k => $_) $f[$k] = trim($_POST[$k] ?? '');
    $pass = $_POST['password'] ?? '';
    if (!csrf_ok()) $errors[] = 'Invalid form session. Please try again.';
    if ($f['full_name'] === '') $errors[] = 'Full name is required.';
    if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $f['username'])) $errors[] = 'Username must be 3-30 letters, numbers or underscores.';
    if (!filter_var($f['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (!in_array($f['role'], ['admin','customer'])) $errors[] = 'Invalid role.';
    if (strlen($pass) < 6) $errors[] = 'Password must be at least 6 characters.';
    if (!$errors) {
        $chk = $conn->prepare('SELECT id FROM users WHERE username = ?');
        $chk->bind_param('s', $f['username']); $chk->execute();
        if ($chk->get_result()->num_rows) $errors[] = 'This username is already taken.';
    }
    if (!$errors) {
        // Users created by an admin are approved immediately
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (full_name, username, email, password, role) VALUES (?,?,?,?,?)');
        $stmt->bind_param('sssss', $f['full_name'], $f['username'], $f['email'], $hash, $f['role']);
        if ($stmt->execute()) { flash('User added and approved.'); header('Location: users.php'); exit; }
        $errors[] = 'Could not save the user. Please try again.';
    }
}
include 'includes/header.php';
?>
<div class="card">
<?php foreach ($errors as $er): ?><div class="alert alert-error"><?= e($er) ?></div><?php endforeach; ?>
<form method="post" autocomplete="off">
  <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
  <div class="form-grid">
    <div><label>Full Name</label><input name="full_name" value="<?= e($f['full_name']) ?>" required></div>
    <div><label>Username</label><input name="username" value="<?= e($f['username']) ?>" required></div>
    <div><label>Email</label><input type="email" name="email" value="<?= e($f['email']) ?>" required></div>
    <div><label>Role</label><select name="role">
      <option value="customer" <?= $f['role']=='customer'?'selected':'' ?>>Customer</option>
      <option value="admin" <?= $f['role']=='admin'?'selected':'' ?>>Admin</option></select></div>
    <div><label>Password</label><input type="password" name="password" minlength="6" required></div>
  </div><br>
  <button class="btn btn-green" type="submit">💾 Save User</button>
  <a href="users.php" class="btn btn-gray">Cancel</a>
</form>
</div>
<?php include 'includes/footer.php'; ?>
