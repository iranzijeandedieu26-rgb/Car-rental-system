<?php
require 'config.php';
require_login();
$page_title = is_admin() ? 'Manage Cars' : 'Available Cars'; $active = 'cars';

// Filters
$q = trim($_GET['q'] ?? ''); $cat = $_GET['category'] ?? ''; $st = $_GET['status'] ?? '';
$where = []; $types = ''; $params = [];
if ($q !== '') { $where[] = '(brand LIKE ? OR model LIKE ? OR plate_number LIKE ?)'; $types .= 'sss'; array_push($params, "%$q%", "%$q%", "%$q%"); }
if (in_array($cat, ['Economy','SUV','Luxury','Van','Pickup'])) { $where[] = 'category = ?'; $types .= 's'; $params[] = $cat; }
if (in_array($st, ['available','rented','maintenance'])) { $where[] = 'status = ?'; $types .= 's'; $params[] = $st; }
$w = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Pagination
$page = max(1, (int)($_GET['page'] ?? 1));
$stmt = $conn->prepare("SELECT COUNT(*) FROM cars $w");
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total = (int)$stmt->get_result()->fetch_row()[0];
$pages = max(1, (int)ceil($total / PER_PAGE));
$page = min($page, $pages);
$offset = ($page - 1) * PER_PAGE;

$stmt = $conn->prepare("SELECT * FROM cars $w ORDER BY id DESC LIMIT " . PER_PAGE . " OFFSET $offset");
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$cars = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

function page_url($p) { $g = $_GET; $g['page'] = $p; return '?' . http_build_query($g); }
include 'includes/header.php';
?>
<div class="card">
  <form class="filters" method="get">
    <input name="q" placeholder="🔍 Search brand, model or plate..." value="<?= e($q) ?>">
    <select name="category"><option value="">All Categories</option>
      <?php foreach (['Economy','SUV','Luxury','Van','Pickup'] as $o): ?><option <?= $cat==$o?'selected':'' ?>><?= $o ?></option><?php endforeach; ?></select>
    <select name="status"><option value="">All Status</option>
      <?php foreach (['available','rented','maintenance'] as $o): ?><option value="<?= $o ?>" <?= $st==$o?'selected':'' ?>><?= ucfirst($o) ?></option><?php endforeach; ?></select>
    <button class="btn">Filter</button> <a href="cars.php" class="btn btn-gray">Reset</a>
    <?php if (is_admin()): ?><a href="add_car.php" class="btn btn-green" style="margin-left:auto">+ Add Car</a><?php endif; ?>
  </form>
  <p style="color:#6b7280;font-size:14px">Showing <b><?= count($cars) ?></b> of <b><?= $total ?></b> cars — Page <?= $page ?> of <?= $pages ?></p>
</div>

<?php if (!$cars): ?>
  <div class="card empty">😕 No cars found.</div>
<?php elseif (is_admin()): ?>
  <div class="card"><div class="table-wrap"><table>
    <thead><tr><th>#</th><th>Car</th><th>Plate</th><th>Category</th><th>Details</th><th>Price/Day</th><th>Status</th><th>Actions</th></tr></thead><tbody>
    <?php foreach ($cars as $c): ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><strong><?= e($c['brand'].' '.$c['model']) ?></strong><br><small style="color:#6b7280"><?= e($c['year']) ?> • <?= e($c['color']) ?></small></td>
        <td><?= e($c['plate_number']) ?></td><td><?= e($c['category']) ?></td>
        <td><small><?= e($c['seats']) ?> seats • <?= e($c['transmission']) ?> • <?= e($c['fuel']) ?></small></td>
        <td><b>$<?= number_format($c['price_per_day'],2) ?></b></td>
        <td><span class="badge b-<?= e($c['status']) ?>"><?= e($c['status']) ?></span></td>
        <td style="white-space:nowrap">
          <a class="btn btn-sm btn-edit" href="edit_car.php?id=<?= $c['id'] ?>">✏️ Edit</a>
          <form method="post" action="delete_car.php" style="display:inline" onsubmit="return confirm('Delete <?= e($c['brand'].' '.$c['model']) ?>? This cannot be undone.')">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= $c['id'] ?>">
            <button class="btn btn-sm btn-del" type="submit">🗑️ Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?></tbody></table></div></div>
<?php else: ?>
  <div class="grid cars"><?php foreach ($cars as $c) include 'includes/car_card.php'; ?></div>
<?php endif; ?>

<?php if ($pages > 1): ?>
<div class="pagination">
  <?= $page > 1 ? '<a href="'.e(page_url($page-1)).'">« Prev</a>' : '<span class="disabled">« Prev</span>' ?>
  <?php for ($i = 1; $i <= $pages; $i++): ?>
    <?= $i == $page ? "<span class=\"current\">$i</span>" : '<a href="'.e(page_url($i))."\">$i</a>" ?>
  <?php endfor; ?>
  <?= $page < $pages ? '<a href="'.e(page_url($page+1)).'">Next »</a>' : '<span class="disabled">Next »</span>' ?>
</div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
