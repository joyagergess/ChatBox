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
        $sql = "SELECT * FROM messages WHERE chats_id = ? ORDER BY created_at ASC";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $chats_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
        }
        return $rows;  
      }

    public static function markChatDelivered(int $chats_id, int $user_id, mysqli $connection) {
        $sql = "UPDATE messages 
                SET delivered_at = NOW() 
                WHERE chats_id = ? 
                  AND sender_id != ? 
                  AND delivered_at IS NULL";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii", $chats_id, $user_id);
        return $stmt->execute();
    }

    public static function markChatRead(int $chats_id, int $user_id, mysqli $connection) {
        $sql = "UPDATE messages 
                SET read_at = NOW() 
                WHERE chats_id = ? 
                  AND sender_id != ? 
                  AND read_at IS NULL";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii", $chats_id, $user_id);
        return $stmt->execute();
    }

}

?>
