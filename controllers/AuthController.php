<?php
class AuthController extends Controller {
    public function login() {
        if (is_logged_in()) $this->redirect('home');
        if ($this->isPost()) {
            $this->verifyCsrf();
            $u = $this->model('User')->findByEmail(trim($_POST['email'] ?? ''));
            if ($u && password_verify($_POST['password'] ?? '', $u['password'])) {
                session_regenerate_id(true);
                $_SESSION['user'] = ['id' => $u['id'], 'name' => $u['name'], 'role' => $u['role']];
                flash('success', 'Welcome back, ' . $u['name'] . '!');
                $this->redirect($u['role'] === 'admin' ? 'admin/dashboard' : 'booking/mine');
            }
            flash('error', 'Invalid email or password.');
        }
        $this->view('auth/login', ['title' => 'Login']);
    }

    public function register() {
        if (is_logged_in()) $this->redirect('home');
        if ($this->isPost()) {
            $this->verifyCsrf();
            $name  = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $pass  = $_POST['password'] ?? '';
            $users = $this->model('User');

            if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                flash('error', 'Enter a valid name and email.');
            } elseif (strlen($pass) < 6) {
                flash('error', 'Password must be at least 6 characters.');
            } elseif ($pass !== ($_POST['confirm'] ?? '')) {
                flash('error', 'Passwords do not match.');
            } elseif ($users->findByEmail($email)) {
                flash('error', 'That email is already registered.');
            } else {
                $users->create($name, $email, $phone, $pass);
                flash('success', 'Account created. Please login.');
                $this->redirect('auth/login');
            }
        }
        $this->view('auth/register', ['title' => 'Register']);
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        session_start();
        flash('success', 'You have been logged out.');
        $this->redirect('home');
    }
}
