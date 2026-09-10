<?php

// Information de connexion à la base de donnée MySQL
$host = "localhost"; // sans le port
$dbname = "brief2phppdo";
$user = "root";
$password = ""; // ou rien

try {
    // Création d'un nouvel "object" de connexion PDO (Php Data Object - interface)
    // Lien avec la BDD
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // chartset=utf8 - pour que la syntaxte des accents s'affiche

    // Confirguration de PDO en cas d'exception (alerte rouge) si erreur SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Variable $e ->  toutes les infos sur l'erreur (heure, ligne de code, raison erreur etc.)

    // En cas d'erreur
    die("Erreur de connexion : " . $e->getMessage());
    // Fonction die() - stoppe immédiatement l'exécution de toute la page PHP
    // $e->getMessage() - Afficher l'erreur à l'écran
    
}

?>