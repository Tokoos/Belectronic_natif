<?php

    function response($status = 200, $data = []) {
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Headers:*");
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Credentials:true');  
        header("Content-Type: application/json");
        http_response_code($status);
        echo json_encode($data);
        exit();
    }