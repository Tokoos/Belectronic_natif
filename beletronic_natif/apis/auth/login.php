<?php
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

        if (!isset($_POST["mot_de_passe"]) OR empty($_POST["mot_de_passe"])) {
            response(200, [
                "error"=> true,
                "message"=> "Mot de passe obligatoire"
            ]);
        }

        $nom = htmlentities($_POST["nom"]);
        $motDePasse = sha1($_POST["mot_de_passe"]);
        
        $requete = $conn->prepare("SELECT * FROM users WHERE nom=? AND mot_de_passe=?");
        $requete->execute([$nom, $motDePasse]); 
        $user = $requete->fetch();

        if(empty($user)) response(404, [
            "error"=> true,
            "message"=> "Compte inexistant"
        ]);

        // setcookie("logged", json_encode($user), time()+70);
        $headers = array('alg'=>'HS256','typ'=>'JWT');
        $payload = array('user_id'=>$user["id"], 'exp'=>(time() + 24 * 60 * 60));

        $token = generate_jwt($headers, $payload);

        // header("Authorization: Bearer ". $token);
        response(200, [
            "error"=> false,
            "message"=> "Connexion réussit",
            "token"=>$token
        ]);
    }