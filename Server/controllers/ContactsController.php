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

        if (empty($data['id'])) {
            echo ResponseService::response(400, "Contact ID is required");
            return;
        }

        $deleted = ContactsService::deleteContact(intval($data['id']), $connection);
        echo $deleted
            ? ResponseService::response(200, "Contact deleted successfully")
            : ResponseService::response(500, "Failed to delete contact");
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
}
?>
