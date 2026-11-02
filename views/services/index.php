<h2>Our Services</h2>
<form class="filters" method="get" action="<?= BASE_URL ?>/index.php">
  <input type="hidden" name="url" value="service">
  <input type="text" name="q" placeholder="Search services..." value="<?= e($search) ?>">
  <select name="category">
    <option value="">All categories</option>
    <?php foreach ($categories as $c): ?>
      <option value="<?= e($c) ?>" <?= $c === $category ? 'selected' : '' ?>><?= e($c) ?></option>
    <?php endforeach; ?>
  </select>
  <button class="btn">Search</button>
  <a class="btn btn-light" href="<?= url('service') ?>">Reset</a>
</form>

<?php if (!$services): ?>
  <div class="card center muted">No services found.</div>
<?php endif; ?>
<div class="grid">
<?php foreach ($services as $s): ?>
  <div class="card">
    <span class="badge"><?= e($s['category']) ?></span>
    <h3><?= e($s['name']) ?></h3>
    <p class="muted"><?= e($s['description']) ?></p>
    <p><strong>Rs. <?= number_format($s['price'], 2) ?></strong> &middot; <?= (int)$s['duration_minutes'] ?> min</p>
    <a class="btn btn-sm btn-light" href="<?= url('service/show/' . $s['id']) ?>">Details</a>
    <a class="btn btn-sm" href="<?= url('booking/create/' . $s['id']) ?>">Book Now</a>
  </div>
<?php endforeach; ?>
</div>
