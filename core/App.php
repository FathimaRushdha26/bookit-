<?php
// Router: ?url=controller/method/param1/param2
class App {
    public function __construct() {
        $parts = isset($_GET['url']) ? explode('/', trim($_GET['url'], '/')) : [];

        $name  = !empty($parts[0]) ? ucfirst(strtolower(preg_replace('/[^a-z]/i', '', $parts[0]))) : 'Home';
        $class = $name . 'Controller';
        if (!file_exists(__DIR__ . "/../controllers/$class.php")) $this->notFound();

        $controller = new $class();
        $method = !empty($parts[1]) ? preg_replace('/[^a-zA-Z0-9_]/', '', $parts[1]) : 'index';

        if (!method_exists($controller, $method) || !(new ReflectionMethod($controller, $method))->isPublic()) {
            $this->notFound();
        }
        call_user_func_array([$controller, $method], array_slice($parts, 2));
    }

    private function notFound() {
        http_response_code(404);
        $title = 'Not found';
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/errors/404.php';
        require __DIR__ . '/../views/layout/footer.php';
        exit;
    }
}
