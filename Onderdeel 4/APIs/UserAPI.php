<?php
include 'Database.php';
include '../Middleware/cookies.php';

function getUser($email, $password)
{
    $decodedPassword = base64_encode($password);

    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND decodedPassword = :decodedPassword");
    $stmt->execute(['email' => $email, 'decodedPassword' => $decodedPassword]);
    $stmt->fetch(PDO::FETCH_ASSOC);
    $user = $stmt->fetchAll();
    if ($user) {
        setCookies($user[0][0]);
        return $user[0][0];
    } else {
        return false;
    }
}

function createUser($userName, $email, $password) {
    $decodedPassword = base64_encode($password);

    $conn = connect();

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND decodedPassword = :decodedPassword");
    $stmt->execute(['email' => $email, 'decodedPassword' => $decodedPassword]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        return false;
    } else {
        $stmt = $conn->prepare("INSERT INTO users (email, decodedPassword, name) VALUES (:email, :decodedPassword AND name = :userName)");
        $stmt->execute(['email' => $email, 'decodedPassword' => $decodedPassword, 'userName' => $userName]);

        return true;
    }

}