<?php

// Vérification de l'existence du fichier CSV
if (isset($_GET['file']) && !empty($_GET['file'])) {
    // On lit le fichier CSV présent dans le dossier uploads
    $file = __DIR__."/uploads/".$_GET['file'];

    $data = [];
    
    // On stocke les données du fichier CSV dans un tableau
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $data[] = $row;
        }
        fclose($handle);
    }
}
else {
    // Gérer l'erreur lorsque le fichier n'existe pas
    // Redirection vers la page d'accueil
    header("Location: index.php");
}


// Tirage au sort des numéros gagnants et du numéro chance
$winning_numbers = array();
$winning_chance = rand(1, 10);

while (count($winning_numbers) < 7) {
    $random_number = rand(1, 49);
    if (!in_array($random_number, $winning_numbers)) {
        $winning_numbers[] = $random_number;
    }
}

$winning_numbers_str = implode('-', $winning_numbers);

// Tri des tableaux de numéro pour faciliter la comparaison
sort($winning_numbers);
foreach ($data as $player) {
    sort($player);
}

// Initialisation du tableau de résultats
$results = array(
    "rang_1" => array(),
    "rang_2" => array(),
    "rang_3" => array(),
    "rang_4" => array(),
    "rang_5" => array(),
    "rang_6" => array()
);

// Parcours des joueurs pour trouver les gagnants
foreach ($data as $player) {
    // num_matches contient le nombre de numéros gagnants, en faisant l'intersection des tableaux
    // has_chance contient le booléen indiquant si le numéro chance est gagnant
    $num_matches = count(array_intersect($player, $winning_numbers));
    $has_chance = in_array($winning_chance, $player);
    $player_result = array_merge($player, array($winning_chance));

    // On ajoute le joueur au tableau des résultats correspondant à son rang
    if ($num_matches >= 5 && $has_chance) {
        array_push($results["rang_1"], $player_result);
    } elseif ($num_matches >= 5 && !$has_chance) {
        array_push($results["rang_2"], $player_result);
    } elseif ($num_matches == 4 && $has_chance) {
        array_push($results["rang_3"], $player_result);
    } elseif ($num_matches == 4 && !$has_chance) {
        array_push($results["rang_3"], $player_result);
    } elseif ($num_matches == 3 && $has_chance) {
        array_push($results["rang_4"], $player_result);
    } elseif ($num_matches == 3 && !$has_chance) {
        array_push($results["rang_4"], $player_result);
    } elseif ($num_matches == 2 && $has_chance) {
        array_push($results["rang_5"], $player_result);
    } elseif ($num_matches == 2 && !$has_chance) {
        array_push($results["rang_5"], $player_result);
    } elseif ($num_matches == 1 && $has_chance) {
        array_push($results["rang_6"], $player_result);
    } elseif ($num_matches == 0 && $has_chance) {
        array_push($results["rang_6"], $player_result);
    }
}

// création des lignes de gagnants
$gagnants = array();

foreach ($results as $rang => $result) {
    foreach ($result as $gagnant) {
        $gagnant = array(
            'nom' => $gagnant[0],
            'grille' => $gagnant[1],
            'numeros' => array_slice($gagnant, 2, 7),
            'numero_chance' => $gagnant[9]
        );
        $gagnants[$rang] = $gagnant;
    }
}

// écriture du fichier csv contenant les gagnants
$file = fopen('gagnants.csv', 'w');
fputcsv($file, array("Tirage", "Numero_chance"));
fputcsv($file, array($winning_numbers_str, $winning_chance));
$headers = array('Rang', 'Nom', 'Grille', 'Numeros', 'Numero_chance');
fputcsv($file, $headers);

foreach ($gagnants as $rang => $gagnant) {
    $nom = $gagnant['nom'];
    $grille = $gagnant['grille'];
    $numeros = implode('-', $gagnant['numeros']);
    $numero_chance = $gagnant['numero_chance'];
    $data = array($rang, $nom, $grille, $numeros, $numero_chance);
    fputcsv($file, $data);
}

fclose($file);

// téléchargement du fichier csv contenant les gagnants
$file_path = 'gagnants.csv';
if (file_exists($file_path)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
    exit;
}
?>