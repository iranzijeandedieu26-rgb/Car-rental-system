<?php
require 'config.php';
if (!empty($_SESSION['user'])) { header('Location: dashboard.php'); exit; }
$error = '';
$warning = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $conn->prepare('SELECT id, full_name, username, password, role FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && is_pending($user['password'])) {
        // Only tell the person their account is pending if the password is correct
        if (password_verify($password, substr($user['password'], strlen(PENDING_PREFIX)))) {
            $warning = 'Your account is still waiting for admin approval. Please try again later.';
        } else {
            $error = 'Invalid username or password.';
        }
    } elseif ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        unset($user['password']);
        $_SESSION['user'] = $user;
        header('Location: dashboard.php'); exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
$flash = flash();
$auth_title = 'Welcome Back 👋'; $auth_sub = 'Please login to your account';
include 'includes/auth_top.php';
?>
    <?php if ($flash): ?><div class="alert alert-<?= e($flash[1]) ?>"><?= e($flash[0]) ?></div><?php endif; ?>
    <?php if ($warning): ?><div class="alert alert-warning"><?= e($warning) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
      <div class="field"><label>Username</label><input name="username" required autofocus value="<?= e($_POST['username'] ?? '') ?>"></div>
      <div class="field"><label>Password</label><input type="password" name="password" required></div>
      <button class="btn" type="submit">Login</button>
    </form>
    <div class="login-links">
      <a href="forgot_password.php">Forgot password?</a>
      <a href="register.php" class="create">Create new account</a>
    </div>
<?php include 'includes/auth_bottom.php'; ?>
