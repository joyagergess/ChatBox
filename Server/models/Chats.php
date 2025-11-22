<?php
require_once(__DIR__ . "/Model.php");

class Chats extends Model {
    protected static $table = "chats";

    private ?int $id;
    private string $chat_type;
    private ?string $created_at;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->chat_type = $data['chat_type'] ?? 'single';
        $this->created_at = $data['created_at'] ?? null;
    }
}
?>
