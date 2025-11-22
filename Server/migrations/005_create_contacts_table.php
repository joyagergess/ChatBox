<?php
include("../connection/connection.php");

$sql = "CREATE TABLE IF NOT EXISTS contacts (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(255) NOT NULL,
    contact_id INT(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_contact (user_id, contact_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (contact_id) REFERENCES users(id) ON DELETE CASCADE
)";

$connection->prepare($sql)->execute();
echo "Table contacts created.";
