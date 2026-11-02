<h2>My Profile</h2>
<div class="grid">
  <div class="card">
    <h3>Details</h3>
    <form method="post" action="<?= url('profile/update') ?>">
      <?= csrf_field() ?>
      <label>Name</label><input type="text" name="name" value="<?= e($user['name']) ?>" required>
      <label>Email</label><input type="email" value="<?= e($user['email']) ?>" disabled>
      <label>Phone</label><input type="text" name="phone" value="<?= e($user['phone']) ?>">
      <button class="btn">Save</button>
    </form>
  </div>
  <div class="card">
    <h3>Change Password</h3>
    <form method="post" action="<?= url('profile/password') ?>">
      <?= csrf_field() ?>
      <label>Current Password</label><input type="password" name="current_password" required>
      <label>New Password</label><input type="password" name="new_password" minlength="6" required>
      <label>Confirm New Password</label><input type="password" name="confirm" minlength="6" required>
      <button class="btn">Update Password</button>
    </form>
  </div>
</div>
