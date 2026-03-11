<?php
session_start();
include "../config/database.php";

if(isset($_FILES["fichier"])){

    $nomFichier = $_FILES["fichier"]["name"];
    $tmpFichier = $_FILES["fichier"]["tmp_name"];

    $dossier = "../doc";
    $cheminFinal = $dossier . "/" . $nomFichier;

    // Déplacer le fichier dans le dossier doc
    if(move_uploaded_file($tmpFichier, $cheminFinal)){

        // Enregistrer le fichier dans la table fichiers
        $sql = "INSERT INTO fichiers (nom_fichier) VALUES (:nom)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nom", $nomFichier);
        $stmt->execute();

        // récupérer l'id du fichier
$id_fichier = $pdo->lastInsertId();
        // Ouvrir le fichier CSV
        $handle = fopen($cheminFinal,"r");

        // Ignorer la première ligne (entête)
        fgetcsv($handle);

        // Lire chaque ligne
        while(($data = fgetcsv($handle,1000,",")) !== FALSE){

            $matricule = $data[1];
            $nom = $data[2];
            $prenom = $data[3];
            $filiere = $data[4];
            $niveau = $data[5];
            $moyenne = $data[6];

            // Insérer dans la table etudiant
            $sql = "INSERT INTO etudiant (matricule,nom,prenom,filiere,niveau,moyenne,id_fichier) VALUES (?,?,?,?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$matricule, $nom, $prenom, $filiere, $niveau, $moyenne, $id_fichier
            ]);
        }

        fclose($handle);

        //  Redirection vers le dashboard admin après upload réussi
        header("Location: ../admin/admin_dash.php");
        exit();

    } else {
        echo "Erreur lors du telechargemnt";

    }
}
?>

