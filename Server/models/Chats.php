<?php
require_once(__DIR__ . "/Model.php");

class Chats extends Model {
    protected static $table = "chats";

    private ?int $id;
    private ?string $created_at;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }
}
?>
