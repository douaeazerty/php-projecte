<?php

include 'connexion.php';

// Récupérer les filières pour la liste déroulante
$sql = "SELECT idFiliere, intitule FROM filiere";
$stmt = $pdo->query($sql);
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['mnom'];
    $prenom = $_POST['mprenom'];
    $date_naissance = $_POST['mDateN'];
    $id_filiere = $_POST['mid_filiere'];

    // Traitement du téléchargement de l'image
    $dossier_upload = "images/";
    $nom_fichier = $_FILES["photo_profil"]["name"];
    $chemin_fichier = $dossier_upload . $nom_fichier;

    // Vérifier le type de fichier (optionnel mais recommandé)
    $types_autorises = array("jpg", "jpeg", "png", "gif");
    $extension_fichier = strtolower(pathinfo($chemin_fichier, PATHINFO_EXTENSION));

    if (!in_array($extension_fichier, $types_autorises)) {
        echo "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        exit;
    }

    //Déplacer le fichier téléchargé vers le dossier de destination
    if (move_uploaded_file($_FILES["photo_profil"]["tmp_name"], $chemin_fichier)) {
        try {
            // Préparer et exécuter la requête d'insertion avec le chemin de l'image
            $sql_insert = "INSERT INTO stagiaire (idFiliere,nom, prenom, dateNaissance, photoProfil) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->execute([$id_filiere, $nom, $prenom, $date_naissance,  $chemin_fichier]);
            header("Location:espaceprivee.php");
            echo "Stagiaire ajouté avec succès.";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
}
?>
