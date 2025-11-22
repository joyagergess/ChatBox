<?php
include("../connection/connection.php");

$sql = "CREATE TABLE IF NOT EXISTS messages (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    conversation_id INT(255) NOT NULL,
    sender_id INT(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    delivered_at TIMESTAMP NULL DEFAULT NULL,
    read_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (conversation_id) REFERENCES chats(id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
)";

$connection->prepare($sql)->execute();
echo "Table messages created.