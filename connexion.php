<?php
$dsn = 'mysql:host=localhost;dbname=gestionstagiaire_v1;charset=utf8';
$user = 'root';
$password = 'root'; 

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit();
}
?>
