<?php

try {
    $pdo = new PDO('sqlite:contacts.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
        id TEXT PRIMARY KEY,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        phone TEXT NOT NULL,
        image TEXT NOT NULL
    );");
    return $pdo;
} catch (PDOException $e) {
    return null;
}
