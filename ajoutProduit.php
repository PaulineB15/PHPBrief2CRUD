<?php

// Démarrage de la session 
session_start();


// Pour savoir si on vient d'envoyer le formulaire
// POST - recupère les informations du formulaire de "façon invisible" 
if ($_SERVER['REQUEST_METHOD'] === "POST"){

// RECUPERE LA VALEUR TAPEE DANS LES CHAMPS DU <form> (ex: name="stock")  + NETTOYAGE DES DONNEES

// QUE SE PASSE T-IL SUR CETTE LIGNE ? (lire de droite à gauche)
// 1. PHP prend d'abord $_POST['nom'].
// 2. Exécute la fonction la plus à l'intérieur : trim() - nettoie les espaces en trop
// 3. Donne le résultat nettoyé à fonction englobante : htmlspecialchars() - Empêche le navigateur d'interpréter du code malveillant injecté par un utilisateur
// 4. Stocke le résultat final dans la variable $nom.
$nom = (trim($_POST['nom']));
$prix = (trim($_POST['prix']));
$stock = (trim($_POST['stock']));


// VALIDATION DU FORMULAIRE

// Même si "required" est dans mon <form> HTML 
// un utilisateur peut le contourner facilement. 
// Il faut donc toujours vérifier côté serveur (PHP) que le champ n'est pas vide en utilisant

if (!empty($nom) && strlen($nom) <= 50
    // !empty() - si la variable $nom/$message n'est PAS vide
    // strlen() - compte le nombre de caractères
    && !empty($prix)
    && !empty($stock)) { 

    // Lier l'ajout du produit à la BDD 
    require_once "connexionBDD.php";

    // INSERER DES DONNES DANS LA TABLE PRODUIT BDD AVEC PDO
   // Requête préparée avec les marqueurs de sécurité (:nom, :prix, :stock)
   // A quoi ça sert ? Protéger contre les injections SQL
   // Ici le CRUD - C'est la partie CREATE
    $query = "INSERT INTO produits (nom, prix, stock) VALUES (:nom, :prix, :stock)";
    $stmt = $pdo->prepare($query);

    // Exécuter en liant les marqueurs (:nom, :prix, :stock) aux vraies variables nettoyées
    $stmt->execute([
        // Contenu de la variable ($nom) -> dans marqueur (:nom)
        ':nom' => $nom,
        ':prix' => $prix,
        ':stock' => $stock
    ]);

    // Confirmation de l'envoi du formulaire
    $_SESSION['messageConfirmation'] = "Votre produit a bien été ajouté !";
   

    // header() - Redirige vers index.php (liste des produits)
        header('Location: index.php');
        // Arrêt du script après redirection
        exit; 
        
    } else {
        // EN CAS D'ERREUR (Le else de la validation), on affiche l'erreur
        echo "<p style='color:red; text-align:center;'>Erreur : Merci de remplir correctement tous les champs.</p>";   
    }
    // Avec var_dump - la page va afficher exactement ce que le visiteur a tapé (nom, email et message)
    //var_dump($_POST);
} 

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de nouveau produits</title>
    <link rel="stylesheet" href="">
</head>

<body>

    <h1>Ajouter une nouvelle référence de produit</h1>

    <!--Renvois les données du formulaire dans la même page ajoutProduit.php -->
    <!-- Cela est plus propre en cas d'erreur de saisie du produit-->
    <form action="ajoutProduit.php" method="post">
        <input type="text" name="nom" placeholder="Nom" required><br><br>
        <input type="number" name="prix" placeholder="Prix" step="0.01" required><br><br>
        <input type="number" name="stock" placeholder="Stock" required><br><br>
        <button type="submit">Ajouter le produit </button>
    </form>

</body>
</html>