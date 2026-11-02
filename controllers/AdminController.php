<?php
class AdminController extends Controller {
    public function __construct() { $this->requireAdmin(); }

    public function index() { $this->redirect('admin/dashboard'); }

    // Reporting dashboard
    public function dashboard() {
        $b = $this->model('Booking');
        $this->view('admin/dashboard', [
            'title' => 'Dashboard',
            'counts' => $b->statusCounts(),
            'revenue' => $b->revenue(),
            'perService' => $b->perService(),
            'customers' => $this->model('User')->countCustomers(),
            'services' => $this->model('Service')->count(),
            'recent' => array_slice($b->all(), 0, 5),
        ]);
    }

    // ---- Services CRUD ----
    public function services() {
        $this->view('admin/services', ['title' => 'Manage Services', 'services' => $this->model('Service')->all('', '', false)]);
    }

    public function serviceform($id = 0) {
        $service = $id ? $this->model('Service')->find((int)$id) : null;
        if ($id && !$service) { flash('error', 'Service not found.'); $this->redirect('admin/services'); }
        $this->view('admin/service_form', ['title' => $service ? 'Edit Service' : 'Add Service', 'service' => $service]);
    }

    public function servicesave($id = 0) {
        if (!$this->isPost()) $this->redirect('admin/services');
        $this->verifyCsrf();
        $d = [
            'name' => trim($_POST['name'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'price' => (float)($_POST['price'] ?? 0),
            'duration' => (int)($_POST['duration'] ?? 60),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        if ($d['name'] === '' || $d['category'] === '' || $d['price'] < 0 || $d['duration'] < 5) {
            flash('error', 'Name, category, a valid price and duration are required.');
            $this->redirect('admin/serviceform/' . (int)$id);
        }
        $m = $this->model('Service');
        $id ? $m->update((int)$id, $d) : $m->create($d);
        flash('success', $id ? 'Service updated.' : 'Service added.');
        $this->redirect('admin/services');
    }

    public function servicedelete($id = 0) {
        if (!$this->isPost()) $this->redirect('admin/services');
        $this->verifyCsrf();
        try {
            $this->model('Service')->delete((int)$id);
            flash('success', 'Service deleted.');
        } catch (PDOException $e) {
            flash('error', 'Service has bookings and cannot be deleted. Deactivate it instead.');
        }
        $this->redirect('admin/services');
    }

    // ---- Bookings management ----
    public function bookings() {
        $status = $_GET['status'] ?? '';
        $search = trim($_GET['q'] ?? '');
        $this->view('admin/bookings', [
            'title' => 'Manage Bookings',
            'bookings' => $this->model('Booking')->all($status, $search),
            'status' => $status, 'search' => $search,
        ]);
    }

    public function bookingstatus($id = 0) {
        if (!$this->isPost()) $this->redirect('admin/bookings');
        $this->verifyCsrf();
        $status = $_POST['status'] ?? '';
        if (in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'], true)) {
            $this->model('Booking')->updateStatus((int)$id, $status);
            flash('success', 'Booking marked ' . $status . '.');
        }
        $this->redirect('admin/bookings');
    }

    public function bookingdelete($id = 0) {
        if (!$this->isPost()) $this->redirect('admin/bookings');
        $this->verifyCsrf();
        $this->model('Booking')->delete((int)$id);
        flash('success', 'Booking deleted.');
        $this->redirect('admin/bookings');
    }

    // ---- Users ----
    public function users() {
        $this->view('admin/users', ['title' => 'Users', 'users' => $this->model('User')->all()]);
    }

    public function userform() {
        $this->view('admin/user_form', ['title' => 'Add User']);
    }

    public function usersave() {
        if (!$this->isPost()) $this->redirect('admin/users');
        $this->verifyCsrf();
        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';
        $role  = in_array($_POST['role'] ?? '', ['admin', 'customer'], true) ? $_POST['role'] : 'customer';
        $users = $this->model('User');

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash('error', 'Enter a valid name and email.');
        } elseif (strlen($pass) < 6) {
            flash('error', 'Password must be at least 6 characters.');
        } elseif ($users->findByEmail($email)) {
            flash('error', 'That email is already registered.');
        } else {
            $users->create($name, $email, trim($_POST['phone'] ?? ''), $pass, $role);
            flash('success', 'User added.');
            $this->redirect('admin/users');
        }
        $this->view('admin/user_form', ['title' => 'Add User']);
    }

    public function userdelete($id = 0) {
        if (!$this->isPost()) $this->redirect('admin/users');
        $this->verifyCsrf();
        $this->model('User')->delete((int)$id);
        flash('success', 'Customer removed.');
        $this->redirect('admin/users');
    }
}
