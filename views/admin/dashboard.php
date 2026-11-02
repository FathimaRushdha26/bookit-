<h2>Admin Dashboard</h2>
<div class="grid stats">
  <div class="card stat"><span><?= $customers ?></span>Customers</div>
  <div class="card stat"><span><?= $services ?></span>Services</div>
  <div class="card stat"><span><?= array_sum($counts) ?></span>Total Bookings</div>
  <div class="card stat"><span>Rs. <?= number_format($revenue, 2) ?></span>Revenue (confirmed + completed)</div>
</div>

<div class="grid">
  <div class="card">
    <h3>Bookings by Status</h3>
    <?php $max = max(1, max($counts)); foreach ($counts as $st => $n): ?>
      <div class="bar-row">
        <span class="bar-label"><?= e(ucfirst($st)) ?></span>
        <div class="bar"><div class="bar-fill s-<?= e($st) ?>" style="width:<?= round($n / $max * 100) ?>%"></div></div>
        <span><?= $n ?></span>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="card">
    <h3>Top Services</h3>
    <table>
      <tr><th>Service</th><th>Bookings</th><th>Revenue</th></tr>
      <?php foreach ($perService as $p): ?>
        <tr><td><?= e($p['name']) ?></td><td><?= (int)$p['total'] ?></td><td>Rs. <?= number_format($p['revenue'], 2) ?></td></tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

<div class="card">
  <h3>Recent Bookings</h3>
  <table>
    <tr><th>Customer</th><th>Service</th><th>Date</th><th>Time</th><th>Status</th></tr>
    <?php foreach ($recent as $b): ?>
      <tr><td><?= e($b['customer_name']) ?></td><td><?= e($b['service_name']) ?></td>
          <td><?= e($b['booking_date']) ?></td><td><?= e(substr($b['booking_time'], 0, 5)) ?></td>
          <td><span class="status s-<?= e($b['status']) ?>"><?= e($b['status']) ?></span></td></tr>
    <?php endforeach; ?>
  </table>
</div>
