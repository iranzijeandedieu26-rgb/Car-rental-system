<?php
require 'config.php';
require_login('admin');
$page_title = 'Manage Users'; $active = 'users';

// Search + role + status filters
$q = trim($_GET['q'] ?? ''); $role = $_GET['role'] ?? ''; $st = $_GET['status'] ?? '';
$where = []; $types = ''; $params = [];
if ($q !== '') { $where[] = '(full_name LIKE ? OR username LIKE ? OR email LIKE ?)'; $types .= 'sss'; array_push($params, "%$q%", "%$q%", "%$q%"); }
if (in_array($role, ['admin','customer'])) { $where[] = 'role = ?'; $types .= 's'; $params[] = $role; }
if ($st === 'pending')  $where[] = "password LIKE 'PENDING:%'";
if ($st === 'approved') $where[] = "password NOT LIKE 'PENDING:%'";
$w = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Pagination
$page = max(1, (int)($_GET['page'] ?? 1));
$stmt = $conn->prepare("SELECT COUNT(*) FROM users $w");
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total = (int)$stmt->get_result()->fetch_row()[0];
$pages = max(1, (int)ceil($total / PER_PAGE));
$page = min($page, $pages);
$offset = ($page - 1) * PER_PAGE;

// Pending users are listed first so the admin sees them straight away
$stmt = $conn->prepare("SELECT id, full_name, username, email, role, created_at, (password LIKE 'PENDING:%') AS pending FROM users $w ORDER BY pending DESC, id ASC LIMIT " . PER_PAGE . " OFFSET $offset");
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$pending_total = pending_count();

function page_url($p) { $g = $_GET; $g['page'] = $p; return '?' . http_build_query($g); }
include 'includes/header.php';
?>
<?php if ($pending_total > 0): ?>
  <div class="alert alert-warning">⏳ <?= $pending_total ?> user(s) are waiting for your approval.
    <a href="?status=pending" style="text-decoration:underline;font-weight:700">Show pending users</a></div>
<?php endif; ?>
<div class="card">
  <form class="filters" method="get">
    <input name="q" placeholder="🔍 Search name, username or email..." value="<?= e($q) ?>">
    <select name="role"><option value="">All Roles</option>
      <option value="admin" <?= $role=='admin'?'selected':'' ?>>Admin</option>
      <option value="customer" <?= $role=='customer'?'selected':'' ?>>Customer</option></select>
    <select name="status"><option value="">All Status</option>
      <option value="pending" <?= $st=='pending'?'selected':'' ?>>Pending</option>
      <option value="approved" <?= $st=='approved'?'selected':'' ?>>Approved</option></select>
    <button class="btn">Filter</button> <a href="users.php" class="btn btn-gray">Reset</a>
    <a href="add_user.php" class="btn btn-green" style="margin-left:auto">+ Add User</a>
  </form>
  <p style="color:#6b7280;font-size:14px">Showing <b><?= count($users) ?></b> of <b><?= $total ?></b> users — Page <?= $page ?> of <?= $pages ?></p>
</div>

<?php if (!$users): ?>
  <div class="card empty">😕 No users found.</div>
<?php else: ?>
<div class="card"><div class="table-wrap"><table>
  <thead><tr><th>#</th><th>Full Name</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead><tbody>
  <?php foreach ($users as $u): $self = $u['id'] == $_SESSION['user']['id']; ?>
    <tr>
      <td><?= $u['id'] ?></td>
      <td><strong><?= e($u['full_name']) ?></strong><?= $self ? ' <span class="badge b-available">You</span>' : '' ?></td>
      <td><?= e($u['username']) ?></td><td><?= e($u['email']) ?></td>
      <td><span class="role"><?= e($u['role']) ?></span></td>
      <td><?= $u['pending'] ? '<span class="badge b-maintenance">Pending</span>' : '<span class="badge b-available">Approved</span>' ?></td>
      <td><small><?= e(date('d M Y', strtotime($u['created_at']))) ?></small></td>
      <td style="white-space:nowrap">
        <?php if ($u['pending']): ?>
        <form method="post" action="approve_user.php" style="display:inline">
          <input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= $u['id'] ?>">
          <button class="btn btn-sm btn-green" type="submit">✅ Approve</button>
        </form>
        <?php endif; ?>
        <?php if ($self): ?><small style="color:#6b7280">Current account</small>
        <?php else: ?>
        <form method="post" action="delete_user.php" style="display:inline" onsubmit="return confirm('<?= $u['pending'] ? 'Reject and delete' : 'Delete' ?> user <?= e($u['username']) ?>? This cannot be undone.')">
          <input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= $u['id'] ?>">
          <button class="btn btn-sm btn-del" type="submit">🗑️ <?= $u['pending'] ? 'Reject' : 'Delete' ?></button>
        </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?></tbody></table></div></div>
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
