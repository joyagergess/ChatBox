<?php
require_once(__DIR__ . "/Model.php");

class UsersChats extends Model {
    protected static $table = "users_chats";

    private ?int $id;
    private int $chats_id;
    private int $user_id;
    private ?string $last_read_at;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->chats_id = $data['chats_id'] ?? 0;
        $this->user_id = $data['user_id'] ?? 0;
        $this->last_read_at = $data['last_read_at'] ?? null;
    }
}
?>
