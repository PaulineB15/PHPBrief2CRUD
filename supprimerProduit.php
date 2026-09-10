<?php

// Démarrage de la session 
session_start();

if (isset($_GET['id']) && !empty($_GET['id'])){

    // Récupère l'ID depuis l'URL (GET)
    $id = htmlspecialchars(trim($_GET['id']));

    // Connexion à la BDD
    require_once "connexionBDD.php";

    // Prépare la requête pour la suppression 
    $deleteQuery = "DELETE FROM produits WHERE id= :id";
    $stmt = $pdo->prepare($deleteQuery);

    $stmt->execute([
        // Contenu de la variable ($id) -> dans marqueur (:id)
        ':id' => $id
    ]);

    //Message de confirmation
    $_SESSION['messageConfirmation'] = "Le produit a bien été supprimé !";
}

    // header() - Redirige vers index.php (liste des produits)
    header('Location: index.php');
    // Arrêt du script après redirection
    exit; 
?>