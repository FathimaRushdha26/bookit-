<?php
// Base controller - loads models/views, redirects, access control
abstract class Controller {
    protected function model($name) { return new $name(); }

    protected function view($view, $data = []) {
        extract($data);
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . "/../views/$view.php";
        require __DIR__ . '/../views/layout/footer.php';
    }

    protected function redirect($path) { header('Location: ' . url($path)); exit; }
    protected function isPost()        { return $_SERVER['REQUEST_METHOD'] === 'POST'; }

    protected function verifyCsrf() {
        if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
            http_response_code(419);
            die('Invalid request token. Go back and try again.');
        }
    }
    protected function requireLogin() {
        if (!is_logged_in()) { flash('error', 'Please login first.'); $this->redirect('auth/login'); }
    }
    protected function requireAdmin() {
        $this->requireLogin();
        if (!is_admin()) { flash('error', 'Admin access only.'); $this->redirect('home'); }
    }
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data); exit;
    }
}
