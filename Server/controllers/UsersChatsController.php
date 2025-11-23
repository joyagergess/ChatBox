<?php
require_once(__DIR__ . "/../models/UsersChats.php");
require_once(__DIR__ . "/../services/UsersChatsService.php");
require_once(__DIR__ . "/../services/ResponseService.php");
require_once(__DIR__ . "/../connection/connection.php");

class UsersChatsController {

    private function getRequestData() {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }

    public function getUsersChats() {
        global $connection;
        $chats = UsersChatsService::findAll($connection);
        echo ResponseService::response(200, $chats);
    }

    public function getUsersChatById() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['id'])) {
            echo ResponseService::response(400, "ID is required");
            return;
        }

        $chat = UsersChatsService::findById(intval($data['id']), $connection);

        echo $chat
            ? ResponseService::response(200, $chat)
            : ResponseService::response(404, "Chat not found");
    }

    public function createUsersChat() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['chats_id']) || empty($data['user_id'])) {
            echo ResponseService::response(400, "chats_id and user_id are required");
            return;
        }

        $created = UsersChatsService::create($data, $connection);

        echo $created
            ? ResponseService::response(200, "UsersChats created successfully")
            : ResponseService::response(500, "Failed to create UsersChats");
    }

    public function updateUsersChat() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['id'])) {
            echo ResponseService::response(400, "ID is required");
            return;
        }

        $updated = UsersChatsService::update($data, intval($data['id']), $connection);

        echo $updated
            ? ResponseService::response(200, "UsersChats updated successfully")
            : ResponseService::response(500, "Failed to update UsersChats");
    }

    public function deleteUsersChat() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['id'])) {
            echo ResponseService::response(400, "ID is required");
            return;
        }

        $deleted = UsersChatsService::delete(intval($data['id']), $connection);

        echo $deleted
            ? ResponseService::response(200, "UsersChats deleted successfully")
            : ResponseService::response(500, "Failed to delete UsersChats");
    }
   
    

    public function getChatsByUser() {
    global $connection;

    if (empty($_GET['user_id'])) {
        echo ResponseService::response(400, "user_id is required");
        return;
    }

    try {
        $chats = UsersChatsService::getChatsByUser(intval($_GET['user_id']), $connection);
        echo ResponseService::response(200, $chats);
    } catch (Exception $e) {
        echo ResponseService::response(500, "Failed to fetch chats: " . $e->getMessage());
    }
}

}
?>
