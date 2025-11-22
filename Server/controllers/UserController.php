<?php
require_once(__DIR__ . "/../models/user.php");
require_once(__DIR__ . "/../connection/connection.php");
require_once(__DIR__ . "/../services/UserService.php");

class UserController {


    private function getRequestData() {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }


    public function getUserByID() {
        global $connection;

        try {
            if (empty($_GET["id"])) {
                echo ResponseService::response(400, "ID is missing");
                return;
            }
            $id = intval($_GET["id"]);
            $user = UserService::findUserByID($id, $connection);

            if ($user) {
                echo ResponseService::response(200, $user);
            } else {
                echo ResponseService::response(404, "User not found");
            }
        } catch (Exception $e) {
            echo ResponseService::response(500, "Server Error: " . $e->getMessage());
        }
    }

    public function getUsers() {
        global $connection;

        try {
            $users = UserService::findAllUsers($connection);
            echo ResponseService::response(200, $users);

        } catch (Exception $e) {
            echo ResponseService::response(500, "Server Error: " . $e->getMessage());
        }
    }

    public function createUser() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            echo ResponseService::response(400, "Name, email, and password are required");
            return;
        }
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['role'] = $data['role'] ?? 'user';

        $user = UserService::createUser($data, $connection);

        if ($user) {
            echo ResponseService::response(200, "User created successfully");
        } else {
            echo ResponseService::response(500, "Failed to create user");
        }
    }

    public function updateUser() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data["id"])) {
            echo ResponseService::response(400, "User ID is required");
            return;
        }
        $id = intval($data["id"]);

        if (empty($data["name"]) || empty($data["email"])) {
            echo ResponseService::response(400, "Name and email are required");
            return;
        }
        if (!empty($data["password"])) {
            $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);
        } else {
            unset($data["password"]);
        }
        $updated = UserService::updateUser($data, $id, $connection);

        if ($updated) {
            echo ResponseService::response(200, "User updated successfully");
        } else {
            echo ResponseService::response(500, "Failed to update user");
        }
    }

 
    public function deleteUser() {
        global $connection;

        $data = $this->getRequestData();

        if (empty($data["id"])) {
            echo ResponseService::response(400, "User ID is required");
            return;
        }

        $id = intval($data["id"]);

        $deleted = UserService::deleteUser($id, $connection);

        if ($deleted) {
            echo ResponseService::response(200, "User deleted successfully");
        } else {
            echo ResponseService::response(500, "Failed to delete user");
        }
    }



}
?>
