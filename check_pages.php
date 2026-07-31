<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=workbrand;port=3306', 'root', 'saurabhsingh');
$stmt = $pdo->query('SHOW COLUMNS FROM pages');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
