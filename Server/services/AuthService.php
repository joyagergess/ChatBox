<?php
require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/UserService.php");
require_once(__DIR__ . "/ResponseService.php");

class AuthService {

    public static function signup(array $data, mysqli $connection) {
        if (UserService::findUserByEmail($data['email'], $connection)) {
            echo ResponseService::response(400, "Email already exists");
            exit;
        }

        if (UserService::findUserByName($data['name'], $connection)) {
            echo ResponseService::response(400, "Name already exists");
            exit;
        }

        $user = new User($data);
        $created = $user->create($data, $connection);

        if ($created) {
            echo ResponseService::response(201, "User created successfully");
        } else {
            echo ResponseService::response(500, "Failed to create user");
        }
        exit;
    }

    public static function login(string $email, string $password, mysqli $connection) {
        $user = UserService::findUserByEmail($email, $connection);

        if (!$user) {
            echo ResponseService::response(404, "Email not found");
            exit;
        }

        if (!password_verify($password, $user['password'])) {
            echo ResponseService::response(401, "Incorrect password");
            exit;
        }
        unset($user['password']);

        echo ResponseService::response(200, $user);
        exit;
    }
}
?>
