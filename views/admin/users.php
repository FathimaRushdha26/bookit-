<div class="head-row"><h2>Users</h2><a class="btn" href="<?= url('admin/userform') ?>">+ Add User</a></div>
<div class="table-wrap"><table>
  <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Bookings</th><th>Joined</th><th></th></tr>
  <?php foreach ($users as $u): ?>
  <tr>
    <td><?= $u['id'] ?></td><td><?= e($u['name']) ?></td><td><?= e($u['email']) ?></td>
    <td><?= e($u['phone']) ?></td><td><span class="badge"><?= e($u['role']) ?></span></td>
    <td><?= (int)$u['total_bookings'] ?></td><td><?= e(substr($u['created_at'], 0, 10)) ?></td>
    <td>
      <?php if ($u['role'] === 'customer'): ?>
      <form method="post" action="<?= url('admin/userdelete/' . $u['id']) ?>" onsubmit="return confirm('Delete this customer and their bookings?')">
        <?= csrf_field() ?><button class="btn btn-sm btn-danger">Delete</button>
      </form>
      <?php endif; ?>
    </td>
  </tr>
  <?php endforeach; ?>
</table></div>
