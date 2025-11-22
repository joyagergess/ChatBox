<?php
include("../connection/connection.php");

$sql = "CREATE TABLE IF NOT EXISTS chats (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    chat_type ENUM('single', 'group') NOT NULL DEFAULT 'single',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$connection->prepare($sql)->execute();
echo "Table chats created.";
