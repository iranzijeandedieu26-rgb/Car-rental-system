<?php
// Usage: set $page_title and $active before including this file
$u = $_SESSION['user'];
$initial = strtoupper(substr($u['full_name'], 0, 1));
$flash = flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page_title) ?> | Car Rental System</title>
<?php include __DIR__ . '/style.php'; ?>
</head>
<body>
<aside class="sidebar">
  <div class="brand">🚘 Car<span>Rental</span></div>
  <nav class="nav">
    <a href="dashboard.php" class="<?= $active=='dashboard'?'active':'' ?>">📊 Dashboard</a>
    <a href="cars.php" class="<?= $active=='cars'?'active':'' ?>">🚗 <?= is_admin() ? 'Manage Cars' : 'View Cars' ?></a>
    <?php if (is_admin()): ?>
    <a href="add_car.php" class="<?= $active=='add'?'active':'' ?>">➕ Add New Car</a>
    <?php $pc = pending_count(); ?>
    <a href="users.php" class="<?= $active=='users'?'active':'' ?>">👥 Manage Users<?= $pc ? ' <span class="nav-badge">'.$pc.'</span>' : '' ?></a>
    <?php endif; ?>
    <a href="change_password.php" class="<?= $active=='password'?'active':'' ?>">🔑 Change Password</a>
    <a href="logout.php" class="logout">🚪 Logout</a>
  </nav>
</aside>
<main class="main">
  <div class="topbar">
    <div><h1><?= e($page_title) ?></h1><small><?= date('l, d F Y') ?></small></div>
    <div class="user-chip">
      <div class="avatar"><?= e($initial) ?></div>
      <div><strong><?= e($u['full_name']) ?></strong><br><span class="role"><?= e($u['role']) ?></span></div>
    </div>
  </div>
  <?php if ($flash): ?><div class="alert alert-<?= e($flash[1]) ?>"><?= e($flash[0]) ?></div><?php endif; ?>
