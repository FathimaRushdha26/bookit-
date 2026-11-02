<section class="hero">
  <h1>Book your next appointment in seconds</h1>
  <p>Browse services, pick a date and time, and manage all your bookings online.</p>
  <a class="btn btn-lg" href="<?= url('service') ?>">Browse Services</a>
  <?php if (!is_logged_in()): ?><a class="btn btn-lg btn-light" href="<?= url('auth/register') ?>">Create Account</a><?php endif; ?>
</section>

<h2>Popular Services</h2>
<div class="grid">
<?php foreach ($services as $s): ?>
  <div class="card">
    <span class="badge"><?= e($s['category']) ?></span>
    <h3><?= e($s['name']) ?></h3>
    <p class="muted"><?= e($s['description']) ?></p>
    <p><strong>Rs. <?= number_format($s['price'], 2) ?></strong> &middot; <?= (int)$s['duration_minutes'] ?> min</p>
    <a class="btn btn-sm" href="<?= url('service/show/' . $s['id']) ?>">View</a>
  </div>
<?php endforeach; ?>
</div>
