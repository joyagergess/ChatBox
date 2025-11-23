<?php
require_once(__DIR__ . "/../models/Chats.php");

class ChatsService {

   public static function createChat(array $data, mysqli $connection) {
    $chat = new Chats($data);
    $created = $chat->create($data, $connection);

    if ($created) {
        return $connection->insert_id; 
    }
    return false;
}


    public static function updateChat(array $data, int $id, mysqli $connection) {
        $chat = new Chats([]);
        return $chat->update($data, 'id', $id, $connection);
    }

    public static function deleteChat(int $id, mysqli $connection) {
        $chat = new Chats([]);
        return $chat->delete('id', $id, $connection);
    }

    public static function findChatByID(int $id, mysqli $connection) {
        return Chats::findById($id, 'id', $connection);
    }

    public static function findAllChats(mysqli $connection) {
        return Chats::findAll($connection);
    }
}
?>
