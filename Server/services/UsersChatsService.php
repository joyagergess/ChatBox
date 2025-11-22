<?php
require_once(__DIR__ . "/../models/UsersChats.php");

class UsersChatsService {

    public static function create(array $data, mysqli $connection) {
        $uc = new UsersChats($data);
        return $uc->create($data, $connection);
    }

    public static function update(array $data, int $id, mysqli $connection) {
        $uc = new UsersChats([]);
        return $uc->update($data, 'id', $id, $connection);
    }

    public static function delete(int $id, mysqli $connection) {
        $uc = new UsersChats([]);
        return $uc->delete('id', $id, $connection);
    }

    public static function findById(int $id, mysqli $connection) {
        return UsersChats::findById($id, 'id', $connection);
    }

    public static function findAll(mysqli $connection) {
        return UsersChats::findAll($connection);
    }

    public static function findByChatId(int $chat_id, mysqli $connection) {
        return UsersChats::findOneBy("chats_id", $chat_id, $connection);
    }

    public static function findByUserId(int $user_id, mysqli $connection) {
        return UsersChats::findOneBy("user_id", $user_id, $connection);
    }
}
?>
