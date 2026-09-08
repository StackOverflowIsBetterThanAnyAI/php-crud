<?php

if (isset($_GET['id'])) {
    $contactsFile = "contacts.json";
    $contacts = file_exists($contactsFile) ? json_decode(file_get_contents($contactsFile), true) : [];

    $contacts = array_filter($contacts, fn($c) => $c['id'] !== $_GET['id']);

    file_put_contents($contactsFile, json_encode(array_values($contacts), JSON_PRETTY_PRINT));

    echo "Contact deleted.";
}
