<?php
require_once(__DIR__ . "/Model.php");

class Contacts extends Model {
    protected static $table = "contacts";

    private ?int $id;
    private int $user_id;
    private int $contact_id;
    private ?string $created_at;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->user_id = $data['user_id'] ?? 0;
        $this->contact_id = $data['contact_id'] ?? 0;
        $this->created_at = $data['created_at'] ?? null;
    }
}
?>
