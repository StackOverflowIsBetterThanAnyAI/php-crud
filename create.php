<?php

$uploadsDir = "uploads/";
$contactsFile = "contacts.json";

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
            $contacts = file_exists($contactsFile) ? json_decode(file_get_contents($contactsFile), true) : [];
            $contacts[] = [
                "id" => uniqid(),
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "image" => $imagePath
            ];
            file_put_contents($contactsFile, json_encode($contacts, JSON_PRETTY_PRINT));
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