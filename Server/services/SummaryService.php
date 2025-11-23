<?php
require_once(__DIR__ . "/AiService.php");

class SummaryService {

    public static function generateCatchUpSummary(int $chatId, int $userId, mysqli $connection): ?array {
        $sql = "SELECT sender_id, content, created_at 
                FROM messages 
                WHERE chats_id = ? AND sender_id != ? AND read_at IS NULL
                ORDER BY created_at ASC";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii", $chatId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        $stmt->close();

        $unreadCount = count($messages);

        $response = [
            "unread_count" => $unreadCount
        ];

        if ($unreadCount === 0) {
            $response["ai_summary"] = "";
            return $response;
        }

        $text = "";
        foreach ($messages as $msg) {
            $time = date("Y-m-d H:i", strtotime($msg['created_at']));
            $text .= "[$time] User {$msg['sender_id']}: {$msg['content']}\n";
        }

        $aiSummary = callAI('catchup_summary', $text);
        if ($aiSummary) {
            $response['ai_summary'] = $aiSummary['summary'] ?? null;
        }

        return $response;
    }
}
