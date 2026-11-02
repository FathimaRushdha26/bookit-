<div class="card narrow">
  <h2>Add User</h2>
  <form method="post" action="<?= url('admin/usersave') ?>">
    <?= csrf_field() ?>
    <label>Full Name</label><input type="text" name="name" value="<?= e(old('name')) ?>" required>
    <label>Email</label><input type="email" name="email" value="<?= e(old('email')) ?>" required>
    <label>Phone</label><input type="text" name="phone" value="<?= e(old('phone')) ?>">
    <label>Password</label><input type="password" name="password" minlength="6" required>
    <label>Role</label>
    <select name="role">
      <option value="customer" <?= old('role') === 'customer' ? 'selected' : '' ?>>Customer</option>
      <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>
    <button class="btn">Save</button>
    <a class="btn btn-light" href="<?= url('admin/users') ?>">Cancel</a>
  </form>
</div>
