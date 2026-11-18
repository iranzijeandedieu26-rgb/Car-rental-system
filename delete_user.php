<?php
require 'config.php';
require_login('admin');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_ok()) {
    $id = (int)($_POST['id'] ?? 0);
    if ($id === (int)$_SESSION['user']['id']) {
        flash('You cannot delete your own account.', 'error');
    } else {
        $stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
        $stmt->bind_param('i', $id); $stmt->execute();
        $stmt->affected_rows ? flash('User removed successfully.') : flash('User not found.', 'error');
    }
} else {
    flash('Invalid request.', 'error');
}
header('Location: users.php');
exit;
