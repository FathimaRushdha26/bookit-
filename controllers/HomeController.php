<?php
class HomeController extends Controller {
    public function index() {
        $services = array_slice($this->model('Service')->all(), 0, 3);
        $this->view('home/index', ['title' => 'Home', 'services' => $services]);
    }
}
