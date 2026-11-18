<?php
// Reads and validates POST data for a car. Returns [$car, $errors]
function read_car_post() {
    $keys = ['brand','model','year','plate_number','color','category','seats','transmission','fuel','price_per_day','status','description'];
    $car = [];
    foreach ($keys as $k) $car[$k] = trim($_POST[$k] ?? '');
    $errors = [];
    if (!csrf_ok()) $errors[] = 'Invalid form session. Please try again.';
    foreach (['brand','model','plate_number','color'] as $k) if ($car[$k] === '') $errors[] = ucfirst(str_replace('_',' ',$k)) . ' is required.';
    if (!ctype_digit($car['year']) || $car['year'] < 1990 || $car['year'] > date('Y') + 1) $errors[] = 'Enter a valid year.';
    if (!ctype_digit($car['seats']) || $car['seats'] < 1) $errors[] = 'Enter a valid number of seats.';
    if (!is_numeric($car['price_per_day']) || $car['price_per_day'] <= 0) $errors[] = 'Price must be greater than 0.';
    if (!in_array($car['category'], ['Economy','SUV','Luxury','Van','Pickup'])) $errors[] = 'Invalid category.';
    if (!in_array($car['transmission'], ['Automatic','Manual'])) $errors[] = 'Invalid transmission.';
    if (!in_array($car['fuel'], ['Petrol','Diesel','Hybrid','Electric'])) $errors[] = 'Invalid fuel type.';
    if (!in_array($car['status'], ['available','rented','maintenance'])) $errors[] = 'Invalid status.';
    return [$car, $errors];
}
