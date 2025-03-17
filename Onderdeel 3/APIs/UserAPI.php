<?php
include 'Database.php';
include(__DIR__ . '/../Middleware/cookies.php');


function getUser($email, $password)
{
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {

            setCookies($user);
            return $user;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function createUser($userName, $email, $password) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        return false;
    } else {
        $stmt = $conn->prepare("INSERT INTO users (email, password, name) VALUES (:email, :password, :userName)");
        $stmt->execute(['email' => $email, 'password' => $hashedPassword, 'userName' => $userName]);

        return true;
    }
}

function logoutUser() {
    setcookie("cookie_id", "", time() - 3600, "/");
    unset($_COOKIE["cookie_id"]);
    header("Location: login.php");
}
