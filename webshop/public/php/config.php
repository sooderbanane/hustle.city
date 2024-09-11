<?php
$host = 'localhost'; // oder die IP-Adresse des MySQL-Servers
$db = 'my_webshop';
$user = 'root'; // Dein MySQL-Benutzername
$pass = ''; // Dein MySQL-Passwort

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Verbindung fehlgeschlagen: ' . $e->getMessage();
    exit;
}
?>
