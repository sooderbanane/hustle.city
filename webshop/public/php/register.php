<?php
require 'vendor/autoload.php'; // Composer autoload

// Verbindung zur MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->mein_webshop->users;

// Überprüfen, ob das Formular abgeschickt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Überprüfen, ob der Benutzername oder die E-Mail bereits existiert
    $existingUser = $collection->findOne(['$or' => [['username' => $username], ['email' => $email]]]);

    if ($existingUser) {
        echo 'Benutzername oder E-Mail existiert bereits. <a href="register.html">Zurück</a>';
    } else {
        // Daten in die MongoDB einfügen
        $insertResult = $collection->insertOne([
            'username' => $username,
            'email' => $email,
            'password' => $password
        ]);

        if ($insertResult->getInsertedCount() === 1) {
            echo 'Registrierung erfolgreich!';
        } else {
            echo 'Fehler bei der Registrierung. <a href="register.html">Zurück</a>';
        }
    }
} else {
    echo 'Ungültige Anfrage.';
}
?>
