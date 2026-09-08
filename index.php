<?php
$pdo = require 'db.php';
$contacts = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM contacts");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
</head>

<body>
    <header>
        <nav>
            <a href="/about.php">About</a>
        </nav>
    </header>
    <main>
        <h1>Home</h1>
        <a href="create.php">Create new contact</a>
        <ul>
            <?php
            foreach ($contacts as $contact) {
                echo "
                    <li>
                        <img src='{$contact['image']}' alt='Contact Image' width='256' height='144' />
                        <a href='delete.php?id={$contact['id']}'>Delete</a>
                        <p>Name: {$contact['name']}</p>
                    </li>
                ";
            }
            ?>
        </ul>
    </main>

    <?php require 'footer.php'; ?>
</body>

</html>