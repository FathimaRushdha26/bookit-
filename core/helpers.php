<?php
function url($path = '')   { return BASE_URL . '/index.php?url=' . ltrim($path, '/'); }
function asset($path)      { return BASE_URL . '/assets/' . ltrim($path, '/'); }
function e($v)             { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function old($k, $d = '')  { return $_POST[$k] ?? $d; }
function is_logged_in()    { return isset($_SESSION['user']); }
function is_admin()        { return is_logged_in() && $_SESSION['user']['role'] === 'admin'; }
function current_user()    { return $_SESSION['user'] ?? null; }

function flash($key = null, $msg = null) {
    if ($msg !== null) { $_SESSION['flash'][$key] = $msg; return null; }
    $all = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $all;
}
function csrf_token() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}
function csrf_field() { return '<input type="hidden" name="csrf" value="' . csrf_token() . '">'; }
