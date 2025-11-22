<?php
require_once(__DIR__ . "/../models/User.php");

class UserService {

    public static function createUser(array $data, mysqli $connection) {
        $user = new User($data);
        return $user->create($data, $connection);
    }

    public static function updateUser(array $data, int $id, mysqli $connection) {
        $user = new User([]);
        return $user->update($data, 'id', $id, $connection);
    }

    public static function deleteUser(int $id, mysqli $connection) {
        $user = new User([]);
        return $user->delete('id', $id, $connection);
    }

    public static function findUserByID(int $id, mysqli $connection) {
        return User::findById($id, 'id', $connection);
    }

    public static function findAllUsers(mysqli $connection) {
        return User::findAll($connection);
    }

    public static function findUserByEmail(string $email, mysqli $connection) {
        return User::findOneBy("email", $email, $connection);
    }

    public static function findUserByName(string $name, mysqli $connection) {
        return User::findOneBy("name", $name, $connection);
    }
}
