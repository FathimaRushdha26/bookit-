<?php
class ServiceController extends Controller {
    public function index() {
        $m = $this->model('Service');
        $search = trim($_GET['q'] ?? '');
        $cat    = trim($_GET['category'] ?? '');
        $this->view('services/index', [
            'title' => 'Services',
            'services' => $m->all($search, $cat),
            'categories' => $m->categories(),
            'search' => $search, 'category' => $cat,
        ]);
    }

    public function show($id = 0) {
        $s = $this->model('Service')->find((int)$id);
        if (!$s || !$s['is_active']) { flash('error', 'Service not found.'); $this->redirect('service'); }
        $this->view('services/show', ['title' => $s['name'], 'service' => $s]);
    }
}
