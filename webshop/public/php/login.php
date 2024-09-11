<?php
session_start();

// Funktion zum Überprüfen des Passworts
function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

// Funktion zum Überprüfen der Benutzerdaten
function authenticateUser($username, $password) {
    $user_file = 'users.txt'; // Pfad zur Benutzerdaten-Datei
    if (!file_exists($user_file)) {
        return false;
    }
    
    $users = file($user_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($users as $user_json) {
        $user_data = json_decode($user_json, true);

        if ($user_data['username'] === $username || $user_data['email'] === $username) {
            return verifyPassword($password, $user_data['password']);
        }
    }

    return false;
}

// Überprüfen, ob das Formular abgeschickt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (authenticateUser($username, $password)) {
        // Benutzer erfolgreich authentifiziert
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php'); // Stelle sicher, dass index.php existiert
        exit;
    } else {
        // Fehlgeschlagene Authentifizierung
        echo 'Benutzername oder Passwort ist falsch. <a href="login.html">Zurück</a>';
    }
} else {
    // Falls das Formular nicht über POST gesendet wurde
    echo 'Ungültige Anfrage.';
}
?>
