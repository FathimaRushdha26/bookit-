<div class="card narrow">
  <h2>Book: <?= e($service['name']) ?></h2>
  <p class="muted">Rs. <?= number_format($service['price'], 2) ?> &middot; <?= (int)$service['duration_minutes'] ?> min</p>
  <form method="post" action="<?= url('booking/create/' . $service['id']) ?>" id="bookingForm"
        data-slots-url="<?= url('booking/slots/' . $service['id']) ?>">
    <?= csrf_field() ?>
    <label>Date</label>
    <input type="date" name="booking_date" id="bookingDate" min="<?= date('Y-m-d') ?>" value="<?= e(old('booking_date')) ?>" required>
    <label>Time Slot</label>
    <div id="slots" class="slots"><span class="muted">Select a date to see available slots.</span></div>
    <input type="hidden" name="booking_time" id="bookingTime" value="<?= e(old('booking_time')) ?>">
    <label>Notes (optional)</label>
    <textarea name="notes" rows="3" maxlength="255"><?= e(old('notes')) ?></textarea>
    <button class="btn btn-block">Confirm Booking</button>
  </form>
</div>
