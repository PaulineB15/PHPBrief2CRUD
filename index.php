<?php

// Démarrage de la session 
session_start();

// Lier le fichier connexionBDD.php  à la page index.php pour l'affichage des produits
require_once "connexionBDD.php";


// Préparation de la requête 
// Ici le CRUD - C'est la partie READ
$query = "SELECT * FROM produits";

// Exécution de la requête
$stmt = $pdo->query($query);


// Récupération des données (un tableau associatif)
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Avec var_dump - Afficher dans le navigateur les produits de la BDD 
//var_dump($produits);

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des articles de sport</title>
    <link href="index.css" rel="stylesheet">
</head>

<body>

 <?php
        // isset () - Fonction qui vérifie si une variable est définie
        // ce qui signifie qu’elle doit être déclarée et non NULL (déclarer juste avant)
    if (isset($_SESSION["messageConfirmation"])){
        echo
        htmlspecialchars($_SESSION["messageConfirmation"]);

        // unset () - Fonction qui détruit la variable de session
        unset($_SESSION["messageConfirmation"]);}
    ?>

    <h1>Articles de sport</h1>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>

            <!--foreach - récupère (id, nom, prix et stock) de la BDD pour chaque produits-->
            <?php foreach ($produits as $products) : ?>
            <tr>
                <td><?= htmlspecialchars ($products['id']) ?></td>
                <td><?= htmlspecialchars ($products['nom']) ?></td>
                <td><?= htmlspecialchars ($products['prix']) ?></td>
                <td><?= htmlspecialchars ($products['stock']) ?></td>
                <td>
                    <a href="modifierProduit.php?id=<?= htmlspecialchars($products['id']) ?>"><button>Modifier</button></a>
                    <a href="supprimerProduit.php?id=<?= htmlspecialchars($products['id']) ?>"><button>Supprimer</button></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        <!-- On place le bouton dans un conteneur pour le centrer -->
        <div class="bouton-ajout-container">
            <a href="ajoutProduit.php">
                <button class="btn-ajouter">Ajouter un produit</button>
            </a> 
        </div>
            

</body>
</html>