<?php
include("../connection/connection.php");

$sql = "CREATE TABLE IF NOT EXISTS users_chats (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    conversation_id INT(255) NOT NULL,
    user_id INT(255) NOT NULL,
    last_read_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (conversation_id) REFERENCES chats(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

$connection->prepare($sql)->execute();
echo "Table users_chats created.";
