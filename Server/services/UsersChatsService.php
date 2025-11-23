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
    public static function getChatsByUser(int $user_id, mysqli $connection) {
    $sql = "
        SELECT uc.chats_id, GROUP_CONCAT(u.name SEPARATOR ', ') AS user_names
        FROM users_chats uc
        JOIN users u ON uc.user_id = u.id
        WHERE uc.chats_id IN (
            SELECT chats_id FROM users_chats WHERE user_id = ?
        )
        AND u.id != ?
        GROUP BY uc.chats_id
    ";

    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $connection->error);
    }

    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

}
    
        
    ?>
    