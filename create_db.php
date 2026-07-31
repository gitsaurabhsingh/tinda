<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', 'saurabhsingh');
    $pdo->exec('CREATE DATABASE IF NOT EXISTS workbrand');
    echo 'Database created successfully.';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
