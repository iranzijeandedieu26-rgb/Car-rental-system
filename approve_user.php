<?php
require 'config.php';
require_login('admin');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_ok()) {
    $id = (int)($_POST['id'] ?? 0);
    // Approving = removing the PENDING: prefix (8 characters) from the stored hash
    $stmt = $conn->prepare("UPDATE users SET password = SUBSTRING(password, 9) WHERE id = ? AND password LIKE 'PENDING:%'");
    $stmt->bind_param('i', $id); $stmt->execute();
    $stmt->affected_rows ? flash('User approved. They can now log in.') : flash('User not found or already approved.', 'error');
} else {
    flash('Invalid request.', 'error');
}
header('Location: users.php');
exit;
