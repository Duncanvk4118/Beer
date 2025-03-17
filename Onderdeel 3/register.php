<?php

include './APIs/UserAPI.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['userName'])) {
        if ($_POST['email'] === $_POST['confirm_email']) {
            $result = createUser($_POST['userName'], $_POST['email'], $_POST['password']);
            if ($result) {
                echo "User registered successfully!";
                $user = getUser($_POST['email'], $_POST['password']);
                if ($user) {
                    header("Location: index.php");
                    exit();
                } else {
                    $error_message = "Invalid email or password!";
                }
            } else {
                echo "Email already exists!";
            }
        } else {
            echo "Emails do not match!";
        }
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
    <title>Register</title>
</head>
<body>
<a href="login.php">Login</a>
<form method="POST">
    <span>User Name</span>
    <input type="text" id="userName" name="userName" required />
    <br />

    <span>Email</span>
    <input type="email" id="email" name="email" required />
    <br />
    <span>Confirm Email</span>
    <input type="email" id="confirm_email" name="confirm_email" required />
    <br />
    <span>Password</span>
    <input type="password" id="password" name="password" required />
    <br>
    <button type="submit">Register</button>
</form>
</body>
</html>
