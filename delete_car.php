<?php
require 'config.php';
require_login('admin');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_ok()) {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = $conn->prepare('DELETE FROM cars WHERE id = ?');
    $stmt->bind_param('i', $id); $stmt->execute();
    $stmt->affected_rows ? flash('Car deleted successfully.') : flash('Car not found.', 'error');
} else {
    flash('Invalid request.', 'error');
}
header('Location: cars.php');
exit;
