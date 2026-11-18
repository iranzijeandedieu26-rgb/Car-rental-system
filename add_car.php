<?php
require 'config.php';
require_login('admin');
require 'includes/car_validate.php';
$page_title = 'Add New Car'; $active = 'add';
$car = ['brand'=>'','model'=>'','year'=>date('Y'),'plate_number'=>'','color'=>'','category'=>'Economy','seats'=>5,'transmission'=>'Automatic','fuel'=>'Petrol','price_per_day'=>'','status'=>'available','description'=>''];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$car, $errors] = read_car_post();
    if (!$errors) {
        $chk = $conn->prepare('SELECT id FROM cars WHERE plate_number = ?');
        $chk->bind_param('s', $car['plate_number']); $chk->execute();
        if ($chk->get_result()->num_rows) $errors[] = 'A car with this plate number already exists.';
    }
    if (!$errors) {
        $uid = $_SESSION['user']['id'];
        $stmt = $conn->prepare('INSERT INTO cars (brand,model,year,plate_number,color,category,seats,transmission,fuel,price_per_day,status,description,added_by) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $stmt->bind_param('ssisssissdssi', $car['brand'],$car['model'],$car['year'],$car['plate_number'],$car['color'],$car['category'],$car['seats'],$car['transmission'],$car['fuel'],$car['price_per_day'],$car['status'],$car['description'],$uid);
        if ($stmt->execute()) { flash('Car added successfully.'); header('Location: cars.php'); exit; }
        $errors[] = 'Could not save the car. Please try again.';
    }
}
$submit_label = '💾 Save Car';
include 'includes/header.php';
include 'includes/car_form.php';
include 'includes/footer.php';
