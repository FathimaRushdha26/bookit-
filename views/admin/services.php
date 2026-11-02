<div class="head-row"><h2>Manage Services</h2><a class="btn" href="<?= url('admin/serviceform') ?>">+ Add Service</a></div>
<div class="table-wrap"><table>
  <tr><th>#</th><th>Name</th><th>Category</th><th>Price</th><th>Duration</th><th>Status</th><th>Actions</th></tr>
  <?php foreach ($services as $s): ?>
  <tr>
    <td><?= $s['id'] ?></td><td><?= e($s['name']) ?></td><td><?= e($s['category']) ?></td>
    <td>Rs. <?= number_format($s['price'], 2) ?></td><td><?= (int)$s['duration_minutes'] ?> min</td>
    <td><span class="status <?= $s['is_active'] ? 's-confirmed' : 's-cancelled' ?>"><?= $s['is_active'] ? 'Active' : 'Inactive' ?></span></td>
    <td class="actions">
      <a class="btn btn-sm btn-light" href="<?= url('admin/serviceform/' . $s['id']) ?>">Edit</a>
      <form method="post" action="<?= url('admin/servicedelete/' . $s['id']) ?>" onsubmit="return confirm('Delete this service?')">
        <?= csrf_field() ?><button class="btn btn-sm btn-danger">Delete</button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
</table></div>
