<?php

require_once 'connexion.php';

try {
    $sql = "
    CREATE TABLE if not exists compteadministrateur (
        loginAdmin varchar(10) primary key not null,
        motPasse varchar(10) not null,
        nom varchar(20) not null,
        prenom varchar(20) not null
    );
    CREATE TABLE if not exists filiere (
        idFiliere VARCHAR(5) PRIMARY KEY,
        intitule VARCHAR(20),
        nombreGroupe INT(11)
    );

    CREATE TABLE if not exists stagiaire (
        idStagiaire INT(11) AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(20),
        prenom VARCHAR(20),
        dateNaissance DATE,
        photoProfil TEXT,
        idFiliere VARCHAR(5),
        FOREIGN KEY (idFiliere) REFERENCES filiere(idFiliere)
    );


    ";
    
    $pdo->exec($sql);
    
    echo "Les tables ont été créées avec succès.";
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>
