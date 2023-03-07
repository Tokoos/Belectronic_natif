<?php

if (isset($_SERVER['HTTP_ORIGIN']) || $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    $http_origin = $_SERVER['HTTP_ORIGIN'];
    
    if (in_array($http_origin, ["http://localhost:8080", "http://127.0.0.1:8080"])) {
        header("Access-Control-Allow-Origin: " . $http_origin);
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS");
        header("Access-Control-Allow-Headers: Authorization,Origin,X-Requested-With,Content-Type,Accept,Referrer");
    }
        
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        exit;
    }
}