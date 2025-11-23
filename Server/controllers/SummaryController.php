<?php
require_once(__DIR__ . "/../services/SummaryService.php");
require_once(__DIR__ . "/../services/ResponseService.php");
require_once(__DIR__ . "/../connection/connection.php");

class SummaryController {

    public static function getCatchUpSummary() {
        global $connection;

        $data = json_decode(file_get_contents("php://input"), true) ?? [];
        $chatId = intval($data['chats_id'] ?? 0);
        $userId = intval($data['user_id'] ?? 0);

        if (!$chatId || !$userId) {
            echo ResponseService::response(400, "chat_id and user_id are required");
            return;
        }

        $summary = SummaryService::generateCatchUpSummary($chatId, $userId, $connection);

        if ($summary) {
            echo ResponseService::response(200, $summary);
        } else {
            echo ResponseService::response(200, ["message" => "No AI summary available (less than 4 unread messages)"]);
        }
    }
}