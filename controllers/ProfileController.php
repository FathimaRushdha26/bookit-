<?php
class ProfileController extends Controller {
    public function __construct() { $this->requireLogin(); }

    public function index() {
        $user = $this->model('User')->findById(current_user()['id']);
        $this->view('profile/index', ['title' => 'My Profile', 'user' => $user]);
    }

    public function update() {
        if (!$this->isPost()) $this->redirect('profile');
        $this->verifyCsrf();
        $name = trim($_POST['name'] ?? '');
        if ($name === '') { flash('error', 'Name is required.'); $this->redirect('profile'); }
        $this->model('User')->updateProfile(current_user()['id'], $name, trim($_POST['phone'] ?? ''));
        $_SESSION['user']['name'] = $name;
        flash('success', 'Profile updated.');
        $this->redirect('profile');
    }

    public function password() {
        if (!$this->isPost()) $this->redirect('profile');
        $this->verifyCsrf();
        $users = $this->model('User');
        $u = $users->findById(current_user()['id']);
        $new = $_POST['new_password'] ?? '';
        if (!password_verify($_POST['current_password'] ?? '', $u['password'])) {
            flash('error', 'Current password is incorrect.');
        } elseif (strlen($new) < 6 || $new !== ($_POST['confirm'] ?? '')) {
            flash('error', 'New password must be 6+ characters and match confirmation.');
        } else {
            $users->updatePassword($u['id'], $new);
            flash('success', 'Password changed.');
        }
        $this->redirect('profile');
    }
}
