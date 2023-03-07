<?php
    require_once("../../helpers/response.php");

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=beletronic", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        response(500,"Connection failed: " . $e->getMessage());
    }
