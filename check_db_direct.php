<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=workbrand;port=3306', 'root', 'saurabhsingh'); 
$stmt = $pdo->query('SELECT id, name FROM categories'); 
print_r($stmt->fetchAll(PDO::FETCH_ASSOC)); 
$stmt2 = $pdo->query('SELECT id, title, category_id FROM blogs'); 
print_r($stmt2->fetchAll(PDO::FETCH_ASSOC));
