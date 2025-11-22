<?php
include("../connection/connection.php");


$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$query = $connection->prepare($sql);
$query->execute();

echo "  table users created ";