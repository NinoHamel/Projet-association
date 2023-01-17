<?php session_start(); error_reporting(0);?>

<link rel="stylesheet" href="../CSS/produit.css" />

<?php 

    include '../includes/database.php';
    include '../includes/menunavigation.php';

    //on récupère les infos de tous les produits
    $q = $db -> prepare("SELECT * FROM produits WHERE titre=:titre ");
    $q -> execute(['titre'=> $_GET['titre']]);
    $nice = $q -> fetch();

    echo '<div id=box>';

    //on affiche tous les produits
    echo '<h1> Article :'.$nice['titre']." </h1> <br/> ";
    echo '<h2> Description :'.$nice['descriptio']." <br/>";
    echo 'Prix :'.$nice['prix']." </h2> <br/><br/>";

    if (isset($_SESSION['email'])){ //si il y a eu une connexion

        //on affiche "ajouter au panier" seulement s'il y a encore des produits en stock
        if ($nice['stock']!=0){ ?>
            <br><br><a class=acheter href="panier.php?action=ajout&amp;titre=<?= $nice['titre']; ?>&amp;quantite=1&amp;prix=<?= $nice['prix']; ?>"> Ajouter au panier <br/> </a>
            <?php }
        else{echo 'Stock épuisé';} ?>
        <?php

    }
    else //si on est pas connecté
    {
        echo " <h2>Il faut être connecté pour pouvoir acheter un produit </h2> ";
    }
?>