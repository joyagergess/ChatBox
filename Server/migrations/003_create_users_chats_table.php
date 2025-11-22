<?php
include("../connection/connection.php");

$sql = "CREATE TABLE IF NOT EXISTS users_chats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chats_id INT NOT NULL,
    user_id INT NOT NULL,
    last_read_at TIMESTAMP NULL DEFAULT NULL,
    UNIQUE KEY unique_user_chat (chats_id, user_id),
    FOREIGN KEY (chats_id) REFERENCES chats(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

$connection->prepare($sql)->execute();
echo "Table users_chats created.";
