<?php
include 'Database.php';

function likeBeer($user_id, $bier_id, $rating) {
    $conn = connect();

    // Check of de like al bestaat
    $stmt = $conn->prepare("SELECT * FROM likes WHERE bier_id = :bier_id AND user_id = :user_id");
    $stmt->execute(['bier_id' => $bier_id, 'user_id' => $user_id]);
    $liked = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($liked) > 0) {
        // Update like
        $stmt = $conn->prepare("UPDATE likes SET rating = :rating WHERE bier_id = :bier_id AND user_id = :user_id");
        $success = $stmt->execute(['rating' => $rating, 'bier_id' => $bier_id, 'user_id' => $user_id]);

        if ($success) {
            echo 'Success';
            return true;
        } else {
            echo 'Failed to insert';
            return false;
        }
    }

    // Create like
    $stmt = $conn->prepare("INSERT INTO likes (bier_id, user_id, rating) VALUES (:bier_id, :user_id, :rating)");
    $success = $stmt->execute(['bier_id' => $bier_id, 'user_id' => $user_id, 'rating' => $rating]);

    if ($success) {
        echo 'Success';
        return true;
    } else {
        echo 'Failed to insert';
        return false;
    }
}

function getBeer($user_id) {
    $conn = connect();

    // Haal de likes van de gebruiker op
    $stmt = $conn->prepare("SELECT bier_id, rating FROM likes WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $userLikes = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // Haalt bier_id => rating op

    // Haal alle bieren op
    $stmt = $conn->prepare("SELECT * FROM beers");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $results = $stmt->fetchAll();

    $rows = "";
    foreach ($results as $beer) {
        $beer_id = $beer['id'];
        $rows .= '<tr class="border-b border-neutral-200 dark:border-white/10">';
        $rows .= ' <td class="whitespace-nowrap px-6 py-4 font-medium">' . htmlspecialchars($beer['name']) . '</td>';
        $rows .= ' <td class="whitespace-nowrap px-6 py-4">' . htmlspecialchars($beer['brewer']) . '</td>';
        $rows .= "<td class='whitespace-nowrap px-6 py-4'>" . ($beer['perc'] * 100) .  "%</td>";
        $rows .= ' <td class="whitespace-nowrap px-6 py-4">' . getAvgLikes($beer_id) . " / 5". '</td>';
        $rows .= '<td class="whitespace-nowrap px-6 py-4">';
        $rows .= "<form method='post' style='display:inline;'>";
        $rows .= "<input type='hidden' name='bier_id' value='" . $beer_id . "'>";
        $rows .= "<input type='hidden' name='user_id' value='" . $user_id . "'>";

        for ($i = 1; $i <= 5; $i++) {
            $isLinked = (isset($userLikes[$beer_id]) && $userLikes[$beer_id] == $i) ? "Linked" : "";
            $rows .= '<button
        type="submit"
        name="rating"
        value="' . $i . '"
        id="' . $isLinked . '"
        data-twe-ripple-init
        data-twe-ripple-color="light"
        class="inline-block rounded-full bg-gray-400 p-2 uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-amber-500 focus:bg-amber-500 focus:outline-none focus:ring-0 active:bg-amber-600 motion-reduce:transition-none dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong mx-1">
        <svg class="flex items-center justify-center" xmlns="http://www.w3.org/2000/svg" fill="white" width="20" height="20" viewBox="0 0 24 24">
            <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/>
        </svg>
    </button>';
        }

        $rows .= "</form>";


        $rows .= "</td>";
        $rows .= "</tr>";
    }
    return $rows;
}


function getAvgLikes($bier_id) {
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM likes WHERE bier_id = :bier_id");
    $stmt->execute(['bier_id' => $bier_id]);
    $likes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $uniqueLikes = count($likes);
    $totalLikes = 0;

    // Loop through all the rows
    foreach ($likes as $like) {
        $totalLikes += $like['rating'];
    }

    if ($uniqueLikes > 0) {
        $avgRating = $totalLikes / $uniqueLikes;
    } else {
        $avgRating = 0;
    }

    return round($avgRating, 1);
}
