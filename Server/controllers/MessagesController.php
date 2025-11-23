<?php
require_once(__DIR__ . "/../models/Messages.php");
require_once(__DIR__ . "/../services/MessagesService.php");
require_once(__DIR__ . "/../services/ResponseService.php");
require_once(__DIR__ . "/../connection/connection.php");

class MessagesController {

    private function getRequestData() {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }

    public function createMessage() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['chats_id']) || empty($data['sender_id']) || empty($data['content'])) {
            echo ResponseService::response(400, "chats_id, sender_id, and content are required");
            return;
        }

        $created = MessagesService::createMessage($data, $connection);
        echo $created
            ? ResponseService::response(200, "Message created successfully")
            : ResponseService::response(500, "Failed to create message");
    }

    public function updateMessage() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['id'])) {
            echo ResponseService::response(400, "Message ID is required");
            return;
        }

        $updated = MessagesService::updateMessage($data, intval($data['id']), $connection);
        echo $updated
            ? ResponseService::response(200, "Message updated successfully")
            : ResponseService::response(500, "Failed to update message");
    }

    public function deleteMessage() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['id'])) {
            echo ResponseService::response(400, "Message ID is required");
            return;
        }

        $deleted = MessagesService::deleteMessage(intval($data['id']), $connection);
        echo $deleted
            ? ResponseService::response(200, "Message deleted successfully")
            : ResponseService::response(500, "Failed to delete message");
    }

    public function getMessageByID() {
        global $connection;
        if (empty($_GET['id'])) {
            echo ResponseService::response(400, "Message ID is required");
            return;
        }

        $message = MessagesService::findMessageByID(intval($_GET['id']), $connection);
        echo $message
            ? ResponseService::response(200, $message)
            : ResponseService::response(404, "Message not found");
    }

    public function getAllMessages() {
        global $connection;
        $messages = MessagesService::findAllMessages($connection);
        echo ResponseService::response(200, $messages);
    }

    public function getMessagesByChat() {
        global $connection;
        if (empty($_GET['chats_id'])) {
            echo ResponseService::response(400, "chats_id is required");
            return;
        }

        $messages = MessagesService::findMessagesByChat(intval($_GET['chats_id']), $connection);
        echo $messages
            ? ResponseService::response(200, $messages)
            : ResponseService::response(404, "No messages found for this chat");
    }


    public function markChatDelivered() {
        global $connection;
        $data = $this->getRequestData();
        if (empty($data['chats_id']) || empty($data['user_id'])) {
            echo ResponseService::response(400, "chats_id and user_id required");
            return;
        }

        $success = MessagesService::markChatDelivered(intval($data['chats_id']), intval($data['user_id']), $connection);
        echo $success ? ResponseService::response(200, "Messages marked delivered") 
                      : ResponseService::response(500, "Failed to mark delivered");
    }

    public function markChatRead() {
        global $connection;
        $data = $this->getRequestData();
        if (empty($data['chats_id']) || empty($data['user_id'])) {
            echo ResponseService::response(400, "chats_id and user_id required");
            return;
        }

        $success = MessagesService::markChatRead(intval($data['chats_id']), intval($data['user_id']), $connection);
        echo $success ? ResponseService::response(200, "Messages marked read") 
                      : ResponseService::response(500, "Failed to mark read");
    }




}
?>
