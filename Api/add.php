<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputJSON = file_get_contents('php://input'); // récupération du corps de la requete HTTP
    $data = json_decode($inputJSON, TRUE);

    $file_name = "../data.json";
    $spiderman = [];
    if (file_exists($file_name)) {
        // chargement de la liste des champions depuis le fichier
        $spiderman = json_decode(file_get_contents($file_name), true);
    }

    $doublon = array_search($data['acteur'], array_column($spiderman, 'acteur'));

    if($doublon !== false){
        header($_SERVER["SERVER_PROTOCOL"] . " 409 Cette acteur existe deja", true, 409);
        exit;
    }else{
        if($data['name'] && $data['acteur'] &&  $data['imageSrc'] && $data['amis']){
            array_push($spiderman, $data);
            file_put_contents($file_name, json_encode($spiderman));
        }else{
            header($_SERVER["SERVER_PROTOCOL"] . " 400 des informations sont manquantes", true, 400);
            exit;
        }
    }
}else{
    header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed", true, 405);
    exit;
}