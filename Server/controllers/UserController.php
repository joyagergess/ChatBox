<?php
require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/../services/UserService.php");
require_once(__DIR__ . "/../services/ResponseService.php");
require_once(__DIR__ . "/../connection/connection.php");

class UserController {

    private function getRequestData() {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }

    public function getUserByID() {
        global $connection;

        if (empty($_GET["id"])) {
            echo ResponseService::response(400, "ID is missing");
            return;
        }

        $id = intval($_GET["id"]);
        $user = UserService::findUserByID($id, $connection);

        echo $user 
            ? ResponseService::response(200, $user)
            : ResponseService::response(404, "User not found");
    }

    public function getUsers() {
        global $connection;

        $users = UserService::findAllUsers($connection);
        echo ResponseService::response(200, $users);
    }

   
    public function createUser() {
    global $connection;
    $data = $this->getRequestData();

    if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
        echo ResponseService::response(400, "Name, email, and password are required");
        return;
    }

    $existingEmail = UserService::findUserByEmail($data['email'], $connection);
    if ($existingEmail) {
        echo ResponseService::response(409, "Email already exists");
        return;
    }

    $existingName = UserService::findUserByName($data['name'], $connection);
    if ($existingName) {
        echo ResponseService::response(409, "Name already exists");
        return;
    }

    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

    $user = UserService::createUser($data, $connection);

    echo $user
        ? ResponseService::response(200, "User created successfully")
        : ResponseService::response(500, "Failed to create user");
      }
   

    public function updateUser() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data["id"])) {
            echo ResponseService::response(400, "User ID is required");
            return;
        }

        $id = intval($data["id"]);

        if (!empty($data["password"])) {
            $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);
        } else {
            unset($data["password"]);
        }

        $updated = UserService::updateUser($data, $id, $connection);

        echo $updated
            ? ResponseService::response(200, "User updated successfully")
            : ResponseService::response(500, "Failed to update user");
    }

    public function deleteUser() {
        global $connection;

        $data = $this->getRequestData();
        if (empty($data["id"])) {
            echo ResponseService::response(400, "User ID is required");
            return;
        }

        $deleted = UserService::deleteUser(intval($data["id"]), $connection);

        echo $deleted
            ? ResponseService::response(200, "User deleted successfully")
            : ResponseService::response(500, "Failed to delete user");
    }
}
