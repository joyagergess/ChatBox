<?php
require_once(__DIR__ . "/Model.php");

class Messages extends Model {
    protected static $table = "messages";

    private ?int $id;
    private int $chats_id;
    private int $sender_id;
    private string $content;
    private ?string $created_at;
    private ?string $delivered_at;
    private ?string $read_at;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->chats_id = $data['chats_id'] ?? 0;
        $this->sender_id = $data['sender_id'] ?? 0;
        $this->content = $data['content'] ?? '';
        $this->created_at = $data['created_at'] ?? null;
        $this->delivered_at = $data['delivered_at'] ?? null;
        $this->read_at = $data['read_at'] ?? null;
    }
}