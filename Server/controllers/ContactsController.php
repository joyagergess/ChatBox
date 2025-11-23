<?php
require_once(__DIR__ . "/../models/Contacts.php");
require_once(__DIR__ . "/../services/ContactsService.php");
require_once(__DIR__ . "/../services/ResponseService.php");
require_once(__DIR__ . "/../connection/connection.php");

class ContactsController {

    private function getRequestData() {
        return json_decode(file_get_contents("php://input"), true) ?? [];
    }

    public function createContact() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['user_id']) || empty($data['contact_id'])) {
            echo ResponseService::response(400, "user_id and contact_id are required");
            return;
        }

        $created = ContactsService::createContact($data, $connection);
        echo $created
            ? ResponseService::response(200, "Contact created successfully")
            : ResponseService::response(500, "Failed to create contact");
    }

    public function updateContact() {
        global $connection;
        $data = $this->getRequestData();

        if (empty($data['id'])) {
            echo ResponseService::response(400, "Contact ID is required");
            return;
        }

        $updated = ContactsService::updateContact($data, intval($data['id']), $connection);
        echo $updated
            ? ResponseService::response(200, "Contact updated successfully")
            : ResponseService::response(500, "Failed to update contact");
    }

    public function deleteContact() {
        global $connection;
        $data = $this->getRequestData();
    
        if (empty($data["user_id"]) || empty($data["contact_id"])) {
            echo ResponseService::response(400, "user_id and contact_id are required");
            return;
        }
    
        $contact = ContactsService::findContactByUserAndContact($data["user_id"], $data["contact_id"], $connection);
        if (!$contact) {
            echo ResponseService::response(404, "Contact not found");
            return;
        }
    
        try {
            $sql = "SELECT uc1.chats_id 
                    FROM users_chats uc1
                    JOIN users_chats uc2 ON uc1.chats_id = uc2.chats_id
                    JOIN chats c ON uc1.chats_id = c.id
                    WHERE uc1.user_id = ? AND uc2.user_id = ? AND c.chat_type = 'single'
                    LIMIT 1";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ii", $data["user_id"], $data["contact_id"]);
            $stmt->execute();
            $chat = $stmt->get_result()->fetch_assoc();
    
            if ($chat) {
                $deleteChatSql = "DELETE FROM chats WHERE id = ?";
                $stmtDel = $connection->prepare($deleteChatSql);
                $stmtDel->bind_param("i", $chat['chats_id']);
                $stmtDel->execute();
            }
    
            $deleted = ContactsService::deleteContact(intval($contact['id']), $connection);
    
            echo $deleted
                ? ResponseService::response(200, "Contact and associated conversation removed successfully")
                : ResponseService::response(500, "Failed to remove contact");
            
        } catch (Exception $e) {
            echo ResponseService::response(500, "Error deleting contact: " . $e->getMessage());
        }
    }
    

    public function getContactByID() {
        global $connection;

        if (empty($_GET['id'])) {
            echo ResponseService::response(400, "Contact ID is required");
            return;
        }

        $contact = ContactsService::findContactByID(intval($_GET['id']), $connection);
        echo $contact
            ? ResponseService::response(200, $contact)
            : ResponseService::response(404, "Contact not found");
    }

    public function getAllContacts() {
        global $connection;
        $contacts = ContactsService::findAllContacts($connection);
        echo ResponseService::response(200, $contacts);
    }

    public function getContactsByUser() {
        global $connection;

        if (empty($_GET['user_id'])) {
            echo ResponseService::response(400, "user_id is required");
            return;
        }

        $contacts = ContactsService::findContactsByUser(intval($_GET['user_id']), $connection);
        echo $contacts
            ? ResponseService::response(200, $contacts)
            : ResponseService::response(404, "No contacts found for this user");
    }

    public function getContactInfo() {
    global $connection;
    $user_id = $_GET['user_id'] ?? null;
    $contact_id = $_GET['contact_id'] ?? null;

    if (!$user_id || !$contact_id) {
        echo ResponseService::response(400, "user_id and contact_id are required");
        return;
    }

    $contact = ContactsService::getContactInfo(intval($user_id), intval($contact_id), $connection);

    echo $contact
        ? ResponseService::response(200, $contact)
        : ResponseService::response(404, "Contact not found");
}

}
?>
