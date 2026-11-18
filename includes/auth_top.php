<?php // Opens the login-style page. Set $auth_title and $auth_sub before including. ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($auth_title) ?> | Car Rental System</title>
<?php include __DIR__ . '/style.php'; ?>
</head>
<body class="login-body">
<div class="login-box">
  <div class="login-art">
    <div class="big">🚘</div>
    <h2>Car Rental<br>Information System</h2>
    <p>Find, manage and rent the perfect car. Fast, simple and reliable.</p>
  </div>
  <div class="login-form">
    <h2><?= e($auth_title) ?></h2>
    <p class="sub"><?= e($auth_sub) ?></p>
