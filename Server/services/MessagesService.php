<?php
require_once(__DIR__ . "/../models/Messages.php");

class MessagesService {

    public static function createMessage(array $data, mysqli $connection) {
        $message = new Messages($data);
        return $message->create($data, $connection);
    }

    public static function updateMessage(array $data, int $id, mysqli $connection) {
        $message = new Messages([]);
        return $message->update($data, 'id', $id, $connection);
    }

    public static function deleteMessage(int $id, mysqli $connection) {
        $message = new Messages([]);
        return $message->delete('id', $id, $connection);
    }

    public static function findMessageByID(int $id, mysqli $connection) {
        return Messages::findById($id, 'id', $connection);
    }

    public static function findAllMessages(mysqli $connection) {
        return Messages::findAll($connection);
    }

    public static function findMessagesByChat(int $chats_id, mysqli $connection) {
        return Messages::findOneBy('chats_id', $chats_id, $connection);
    }
}
?>
