<div class="card narrow">
  <h2>Login</h2>
  <form method="post" action="<?= url('auth/login') ?>">
    <?= csrf_field() ?>
    <label>Email</label>
    <input type="email" name="email" value="<?= e(old('email')) ?>" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <button class="btn btn-block">Login</button>
  </form>
  <p class="muted">No account? <a href="<?= url('auth/register') ?>">Register</a></p>
  <p class="muted small">Demo: admin@bookit.com / Admin@123 &middot; john@example.com / Customer@123</p>
</div>
