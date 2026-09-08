<?php

$pdo = require 'db.php';

if (isset($_GET['id'])) {

    $contactId = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = :id");
    $stmt->execute([':id' => $contactId]);

    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "Contact deleted.";
}
