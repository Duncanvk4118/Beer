<?php
include 'Database.php';

// Vraagt de button request op
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['like'])) {
        toggleLike($_POST['bier_id'], 'like');
    } elseif (isset($_POST['dislike'])) {
        toggleLike($_POST['bier_id'], 'dislike');
    }
}

function updateLikeCount($bier_id, $value) {
    $conn = connect();
    $stmt = $conn->prepare("UPDATE beers SET like_count = like_count + :value WHERE id = :bier_id");
    $stmt->bindParam(':value', $value, PDO::PARAM_INT);
    $stmt->bindParam(':bier_id', $bier_id, PDO::PARAM_INT);
    $stmt->execute();
}

function toggleLike($bier_id, $action) {
    $conn = connect();
    $cookie_id = $_COOKIE['cookie_id'] ?? null;

    if (!$cookie_id) {
        return "Geen geldige cookie gevonden.";
    }

    // Controleer of er al een like/dislike is
    $stmt = $conn->prepare("SELECT * FROM likes WHERE bier_id = :bier_id AND cookie_id = :cookie_id");
    $stmt->execute(['bier_id' => $bier_id, 'cookie_id' => $cookie_id]);
    $stmt->fetch(PDO::FETCH_ASSOC);
    $like = $stmt->fetchAll();


    if ($action === "like") {
//        Like controle
        if ($like) {
//            Controlleert of er gedisliket is
            if ($like[0][2] === 1) {
                $stmt = $conn->prepare("UPDATE likes SET disliked = 0 WHERE bier_id = :bier_id AND cookie_id = :cookie_id");
                $stmt->execute(['bier_id' => $bier_id, 'cookie_id' => $cookie_id]);

                updateLikeCount($bier_id, 2);
                return "Dislike verwijderd, like toegevoegd!";
            } else {
                return "Je hebt dit bier al geliket!";
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO likes (bier_id, cookie_id, disliked) VALUES (:bier_id, :cookie_id, 0)");
            $stmt->execute(['bier_id' => $bier_id, 'cookie_id' => $cookie_id]);

            updateLikeCount($bier_id, 1);
            return "Like toegevoegd!";
        }
    } elseif ($action === "dislike") {
//        Like controle
        if ($like) {
//        Controleert of er een like is
            if ($like[0][2] === 0) {

                $stmt = $conn->prepare("UPDATE likes SET disliked = 1 WHERE bier_id = :bier_id AND cookie_id = :cookie_id");
                $stmt->execute(['bier_id' => $bier_id, 'cookie_id' => $cookie_id]);

                updateLikeCount($bier_id, -2);
                return "Like verwijderd, dislike toegevoegd!";
            } else {
                return "Je hebt dit bier al gedisliket!";
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO likes (bier_id, cookie_id, disliked) VALUES (:bier_id, :cookie_id, 1)");
            $stmt->execute(['bier_id' => $bier_id, 'cookie_id' => $cookie_id]);

            updateLikeCount($bier_id, -1);
            return "Dislike toegevoegd!";
        }
    }
}

// Haal alle biertjes op en geef formulier mee
function getBeer() {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM beers");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $results = $stmt->fetchAll();

    $rows = "";
    foreach ($results as $beer) {
        $rows .= "<tr>";
        $rows .= "<td>" . htmlspecialchars($beer['name']) . "</td>";
        $rows .= "<td>";

        // Like-formulier
        $rows .= "<form method='post' style='display:inline;'>";
        $rows .= "<input type='hidden' name='bier_id' value='" . $beer['id'] . "'>";
        $rows .= "<button type='submit' name='like'>Like</button>";
        $rows .= "</form>";

        $rows .= $beer['like_count']; // Weergeeft het aantal likes

        // Dislike-formulier
        $rows .= "<form method='post' style='display:inline;'>";
        $rows .= "<input type='hidden' name='bier_id' value='" . $beer['id'] . "'>";
        $rows .= "<button type='submit' name='dislike'>Dislike</button>";
        $rows .= "</form>";

        $rows .= "</td>";
        $rows .= "</tr>";
    }
    return $rows;
}

