<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../models/User.php';

class UserController {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->connect();
            $user = new User($db);

            $user->username = $_POST['username'];
            $user->password = $_POST['password'];
            $user->role = 'user'; // Default role

            if ($user->create()) {
                header('Location: index.php?action=login');
            } else {
                echo "Registration failed.";
            }
        } else {
            // Serve the registration view
            require_once __DIR__ . '/../views/register.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->connect();
            $user = new User($db);

            $stmt = $user->findByUsername($_POST['username']);
            $num = $stmt->rowCount();

            if ($num > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);

                if (password_verify($_POST['password'], $password)) {
                    session_start();
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    header('Location: index.php?action=dashboard');
                } else {
                    echo "Login failed.";
                }
            } else {
                echo "Login failed.";
            }
        } else {
            // Serve the login view
            require_once __DIR__ . '/../views/login.php';
        }
    }

    public function dashboard() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        require_once __DIR__ . '/../views/dashboard.php';
    }
}
