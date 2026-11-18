<?php // Shared form for add_car.php and edit_car.php. Expects $car (array) and $errors, $submit_label ?>
<div class="card">
<?php foreach ($errors as $er): ?><div class="alert alert-error"><?= e($er) ?></div><?php endforeach; ?>
<form method="post" autocomplete="off">
  <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
  <div class="form-grid">
    <div><label>Brand</label><input name="brand" value="<?= e($car['brand']) ?>" placeholder="e.g. Toyota" required></div>
    <div><label>Model</label><input name="model" value="<?= e($car['model']) ?>" placeholder="e.g. Corolla" required></div>
    <div><label>Year</label><input type="number" name="year" value="<?= e($car['year']) ?>" min="1990" max="<?= date('Y')+1 ?>" required></div>
    <div><label>Plate Number</label><input name="plate_number" value="<?= e($car['plate_number']) ?>" placeholder="e.g. RAB 123 A" required></div>
    <div><label>Color</label><input name="color" value="<?= e($car['color']) ?>" required></div>
    <div><label>Category</label><select name="category">
      <?php foreach (['Economy','SUV','Luxury','Van','Pickup'] as $o): ?><option <?= $car['category']==$o?'selected':'' ?>><?= $o ?></option><?php endforeach; ?></select></div>
    <div><label>Seats</label><input type="number" name="seats" value="<?= e($car['seats']) ?>" min="1" max="60" required></div>
    <div><label>Transmission</label><select name="transmission">
      <?php foreach (['Automatic','Manual'] as $o): ?><option <?= $car['transmission']==$o?'selected':'' ?>><?= $o ?></option><?php endforeach; ?></select></div>
    <div><label>Fuel</label><select name="fuel">
      <?php foreach (['Petrol','Diesel','Hybrid','Electric'] as $o): ?><option <?= $car['fuel']==$o?'selected':'' ?>><?= $o ?></option><?php endforeach; ?></select></div>
    <div><label>Price per Day ($)</label><input type="number" step="0.01" min="1" name="price_per_day" value="<?= e($car['price_per_day']) ?>" required></div>
    <div><label>Status</label><select name="status">
      <?php foreach (['available','rented','maintenance'] as $o): ?><option value="<?= $o ?>" <?= $car['status']==$o?'selected':'' ?>><?= ucfirst($o) ?></option><?php endforeach; ?></select></div>
    <div class="full"><label>Description</label><textarea name="description" rows="3" maxlength="255"><?= e($car['description']) ?></textarea></div>
  </div>
  <br>
  <button class="btn btn-green" type="submit"><?= e($submit_label) ?></button>
  <a href="cars.php" class="btn btn-gray">Cancel</a>
</form>
</div>
