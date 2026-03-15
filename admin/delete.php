<?php

include "../config/database.php";
// on recupere l'id du fichier dans l'url
$id = $_GET['id'];
// récupérer les fichiers dans la table fichiers
$sql = "SELECT * FROM fichiers WHERE id_fichier = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id'=>$id]);
$fichier = $stmt->fetch();

if($fichier){

    // supprimer les étudiants liés au fichier
    $sql = "DELETE FROM etudiant WHERE id_fichier = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id'=>$id]);

    //  supprimer le fichier dans le dossier
    $chemin = "../doc/" . $fichier['nom_fichier'];
    if(file_exists($chemin)){
        unlink($chemin);
    }

    //  supprimer le fichier dans la table fichiers
    $sql = "DELETE FROM fichiers WHERE id_fichier = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id'=>$id]);
}
// redirection vers le dashboard de l'admin apres suppression du fichier
header("Location: ../admin/admin_dash.php");


?>