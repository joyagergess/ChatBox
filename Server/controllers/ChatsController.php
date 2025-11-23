<?php
require_once(__DIR__ . "/../models/Chats.php");
require_once(__DIR__ . "/../services/ChatsService.php");
require_once(__DIR__ . "/../services/ResponseService.php");
require_once(__DIR__ . "/../connection/connection.php");

class ChatsController {

    private function getRequestData() {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }

    public function getChatByID() {
        global $connection;

        if (empty($_GET["id"])) {
            echo ResponseService::response(400, "Chat ID is missing");
            return;
        }

        $id = intval($_GET["id"]);
        $chat = ChatsService::findChatByID($id, $connection);

        echo $chat 
            ? ResponseService::response(200, $chat)
            : ResponseService::response(404, "Chat not found");
    }

    public function getChats() {
        global $connection;

        $chats = ChatsService::findAllChats($connection);
        echo ResponseService::response(200, $chats);
    }

    public function createChat() {
        global $connection;
        $data = $this->getRequestData();
        $data['chat_type'] = $data['chat_type'] ?? 'single';
    
        $chatId = ChatsService::createChat($data, $connection); // returns the new chat ID
    
        if ($chatId) {
            echo ResponseService::response(200, [
                'message' => 'Chat created successfully',
                'chat_id' => $chatId
            ]);
        } else {
            echo ResponseService::response(500, 'Failed to create chat');
        }
    }
    
    
      public function updateChat() {
            global $connection;
            $data = $this->getRequestData();

        if (empty($data["id"])) {
            echo ResponseService::response(400, "Chat ID is required");
            return;
        }

        $id = intval($data["id"]);
        $updated = ChatsService::updateChat($data, $id, $connection);

        echo $updated
            ? ResponseService::response(200, "Chat updated successfully")
            : ResponseService::response(500, "Failed to update chat");
    }

    public function deleteChat() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data["id"])) {
            echo ResponseService::response(400, "Chat ID is required");
            return;
        }

        $deleted = ChatsService::deleteChat(intval($data["id"]), $connection);

        echo $deleted
            ? ResponseService::response(200, "Chat deleted successfully")
            : ResponseService::response(500, "Failed to delete chat");
    }

    
}
?>
