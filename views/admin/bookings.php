<h2>Manage Bookings</h2>
<form class="filters" method="get" action="<?= BASE_URL ?>/index.php">
  <input type="hidden" name="url" value="admin/bookings">
  <input type="text" name="q" placeholder="Customer or service..." value="<?= e($search) ?>">
  <select name="status">
    <option value="">All statuses</option>
    <?php foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $st): ?>
      <option value="<?= $st ?>" <?= $st === $status ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
    <?php endforeach; ?>
  </select>
  <button class="btn">Filter</button>
  <a class="btn btn-light" href="<?= url('admin/bookings') ?>">Reset</a>
</form>
<div class="table-wrap"><table>
  <tr><th>#</th><th>Customer</th><th>Service</th><th>Date</th><th>Time</th><th>Status</th><th>Update</th><th></th></tr>
  <?php foreach ($bookings as $b): ?>
  <tr>
    <td><?= $b['id'] ?></td>
    <td><?= e($b['customer_name']) ?><br><small class="muted"><?= e($b['customer_email']) ?></small></td>
    <td><?= e($b['service_name']) ?></td>
    <td><?= e($b['booking_date']) ?></td><td><?= e(substr($b['booking_time'], 0, 5)) ?></td>
    <td><span class="status s-<?= e($b['status']) ?>"><?= e($b['status']) ?></span></td>
    <td>
      <form method="post" action="<?= url('admin/bookingstatus/' . $b['id']) ?>" class="inline">
        <?= csrf_field() ?>
        <select name="status">
          <?php foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $st): ?>
            <option value="<?= $st ?>" <?= $st === $b['status'] ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
          <?php endforeach; ?>
        </select>
        <button class="btn btn-sm">Save</button>
      </form>
    </td>
    <td>
      <form method="post" action="<?= url('admin/bookingdelete/' . $b['id']) ?>" onsubmit="return confirm('Delete booking?')">
        <?= csrf_field() ?><button class="btn btn-sm btn-danger">Delete</button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table></div>
<?php if (!$bookings): ?><p class="muted center">No bookings match.</p><?php endif; ?>
