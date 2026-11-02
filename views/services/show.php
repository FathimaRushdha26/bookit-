<div class="card">
  <span class="badge"><?= e($service['category']) ?></span>
  <h2><?= e($service['name']) ?></h2>
  <p><?= nl2br(e($service['description'])) ?></p>
  <p><strong>Price:</strong> Rs. <?= number_format($service['price'], 2) ?><br>
     <strong>Duration:</strong> <?= (int)$service['duration_minutes'] ?> minutes</p>
  <a class="btn btn-light" href="<?= url('service') ?>">&larr; Back</a>
  <a class="btn" href="<?= url('booking/create/' . $service['id']) ?>">Book Now</a>
</div>
