<?php
class BookingController extends Controller {
    public function __construct() { $this->requireLogin(); }

    // Booking form + save
    public function create($serviceId = 0) {
        $service = $this->model('Service')->find((int)$serviceId);
        if (!$service || !$service['is_active']) { flash('error', 'Service not available.'); $this->redirect('service'); }

        if ($this->isPost()) {
            $this->verifyCsrf();
            $date  = $_POST['booking_date'] ?? '';
            $time  = $_POST['booking_time'] ?? '';
            $notes = trim($_POST['notes'] ?? '');
            $d = DateTime::createFromFormat('Y-m-d', $date);
            $bookings = $this->model('Booking');

            if (!$d || $d->format('Y-m-d') !== $date || $date < date('Y-m-d')) {
                flash('error', 'Choose a valid future date.');
            } elseif (!in_array($time, TIME_SLOTS, true)) {
                flash('error', 'Choose a valid time slot.');
            } elseif ($bookings->isSlotTaken($service['id'], $date, $time)) {
                flash('error', 'That slot was just taken. Pick another.');
            } else {
                $bookings->create(current_user()['id'], $service['id'], $date, $time, $notes);
                flash('success', 'Booking submitted. Awaiting confirmation.');
                $this->redirect('booking/mine');
            }
        }
        $this->view('booking/create', ['title' => 'Book ' . $service['name'], 'service' => $service]);
    }

    // AJAX: available slots for a service on a date
    public function slots($serviceId = 0) {
        $date = $_GET['date'] ?? '';
        $taken = $this->model('Booking')->takenSlots((int)$serviceId, $date);
        $out = [];
        foreach (TIME_SLOTS as $t) {
            $past = ($date === date('Y-m-d') && $t <= date('H:i'));
            $out[] = ['time' => $t, 'available' => !in_array($t, $taken, true) && !$past];
        }
        $this->json($out);
    }

    public function mine() {
        $m = $this->model('Booking');
        $uid = current_user()['id'];
        $this->view('booking/mine', [
            'title' => 'My Bookings',
            'bookings' => $m->byUser($uid),
            'upcoming' => $m->upcomingForUser($uid),
        ]);
    }

    public function cancel($id = 0) {
        if (!$this->isPost()) $this->redirect('booking/mine');
        $this->verifyCsrf();
        $ok = $this->model('Booking')->cancelOwn((int)$id, current_user()['id']);
        flash($ok ? 'success' : 'error', $ok ? 'Booking cancelled.' : 'This booking cannot be cancelled.');
        $this->redirect('booking/mine');
    }
}
