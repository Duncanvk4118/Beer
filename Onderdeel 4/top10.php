<?php
include 'APIs/Database.php';

$conn = connect();

$query_beers = "SELECT * FROM likes ORDER BY rating DESC LIMIT 10";
$stmt_beers = $conn->prepare($query_beers);
$stmt_beers->execute();
$results_beers = $stmt_beers->fetchAll(PDO::FETCH_ASSOC);

$query_brewers = "
SELECT b.brewer, COALESCE(AVG(l.rating), 0) as average_rating
FROM beers b
LEFT JOIN likes l ON l.bier_id = b.id
GROUP BY b.brewer
ORDER BY average_rating DESC
LIMIT 10
";

$stmt_brewers = $conn->prepare($query_brewers);
$stmt_brewers->execute();
$results_brewers = $stmt_brewers->fetchAll(PDO::FETCH_ASSOC);

$query_types = "
    SELECT b.type, COALESCE(AVG(l.rating), 0) as average_rating
FROM beers b
LEFT JOIN likes l ON l.bier_id = b.id
GROUP BY b.type
ORDER BY average_rating DESC
LIMIT 10

";
$stmt_types = $conn->prepare($query_types);
$stmt_types->execute();
$results_types = $stmt_types->fetchAll(PDO::FETCH_ASSOC);

$query_beers_most_rated = "
    SELECT b.id, b.name, COUNT(l.rating) as rating_count
    FROM likes l
    JOIN beers b ON l.bier_id = b.id
    GROUP BY b.id, b.name
    ORDER BY rating_count DESC
    LIMIT 10
";
$stmt_beers_most_rated = $conn->prepare($query_beers_most_rated);
$stmt_beers_most_rated->execute();
$results_beers_most_rated = $stmt_beers_most_rated->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Top Ratings</title>
</head>
<body>
    <a class="p-2" href="index.php">Back to Home</a>
    <div class="flex w-[90%] mx-auto container">
        <div class="w-1/8 mr-10">
            <h1 class="font-bold">Top 10 Beers</h1>
            <?php
            if (count($results_beers) > 0) {
                echo "<ul>";
                foreach ($results_beers as $row) {
                    echo "<li>ID: " . $row["bier_id"] . " - Rating: " . $row["rating"] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No results found.</p>";
            }
            ?>
        </div>
        <div class="w-1/4 mr-10">
            <h1 class="font-bold">Top 10 Brewers</h1>
            <?php
            if (count($results_brewers) > 0) {
                echo "<ul>";
                foreach ($results_brewers as $row) {
                    echo "<li>Brewer: " . $row["brewer"] . " - Average Rating: " . $row["average_rating"] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No results found.</p>";
            }
            ?>
        </div>
        <div class="w-1/4 mr-10">
            <h1 class="font-bold">Top 10 Types</h1>
            <?php
            if (count($results_types) > 0) {
                echo "<ul>";
                foreach ($results_types as $row) {
                    echo "<li>Type: " . $row["type"] . " - Average Rating: " . $row["average_rating"] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No results found.</p>";
            }
            ?>
        </div>
        <div class="w-1/4 mr-10">
            <h1 class="font-bold">Top 10 Beers by Number of Ratings</h1>
            <?php
            if (count($results_beers_most_rated) > 0) {
                echo "<ul>";
                foreach ($results_beers_most_rated as $row) {
                    echo "<li>ID: " . $row["id"] . " - Name: " . $row["name"] . " - Ratings: " . $row["rating_count"] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No results found.</p>";
            }
            ?>
        </div>
</body>
</html>