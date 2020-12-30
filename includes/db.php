<?php

$dsn = "mysql:host=localhost;dbname=tasklist_PDO";

try {
    $pdo = new PDO($dsn, 'root', '');
} catch (PDOException $e) {
    $e->getMessage();
}
?>