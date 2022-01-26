<?php

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $inputJSON = file_get_contents('php://input'); // récupération du corps de la requete HTTP

    $data = json_decode($inputJSON, TRUE);
    $key = $data['key'];

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
    }
    if(array_key_exists($key, $spiderman)){
        $spiderman[$key][ "name"] = $data['name'];
        $spiderman[$key][ "acteur"]= $data['acteur'];
        $spiderman[$key][ "imageSrc"] = $data['imageSrc'];
        $spiderman[$key][ "amis"]= $data['amis'];

        file_put_contents($file_name, json_encode($spiderman));
    }else{
        header($_SERVER["SERVER_PROTOCOL"] . " 400 Cette acteur existe deja", true, 400);
        exit;
    }

}