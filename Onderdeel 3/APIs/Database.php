<?php

function connect() {
    $servername = 'localhost';
    $dataBase = 'BierLijst';
    $username = "root";
    $password = "root";

    $conn = null;
    try {

        $conn = new PDO("mysql:host=$servername;dbname=$dataBase", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//              echo "Connected";
    } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          die();
    }
    return $conn;
}