<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un stagiaire</title>
</head>
<body>
    <h1>Ajouter un stagiaire</h1>
    
    <form action="insertion.php" method="post" enctype="multipart/form-data">

    
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="mnom" ><br>
        
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="mprenom" ><br>
        
        <label for="DateN">Date de naissance :</label>
        <input type="date" id="DateN" name="mDateN" ><br>
        
        <label for="id_filiere">Filière :</label>
        <select id="id_filiere" name="mid_filiere" >
            <?php
            include 'connexion.php';
            $sql = "SELECT idFiliere, intitule FROM filiere";
            $stmt = $pdo->query($sql);
            $filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($filieres as $filiere) {
                echo "<option value='" . htmlspecialchars($filiere['idFiliere']) . "'>" . htmlspecialchars($filiere['intitule']) . "</option>";
            }
            ?>
        </select><br>
        
        <label for="photo_profil">Photo de profil :</label>
        <input type="file" id="photo_profil" name="photo_profil" required><br>
        
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
