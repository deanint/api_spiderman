<?php
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $inputJSON = file_get_contents('php://input'); // récupération du corps de la requete HTTP
    $key = json_decode($inputJSON, TRUE);

    $file_name = "../data.json";
    $spiderman = [];
    if (file_exists($file_name)) {
        // chargement de la liste des champions depuis le fichier
        $spiderman = json_decode(file_get_contents($file_name), true);
    }
    if(array_key_exists(intval($key), $spiderman)){
        array_splice($spiderman, intval($key),1);
        file_put_contents($file_name, json_encode($spiderman));
    }else{
        header($_SERVER["SERVER_PROTOCOL"] . " 400 Cette acteur n'existe pas", true, 400);
        exit;
    }
}else{
    header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed", true, 405);
    exit;
}