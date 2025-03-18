<?php
session_start();
// Imports
include 'Middleware/cookies.php';
include 'APIs/BeerAPI.php';

if ($_SESSION['user_id']) {
    $beerRows = getBeer($_SESSION['user_id']);
} else {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rating'])) {
    $user_id = $_POST['user_id'];
    $bier_id = $_POST['bier_id'];
    $rating = $_POST['rating'];

    likeBeer($user_id, $bier_id, $rating);

    // Vernieuw de pagina
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.tailwindcss.com/3.3.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/js/tw-elements.umd.min.js"></script>
    <link
            href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap"
            rel="stylesheet" />
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/tw-elements/css/tw-elements.min.css" />
    <link rel="stylesheet" href="Triggers.css" />
    <title>Bier</title>
</head>
<body>
<?php
if (!$_SESSION['user_id']) {
    echo
    '<a href="login.php">Login</a>
    <a href="register.php">Register</a>';
} else {
    echo '<a href="logout.php">Logout</a>';
}
?>

<div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <table
                        class="min-w-full text-center text-sm font-light text-surface dark:text-white">
                    <thead
                            class="border-b border-neutral-200 bg-[#332D2D] font-medium text-white dark:border-white/10">
                    <tr>
                        <th scope="col" class=" px-6 py-4">Bier</th>
                        <th scope="col" class=" px-6 py-4">Brouwer</th>
                        <th scope="col" class=" px-6 py-4">Percentage</th>
                        <th scope="col" class=" px-6 py-4">Gem. Rating</th>
                        <th scope="col" class=" px-6 py-4">Rating</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    echo $beerRows;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
