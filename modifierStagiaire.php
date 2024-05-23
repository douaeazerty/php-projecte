<?php 
require_once 'connexion.php';

session_start();

$sql = "SELECT * FROM filiere;";
$stmt = $pdo->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM stagiaire WHERE idStagiaire = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $stagiaire = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['idStagiaire']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['dateNaissance']) && isset($_POST['filiere'])) {
        $idStagiaire = $_POST['idStagiaire'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $dateNaissance = $_POST['dateNaissance'];
        $idFiliere = $_POST['filiere'];
        $photoProfil = $stagiaire['photoProfil']; // Default to current profile picture
        
        if (isset($_FILES['photoProfil']) && $_FILES['photoProfil']['error'] == 0) {
            $target_dir = "img/";
            $target_file = $target_dir . basename($_FILES['photoProfil']['name']);
            if (move_uploaded_file($_FILES['photoProfil']['tmp_name'], $target_file)) {
                $photoProfil = $target_file;
            }
        }

        $sql = "UPDATE stagiaire SET nom = ?, prenom = ?, dateNaissance = ?, photoProfil = ?, idFiliere = ? WHERE idStagiaire = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nom, $prenom, $dateNaissance, $photoProfil, $idFiliere, $idStagiaire])) {
            $_SESSION['message'] = 'Le stagiaire a été modifié avec succès';
            header('Location: espaceprivee.php');
            exit;
        } else {
            $_SESSION['error'] = 'Erreur lors de la modification du stagiaire';
        }
    } else {
        $_SESSION['error'] = 'Veuillez remplir tous les champs';
        header("Location: modifierStagiaire.php?id=" . $_POST['idStagiaire']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Stagiaire</title>
</head>
<body>
<h1>Modifier le Stagiaire</h1>
<a href="espaceprivee.php">Retour</a>
    <form action="modifierStagiaire.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <h2>Modifier le stagiaire</h2>
            <p>Veuillez remplir tous les champs</p>
            <input type="hidden" name="idStagiaire" value="<?= $stagiaire['idStagiaire'] ?>">
            <label for="nom">Nom</label><br>
            <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($stagiaire['nom']) ?>"><br>
            <label for="prenom">Prénom</label><br>
            <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($stagiaire['prenom']) ?>"><br>
            <label for="dateNaissance">Date de Naissance</label><br>
            <input type="date" name="dateNaissance" id="dateNaissance" value="<?= htmlspecialchars($stagiaire['dateNaissance']) ?>"><br>
            <label for="photoProfil">Photo de Profil</label><br>
            <input type="file" name="photoProfil" id="photoProfil"><br>
            <label for="filiere">Filière</label><br>
            <select name="filiere" id="filiere">
                <?php foreach ($result as $filiere): ?>
                    <option value="<?= $filiere['idFiliere'] ?>" <?= $filiere['idFiliere'] == $stagiaire['idFiliere'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($filiere['intitule']) ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <input type="submit" value="Modifier">
        </fieldset>
    </form>
    <p style='color:red;'>
        <?= isset($_SESSION['error']) ? $_SESSION['error'] : '' ?>
        <?php unset($_SESSION['error']); ?>
    </p>
</body>
</html>