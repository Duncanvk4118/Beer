<?php

// Imports
include 'Middleware/cookies.php';
include 'APIs/BeerAPI.php';



if ($_COOKIE['cookie_id']) {
    $beerRows = getBeer();
} else {
    header("Location: login.php");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bier</title>
</head>
<body>
<a href="login.php">Login</a>
<a href="register.php">Register</a>
<table>
    <thead>
    <tr>
        <td>Naam</td>
        <td></td>
    </tr>
    </thead>
    <tbody>
    <?php
    echo $beerRows;
    ?>
    </tbody>
</table>
</body>
</html>
