<?php

$dsn = "mysql:host=localhost;dbname=crud_pdo";

try {
    $pdo = new PDO($dsn, 'root', '');
} catch (PDOException $e) {
    $e->getMessage();
}
?>