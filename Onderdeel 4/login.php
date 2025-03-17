<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        getUser($_POST['email'], $_POST['password']);
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<a href="register.php">Register</a>
    <form method="POST">
        <span>Email</span>
        <input type="email" id="email" name="email" />
        <br />
        <span>Password</span>
        <input type="password" id="password" name="password" />
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>