<?php
require_once __DIR__ . '/../src/controllers/UserController.php';

$action = $_GET['action'] ?? 'login';

$controller = new UserController();

switch ($action) {
    case 'login':
        $controller->login();
        break;
    case 'register':
        $controller->register();
        break;
    case 'dashboard':
        $controller->dashboard();
        break;
    default:
        echo "404 Not Found";
        break;
}
