<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? APP_NAME) ?> | <?= APP_NAME ?></title>
<link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
<nav class="nav">
  <div class="container nav-inner">
    <a class="brand" href="<?= url('home') ?>">&#128197; <?= APP_NAME ?></a>
    <div class="links">
      <a href="<?= url('home') ?>">Home</a>
      <a href="<?= url('service') ?>">Services</a>
      <?php if (is_logged_in()): ?>
        <?php if (is_admin()): ?>
          <a href="<?= url('admin/dashboard') ?>">Dashboard</a>
          <a href="<?= url('admin/services') ?>">Services Mgmt</a>
          <a href="<?= url('admin/bookings') ?>">Bookings</a>
          <a href="<?= url('admin/users') ?>">Users</a>
        <?php else: ?>
          <a href="<?= url('booking/mine') ?>">My Bookings</a>
        <?php endif; ?>
        <a href="<?= url('profile') ?>">&#128100; <?= e(current_user()['name']) ?></a>
        <a href="<?= url('auth/logout') ?>" class="btn btn-sm" style="background-color: #dc2626; color: white;">Logout</a>
      <?php else: ?>
        <a href="<?= url('auth/login') ?>">Login</a>
        <a href="<?= url('auth/register') ?>" class="btn btn-sm" style="background-color: #16a34a; color: white;">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<main class="container">
<?php foreach (flash() as $type => $msg): ?>
  <div class="alert alert-<?= e($type) ?>"><?= e($msg) ?></div>
<?php endforeach; ?>