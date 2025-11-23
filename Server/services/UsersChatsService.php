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
        SELECT uc.chats_id, c.chat_type, u.id AS user_id, u.name, u.email
        FROM users_chats uc
        INNER JOIN chats c ON uc.chats_id = c.id
        INNER JOIN users u ON u.id != ? AND u.id IN (
            SELECT user_id FROM users_chats WHERE chats_id = uc.chats_id
        )
        WHERE uc.user_id = ?
        GROUP BY uc.chats_id, u.id
    ";

    $stmt = $connection->prepare($sql);
    if (!$stmt) throw new Exception("Prepare failed: " . $connection->error);

    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $chats = [];

    while ($row = $result->fetch_assoc()) {
        $chatId = $row['chats_id'];
        if (!isset($chats[$chatId])) {
            $chats[$chatId] = [
                "chat_id" => $chatId,
                "chat_type" => $row['chat_type'],
                "participants" => []
            ];
        }
        $chats[$chatId]["participants"][] = [
            "user_id" => $row['user_id'],
            "name" => $row['name'],
            "email" => $row['email']
        ];
    }

    return array_values($chats);
}

}
?>
