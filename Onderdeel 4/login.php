<?php

include './APIs/UserAPI.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $user = getUser($_POST['email'], $_POST['password']);

        if ($user) {
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid email or password!";
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
    <title>Login</title>
</head>
<body>
<a href="register.php">Register</a>

<?php
// Display error message if login fails
if (isset($error_message)) {
    echo "<p style='color:red;'>$error_message</p>";
}
?>

<form method="POST">
    <span>Email</span>
    <input type="email" id="email" name="email" required />
    <br />

    <span>Password</span>
    <input type="password" id="password" name="password" required />
    <br>

    <button type="submit">Login</button>
</form>
</body>
</html>
