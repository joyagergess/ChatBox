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

    public static function findChatBetweenUsers(int $user1, int $user2, mysqli $connection) {
    $sql = "SELECT c.id FROM chats c
            JOIN users_chats uc1 ON c.id = uc1.chats_id AND uc1.user_id = ?
            JOIN users_chats uc2 ON c.id = uc2.chats_id AND uc2.user_id = ?
            WHERE c.chat_type = 'single'
            LIMIT 1";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $user1, $user2);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

}
?>
