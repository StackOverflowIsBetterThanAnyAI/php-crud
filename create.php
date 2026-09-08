<?php

$pdo = require 'db.php';

$uploadsDir = "uploads/";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_NUMBER_INT);


    if ($name && $email && $phone && isset($_FILES["image"])) {
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }

        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $imagePath = $uploadsDir . $imageName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
            $stmt = $pdo->prepare("INSERT INTO contacts (id, name, email, phone, image) VALUES (:id, :name, :email, :phone, :image)");
            $stmt->execute([
                ':id' => uniqid(),
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':image' => $imagePath
            ]);
            echo "Contact added.";
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Invalid input.";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input id="name" type="text" name="name" placeholder="Enter your name" required />
        <label for="email">Email:</label>
        <input id="email" type="email" name="email" placeholder="Enter your email" required />
        <label for="phone">Phone:</label>
        <input id="phone" type="tel" name="phone" placeholder="Enter your phone number" />
        <label for="image">Image:</label>
        <input id="image" type="file" name="image" accept="image/*" />
        <input type="submit" value="Submit" />
    </form>
</body>

</html>