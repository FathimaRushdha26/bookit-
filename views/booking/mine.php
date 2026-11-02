<h2>My Bookings</h2>
<p class="muted">Upcoming active bookings: <strong><?= (int)$upcoming ?></strong></p>
<?php if (!$bookings): ?>
  <div class="card center muted">No bookings yet. <a href="<?= url('service') ?>">Browse services</a></div>
<?php else: ?>
<div class="table-wrap"><table>
  <tr><th>#</th><th>Service</th><th>Date</th><th>Time</th><th>Price</th><th>Status</th><th></th></tr>
  <?php foreach ($bookings as $b): ?>
  <tr>
    <td><?= $b['id'] ?></td>
    <td><?= e($b['service_name']) ?></td>
    <td><?= e($b['booking_date']) ?></td>
    <td><?= e(substr($b['booking_time'], 0, 5)) ?></td>
    <td>Rs. <?= number_format($b['price'], 2) ?></td>
    <td><span class="status s-<?= e($b['status']) ?>"><?= e($b['status']) ?></span></td>
    <td>
      <?php if (in_array($b['status'], ['pending', 'confirmed'])): ?>
      <form method="post" action="<?= url('booking/cancel/' . $b['id']) ?>" onsubmit="return confirm('Cancel this booking?')">
        <?= csrf_field() ?><button class="btn btn-sm btn-danger">Cancel</button>
      </form>
      <?php endif; ?>
    </td>
  </tr>
  <?php endforeach; ?>
</table></div>
<?php endif; ?>
