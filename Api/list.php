<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header("Content-type: application/json");
    $file_name = "../data.json";
    $data = [];
    if (file_exists($file_name)) {
        // chargement de la liste des champions depuis le fichier
        $data = json_decode(file_get_contents($file_name), true);
    }

    $json_text = json_encode($data);
    echo $json_text;
}