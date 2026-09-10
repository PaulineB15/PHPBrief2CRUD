<?php

// Démarrage de la session 
session_start();


// Vérifie qu'il y bien un ID dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])){

    // Récupère l'ID depuis l'URL (GET) - besoin pour l'UPDATE et le SELECT
    $id = htmlspecialchars(trim($_GET['id']));

    // Lier le fichier connexionBDD.php à la page modifierProduit.php pour l'affichage du produit à modifier
    require_once "connexionBDD.php";



    // "MODE ECRITURE" - POST (SI ON A CLIQUER SUR LE BOUTON "MISE A JOUR")

    // POST - recupère les informations du produit de "façon invisible" 
    if ($_SERVER['REQUEST_METHOD'] === "POST"){

        // RECUPERE LES NOUVELLES DONNES TAPEES DANS LE FORMULAIRE (comme dans ajoutProduot.php)
        $nom = htmlspecialchars(trim($_POST['nom']));
        $prix = htmlspecialchars(trim($_POST['prix']));
        $stock = htmlspecialchars(trim($_POST['stock']));

        // Prépare la requête pour la modification
        $updateQuery = "UPDATE produits SET nom = :nom, prix = :prix, stock = :stock WHERE id = :id"; 
        $stmtUpdate = $pdo->prepare($updateQuery); 

        //Exécuter en liant TOUS les marqueurs (y compris l'id !)
        $stmtUpdate->execute([
            ':nom' => $nom,
            ':prix' => $prix,
            ':stock' => $stock,
            ':id' => $id
        ]);

        //Message de confirmation
        $_SESSION['messageConfirmation'] = "Le produit a bien été modifier !";
    
        //Redirection vers l'accueil
        header('Location: index.php');
        exit;
    }


     //"MODE LECTURE" - AFFICHER 

    // Prépare la requête pour récupérer l'ID du produit
    //Ici le CRUD - C'est la partie READ
    // Pour tout récupérer de l'ID produit, il ne faut pas oublier l'astérisque *
    $query = "SELECT * FROM produits WHERE id= :id";

    // Prépare la requête pour la modifier ensuite
    $stmt = $pdo->prepare($query);

    $stmt->execute([
        // Contenu de la variable ($id) -> dans marqueur (:id)
        ':id' => $id
    ]);

    // Récupération des données du produit 
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

  } else {
    // Sécurité : Si quelqu'un arrive sur la page sans ID dans l'URl -> renvoie à l'accueil
    header('Location: index.php');
    exit;
}  

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de produits</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <!--Renvois les données du formulaire dans la même page -->
    <form action="" method="post">
        <input type="text" name="nom" value="<?= htmlspecialchars($produit['nom']) ?>" required><br><br>
        <input type="number" name="prix" step="0.01" value="<?= htmlspecialchars($produit['prix']) ?>" required><br><br>
        <input type="number" name="stock" value="<?= htmlspecialchars($produit['stock']) ?>" required><br><br>
        <button type="submit">Mise à jour</button>
    </form>

</body>
</html>