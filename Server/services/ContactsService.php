<?php
require_once(__DIR__ . "/../models/Contacts.php");

class ContactsService {

    public static function createContact(array $data, mysqli $connection) {
        $contact = new Contacts($data);
        return $contact->create($data, $connection);
    }

    public static function updateContact(array $data, int $id, mysqli $connection) {
        $contact = new Contacts([]);
        return $contact->update($data, 'id', $id, $connection);
    }

    public static function deleteContact(int $id, mysqli $connection) {
        $contact = new Contacts([]);
        return $contact->delete('id', $id, $connection);
    }

    public static function findContactByID(int $id, mysqli $connection) {
        return Contacts::findById($id, 'id', $connection);
    }

    public static function findAllContacts(mysqli $connection) {
        return Contacts::findAll($connection);
    }

    public static function findContactsByUser(int $user_id, mysqli $connection) {
        return Contacts::findOneBy('user_id', $user_id, $connection);
    }
}
?>
