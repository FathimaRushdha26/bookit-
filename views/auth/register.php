<div class="card narrow">
  <h2>Create Account</h2>
  <form method="post" action="<?= url('auth/register') ?>">
    <?= csrf_field() ?>
    <label>Full Name</label>
    <input type="text" name="name" value="<?= e(old('name')) ?>" required>
    <label>Email</label>
    <input type="email" name="email" value="<?= e(old('email')) ?>" required>
    <label>Phone</label>
    <input type="text" name="phone" value="<?= e(old('phone')) ?>">
    <label>Password</label>
    <input type="password" name="password" minlength="6" required>
    <label>Confirm Password</label>
    <input type="password" name="confirm" minlength="6" required>
    <button class="btn btn-block">Register</button>
  </form>
  <p class="muted">Already registered? <a href="<?= url('auth/login') ?>">Login</a></p>
</div>
