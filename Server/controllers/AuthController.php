<?php
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/../services/AuthService.php");
require_once(__DIR__ . "/../services/ResponseService.php");

class AuthController {

    private function getRequestData() {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }

    public function signup() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            echo ResponseService::response(400, "Name, email, and password are required");
            return;
        }
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        AuthService::signup($data, $connection);
    }

    public function login() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['email']) || empty($data['password'])) {
            echo ResponseService::response(400, "Email and password required");
            return;
        }

        AuthService::login($data['email'], $data['password'], $connection);
    }
}
?>
