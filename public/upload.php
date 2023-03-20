<?php

// Upload du fichier CSV
if(isset($_FILES['csv_file'])) {
    $errors = array();
    $file_name = $_FILES['csv_file']['name'];
    $file_size = $_FILES['csv_file']['size'];
    $file_tmp = $_FILES['csv_file']['tmp_name'];
    $file_type = $_FILES['csv_file']['type'];
    $file_ext = strtolower(end(explode('.', $_FILES['csv_file']['name'])));
    
    $extensions = array("csv");
    
    if(in_array($file_ext, $extensions) === false){
        $errors[] = "Cette extension n'est pas autorisée, veuillez choisir un fichier CSV.";
    }
    
    if($file_size > 2097152) {
        $errors[] = 'La taille du fichier ne doit pas dépasser 2MB';
    }
    
    if(empty($errors) == true) {
        // Le fichier est valide, on le déplace dans le dossier uploads
        move_uploaded_file($file_tmp, __DIR__."/uploads/".$file_name);
        header("Location: result.php?file=".$file_name);
    } else {
        print_r($errors);
    }
}
?>
