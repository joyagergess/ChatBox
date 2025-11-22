<?php
include("../connection/connection.php");

$sql = "CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chats_id INT NOT NULL,
    sender_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    delivered_at TIMESTAMP NULL DEFAULT NULL,
    read_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (chats_id) REFERENCES chats(id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
)";

$connection->prepare($sql)->execute();
echo "Table messages created.";