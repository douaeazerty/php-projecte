<?php
require_once 'connexion.php';

session_start();

$sql = "SELECT * FROM stagiaire";
$stmt = $pdo->query($sql);
$stagiaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Stagiaires</title>
</head>
<body>
    <h1>Liste des Stagiaires</h1>
    <a href="espaceprivee.php">Retour</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de Naissance</th>
                <th>Photo de Profil</th>
                <th>Filière</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stagiaires as $stagiaire): ?>
                <tr>
                    <td><?= htmlspecialchars($stagiaire['idStagiaire']) ?></td>
                    <td><?= htmlspecialchars($stagiaire['nom']) ?></td>
                    <td><?= htmlspecialchars($stagiaire['prenom']) ?></td>
                    <td><?= htmlspecialchars($stagiaire['dateNaissance']) ?></td>
                    <td><img src="<?= htmlspecialchars($stagiaire['photoProfil']) ?>" alt="Profil" width="50"></td>
                    <td><?= htmlspecialchars($stagiaire['idFiliere']) ?></td>
                    <td><a href="modifierStagiaire.php?id=<?= $stagiaire['idStagiaire'] ?>">Modifier</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>