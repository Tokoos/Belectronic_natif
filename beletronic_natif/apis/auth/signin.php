<?php
//Cross Origin Resource Sharing (CORS) - Pre-flight and headers PHP response for the browser will proceed
    
    require_once("../../config/db.php");
    require_once("../../helpers/cors.php");
    require_once("../../helpers/response.php");
    require_once("../../helpers/jwt.php");
    
    

    if(isset($_POST)) {

        $_POST = empty($_POST) ? json_decode(file_get_contents('php://input'), true) : $_POST;

        if (empty($_POST)) {
            response(400, [
                "error"=> true,
                "message"=> "Remplissez tout les champs"
            ]);
        }

        if (!isset($_POST["nom"]) OR empty($_POST["nom"])) {
            response(200, [
                "error"=> true,
                "message"=> "Nom obligatoire"
            ]);
        }

        if (!isset($_POST["email"]) OR empty($_POST["email"])) {
            response(200, [
                "error"=> true,
                "message"=> "Email obligatoire"
            ]);
        }

        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            response(200, [
                "error"=> true,
                "message"=> "Enter une bonne adresse email"
            ]);
        }

        if (!isset($_POST["mot_de_passe"]) OR empty($_POST["mot_de_passe"])) {
            response(200, [
                "error"=> true,
                "message"=> "Mot de passe obligatoire"
            ]);
        }

        if (!isset($_POST["mot_de_passe_2"]) OR empty($_POST["mot_de_passe_2"])) {
            response(200, [
                "error"=> true,
                "message"=> "Mot de passe de confirmation obligatoire"
            ]);
        }

        if($_POST["mot_de_passe_2"] !== $_POST["mot_de_passe"]) {
            response(200, [
                "error"=> true,
                "message"=> "Les mot de passe ne correspondent pas."
            ]);
        }

        $nom = htmlentities($_POST["nom"]);
        $email = htmlentities($_POST["email"]);
        $motDePasse = sha1($_POST["mot_de_passe"]);

        $requete = $conn->prepare("SELECT * FROM users WHERE email=?");
        $requete->execute([$email,]); 
        $user = $requete->fetch();

        if(!empty($user)) response(200, [
            "error"=> true,
            "message"=> "Un utilisateur existe déja avec cette adresse email: " . $email
        ]);
        
        $requete = $conn->prepare("INSERT INTO users(nom,email,mot_de_passe) VALUES (?,?,?)");
        $requete->execute([$nom, $email, $motDePasse]); 
        $user = $requete->rowCount();

        if($user === 0) {
            response(404, [
                "error"=> true,
                "message"=> "Ajout impossible"
            ]);       
        }

        response(201, [
            "error"=> false,
            "message"=> "Ajout réussit"
        ]);
    }