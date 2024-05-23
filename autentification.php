<?php
session_start();
require 'connexion.php'; // Inclusion du fichier de connexion

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['loginName'];
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        $errorMessage = "Les données d'authentification sont obligatoires.";
    } else {
        try {
            $sql = "SELECT * FROM compteadministrateur WHERE loginAdmin = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$login]);
            $log = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($log) {
                if ($password  == $log['motPasse']) {
                    // Création d'une session avec la valeur du login
                    $_SESSION['username'] = $login;
                    header('Location: espaceprivee.php');
                    exit;
                } else {
                    $errorMessage = "Les données d'authentification sont incorrectes.";
                }
            } else {
                $errorMessage = "L'utilisateur n'existe pas.";
            }
        } catch (PDOException $e) {
            $errorMessage = "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
</head>
<body>
    <h1>Authentification</h1>
    <?php if (!empty($errorMessage)) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>
    <form action="autentification.php" method="post">
        <label for="loginName">Nom d'utilisateur :</label>
        <input type="text" id="loginName" name="loginName" value="<?php echo isset($login) ? htmlspecialchars($login) : ''; ?>">
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password">
        <br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
