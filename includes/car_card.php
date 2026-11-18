<?php // expects $c (car row) ?>
<div class="car">
  <div class="car-top c-<?= e($c['category']) ?>">🚗<span class="badge b-<?= e($c['status']) ?>"><?= e($c['status']) ?></span></div>
  <div class="car-body">
    <h3><?= e($c['brand'].' '.$c['model']) ?></h3>
    <div class="meta"><?= e($c['year']) ?> • <?= e($c['color']) ?> • <?= e($c['plate_number']) ?></div>
    <div class="tags"><span><?= e($c['category']) ?></span><span>👥 <?= e($c['seats']) ?> seats</span><span><?= e($c['transmission']) ?></span><span>⛽ <?= e($c['fuel']) ?></span></div>
    <p style="font-size:13px;color:#6b7280;margin:8px 0 12px;min-height:38px"><?= e($c['description']) ?></p>
    <div class="price">$<?= number_format($c['price_per_day'],2) ?> <small>/ day</small></div>
  </div>
</div>
