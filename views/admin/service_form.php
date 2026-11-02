<?php $s = $service ?? []; $v = fn($k, $d = '') => e(old($k, $s[$k] ?? $d)); ?>
<div class="card narrow">
  <h2><?= $service ? 'Edit Service' : 'Add Service' ?></h2>
  <form method="post" action="<?= url('admin/servicesave/' . ($service['id'] ?? 0)) ?>">
    <?= csrf_field() ?>
    <label>Name</label><input type="text" name="name" value="<?= $v('name') ?>" required>
    <label>Category</label><input type="text" name="category" value="<?= $v('category') ?>" required>
    <label>Description</label><textarea name="description" rows="3"><?= $v('description') ?></textarea>
    <label>Price (Rs.)</label><input type="number" step="0.01" min="0" name="price" value="<?= $v('price', '0') ?>" required>
    <label>Duration (minutes)</label><input type="number" min="5" name="duration" value="<?= e(old('duration', $s['duration_minutes'] ?? 60)) ?>" required>
    <label class="check"><input type="checkbox" name="is_active" <?= (!$service || $s['is_active']) ? 'checked' : '' ?>> Active (visible to customers)</label>
    <button class="btn">Save</button>
    <a class="btn btn-light" href="<?= url('admin/services') ?>">Cancel</a>
  </form>
</div>
