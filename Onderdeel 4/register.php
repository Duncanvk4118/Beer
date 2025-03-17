

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
<a href="login.php">Login</a>
    <form method="POST">
        <!-- Personal Info -->
        <span>First Name</span>
        <input type="text" id="firstName" name="firstName" />
        <br />
        <span>Last Name</span>
        <input type="text" id="lastName" name="lastName" />
        <br />
        <span>Adres</span>
        <input type="text" id="adres" name="adres" />
        <br />

        <!-- Account info -->
        <span>Email</span>
        <input type="email" id="email" name="email" />
        <br />
        <span>Confirm Email</span>
        <input type="email" id="email" name="email" />
        <br />
        <span>Password</span>
        <input type="password" id="password" name="password" />
        <br>
        <button type="submit">Register</button>
    </form>
</body>
</html>