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
    return Contacts::findById($user_id, 'user_id', $connection);
   }


   public static function findContactByUserAndContact(int $user_id, int $contact_id, mysqli $connection) {
    $sql = "SELECT * FROM contacts WHERE user_id = ? AND contact_id = ?";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $connection->error);
    }
    $stmt->bind_param("ii", $user_id, $contact_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
  
public static function getContactInfo(int $user_id, int $contact_id, mysqli $connection) {
    $sql = "
        SELECT u.id AS contact_id, u.name, u.email
        FROM contacts c
        JOIN users u ON c.contact_id = u.id
        WHERE c.user_id = ? AND c.contact_id = ?
    ";

    $stmt = $connection->prepare($sql);
    if (!$stmt) throw new Exception("Prepare failed: " . $connection->error);

    $stmt->bind_param("ii", $user_id, $contact_id);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

}
?>
