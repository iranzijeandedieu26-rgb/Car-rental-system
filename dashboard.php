<?php
require 'config.php';
require_login();
$page_title = 'Dashboard'; $active = 'dashboard';

$cnt = fn($sql) => (int)$conn->query($sql)->fetch_row()[0];
$total = $cnt('SELECT COUNT(*) FROM cars');
$avail = $cnt("SELECT COUNT(*) FROM cars WHERE status='available'");
$rented = $cnt("SELECT COUNT(*) FROM cars WHERE status='rented'");
$maint = $cnt("SELECT COUNT(*) FROM cars WHERE status='maintenance'");
$custs = $cnt("SELECT COUNT(*) FROM users WHERE role='customer'");
$cats = $conn->query('SELECT category, COUNT(*) c FROM cars GROUP BY category ORDER BY c DESC')->fetch_all(MYSQLI_ASSOC);
include 'includes/header.php';
?>
<?php if (is_admin()): $pending = pending_count(); ?>
<div class="grid stats">
  <div class="stat s1"><span class="icon">🚗</span><h3><?= $total ?></h3><p>Total Cars</p></div>
  <div class="stat s2"><span class="icon">✅</span><h3><?= $avail ?></h3><p>Available</p></div>
  <div class="stat s4"><span class="icon">🔑</span><h3><?= $rented ?></h3><p>Rented</p></div>
  <div class="stat s3"><span class="icon">🛠️</span><h3><?= $maint ?></h3><p>In Maintenance</p></div>
  <div class="stat s5"><span class="icon">👥</span><h3><?= $custs ?></h3><p>Customers</p></div>
  <a href="users.php?status=pending" class="stat s3"><span class="icon">⏳</span><h3><?= $pending ?></h3><p>Pending Approvals</p></a>
</div>
<div class="grid two">
  <div class="card">
    <h2>Recently Added Cars</h2>
    <div class="table-wrap"><table>
      <thead><tr><th>Car</th><th>Plate</th><th>Category</th><th>Price/Day</th><th>Status</th></tr></thead><tbody>
      <?php $r = $conn->query('SELECT * FROM cars ORDER BY id DESC LIMIT 5'); while ($c = $r->fetch_assoc()): ?>
        <tr><td><strong><?= e($c['brand'].' '.$c['model']) ?></strong></td><td><?= e($c['plate_number']) ?></td><td><?= e($c['category']) ?></td>
        <td>$<?= number_format($c['price_per_day'],2) ?></td><td><span class="badge b-<?= e($c['status']) ?>"><?= e($c['status']) ?></span></td></tr>
      <?php endwhile; ?></tbody></table></div>
    <br><a href="cars.php" class="btn btn-sm">View All Cars</a> <a href="add_car.php" class="btn btn-sm btn-green">+ Add Car</a> <a href="users.php" class="btn btn-sm btn-edit">👥 Manage Users</a>
  </div>
  <div class="card">
    <h2>Cars by Category</h2>
    <?php foreach ($cats as $c): $pct = $total ? round($c['c'] / $total * 100) : 0; ?>
      <div class="bar-row"><div class="lbl"><span><?= e($c['category']) ?></span><b><?= $c['c'] ?></b></div><div class="bar"><i style="width:<?= $pct ?>%"></i></div></div>
    <?php endforeach; ?>
  </div>
</div>
<?php else: ?>
<div class="card" style="background:linear-gradient(135deg,#6d28d9,#0ea5e9);color:#fff">
  <h2 style="color:#fff;font-size:24px">Hello, <?= e($_SESSION['user']['full_name']) ?> 👋</h2>
  <p>Browse our fleet and choose the perfect car for your next trip.</p><br>
  <a href="cars.php" class="btn" style="background:#fff;color:#4f46e5">Browse Cars</a>
</div>
<div class="grid stats">
  <div class="stat s1"><span class="icon">🚗</span><h3><?= $total ?></h3><p>Cars in Fleet</p></div>
  <div class="stat s2"><span class="icon">✅</span><h3><?= $avail ?></h3><p>Available Now</p></div>
  <div class="stat s3"><span class="icon">🏷️</span><h3><?= count($cats) ?></h3><p>Categories</p></div>
</div>
<div class="card">
  <h2>Available Cars For You</h2>
  <div class="table-wrap"><table>
    <thead><tr><th>Car</th><th>Plate</th><th>Category</th><th>Details</th><th>Price/Day</th><th>Status</th></tr></thead><tbody>
    <?php $r = $conn->query("SELECT * FROM cars WHERE status='available' ORDER BY id DESC LIMIT 5"); while ($c = $r->fetch_assoc()): ?>
      <tr><td><strong><?= e($c['brand'].' '.$c['model']) ?></strong><br><small style="color:#6b7280"><?= e($c['year']) ?> • <?= e($c['color']) ?></small></td>
      <td><?= e($c['plate_number']) ?></td><td><?= e($c['category']) ?></td>
      <td><small><?= e($c['seats']) ?> seats • <?= e($c['transmission']) ?> • <?= e($c['fuel']) ?></small></td>
      <td><b>$<?= number_format($c['price_per_day'],2) ?></b></td>
      <td><span class="badge b-<?= e($c['status']) ?>"><?= e($c['status']) ?></span></td></tr>
    <?php endwhile; ?></tbody></table></div>
  <br><a href="cars.php" class="btn btn-sm">View All Cars</a>
</div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
