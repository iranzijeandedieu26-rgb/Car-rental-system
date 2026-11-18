<?php
require 'config.php';
require_login('admin');
require 'includes/car_validate.php';
$page_title = 'Update Car'; $active = 'cars';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$stmt = $conn->prepare('SELECT * FROM cars WHERE id = ?');
$stmt->bind_param('i', $id); $stmt->execute();
$car = $stmt->get_result()->fetch_assoc();
if (!$car) { flash('Car not found.', 'error'); header('Location: cars.php'); exit; }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$car, $errors] = read_car_post();
    if (!$errors) {
        $chk = $conn->prepare('SELECT id FROM cars WHERE plate_number = ? AND id <> ?');
        $chk->bind_param('si', $car['plate_number'], $id); $chk->execute();
        if ($chk->get_result()->num_rows) $errors[] = 'Another car already uses this plate number.';
    }
    if (!$errors) {
        $stmt = $conn->prepare('UPDATE cars SET brand=?,model=?,year=?,plate_number=?,color=?,category=?,seats=?,transmission=?,fuel=?,price_per_day=?,status=?,description=? WHERE id=?');
        $stmt->bind_param('ssisssissdssi', $car['brand'],$car['model'],$car['year'],$car['plate_number'],$car['color'],$car['category'],$car['seats'],$car['transmission'],$car['fuel'],$car['price_per_day'],$car['status'],$car['description'],$id);
        if ($stmt->execute()) { flash('Car updated successfully.'); header('Location: cars.php'); exit; }
        $errors[] = 'Could not update the car. Please try again.';
    }
}
$submit_label = '✅ Update Car';
include 'includes/header.php';
echo '<p style="margin-bottom:16px;color:#6b7280">Editing car #' . (int)$id . '</p>';
include 'includes/car_form.php';
include 'includes/footer.php';
