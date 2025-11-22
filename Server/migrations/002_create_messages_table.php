<?php
include("../connection/connection.php");

$sql = "CREATE TABLE IF NOT EXISTS messages (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    sender_id INT(255) NOT NULL,
    receiver_id INT(255) NOT NULL,
    message_text VARCHAR(255) NOT NULL,
    delivered_at DATETIME NULL,
    read_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
)";

$query = $connection->prepare($sql);
$query->execute();

echo "messages table created";
