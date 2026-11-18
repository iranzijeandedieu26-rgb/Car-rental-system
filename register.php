<?php
require 'config.php';
if (!empty($_SESSION['user'])) { header('Location: dashboard.php'); exit; }
$f = ['full_name' => '', 'username' => '', 'email' => '', 'role' => 'customer'];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($f as $k => $_) $f[$k] = trim($_POST[$k] ?? '');
    $pass = $_POST['password'] ?? ''; $conf = $_POST['confirm_password'] ?? '';
    if (!csrf_ok()) $errors[] = 'Invalid form session. Please try again.';
    if ($f['full_name'] === '') $errors[] = 'Full name is required.';
    if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $f['username'])) $errors[] = 'Username must be 3-30 letters, numbers or underscores.';
    if (!filter_var($f['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (!in_array($f['role'], ['admin', 'customer'])) $errors[] = 'Please choose a valid role.';
    if (strlen($pass) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($pass !== $conf) $errors[] = 'Password and confirmation do not match.';
    if (!$errors) {
        $chk = $conn->prepare('SELECT id FROM users WHERE username = ?');
        $chk->bind_param('s', $f['username']); $chk->execute();
        if ($chk->get_result()->num_rows) $errors[] = 'This username is already taken.';
    }
    if (!$errors) {
        // Saved as "pending": the prefix blocks login until an admin approves the account
        $hash = PENDING_PREFIX . password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (full_name, username, email, password, role) VALUES (?,?,?,?,?)');
        $stmt->bind_param('sssss', $f['full_name'], $f['username'], $f['email'], $hash, $f['role']);
        if ($stmt->execute()) {
            flash('Registration successful! Your account must be approved by an admin before you can log in.');
            header('Location: login.php'); exit;
        }
        $errors[] = 'Could not create the account. Please try again.';
    }
}
$auth_title = 'Create Account'; $auth_sub = 'Register and wait for admin approval';
include 'includes/auth_top.php';
?>
    <?php foreach ($errors as $er): ?><div class="alert alert-error"><?= e($er) ?></div><?php endforeach; ?>
    <form method="post" autocomplete="off">
      <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
      <div class="field"><label>Full Name</label><input name="full_name" required value="<?= e($f['full_name']) ?>"></div>
      <div class="field"><label>Username</label><input name="username" required value="<?= e($f['username']) ?>"></div>
      <div class="field"><label>Email</label><input type="email" name="email" required value="<?= e($f['email']) ?>"></div>
      <div class="field"><label>Password</label><input type="password" name="password" minlength="6" required></div>
      <div class="field"><label>Confirm Password</label><input type="password" name="confirm_password" required></div>
      <div class="field"><label>Role</label><select name="role">
        <option value="customer" <?= $f['role']=='customer'?'selected':'' ?>>Customer</option>
        <option value="admin" <?= $f['role']=='admin'?'selected':'' ?>>Admin</option></select></div>
      <button class="btn" type="submit">Register</button>
    </form>
    <div class="login-links"><a href="login.php">« Back to login</a></div>
<?php include 'includes/auth_bottom.php'; ?>
