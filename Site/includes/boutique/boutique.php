<?php
    session_start() 
?>

<?php error_reporting(0); ?>

<?php
    include '../includes/menunavigation.php'; 
    include '../includes/database.php';
?>

<a href="rechercheboutique.php"> Rerchercher un produit </a> <br/><br/><br/><br/>

Cliquez sur le titre d'un produit pour accéder à ses informations où pour acheter ce produit. <br/>

<link rel="stylesheet" href="../CSS/boutique.css" />
<script src="../JS/javascript.js" defer></script>
<br/>

<?php 

    //si la personne qui accède à cette page est admin ou trésorier, on affiche les options pour édit les données
    if($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Tresorier')
    {
        ?><br/> <a href="javascript:popupBasique('/boutique/ajoutboutique.php')">Création de produit</a>
                <a href="javascript:popupBasique('/boutique/modifierboutique.php')">Modifier un produit et gérer les stocks</a>

        <?php echo "<br/>"; 
    }

    //on cherche tous les éléments de produits puis on les affiche
    $q = $db -> query('SELECT * FROM produits ');
    while ($nice = $q -> fetch()) 
    {  
        echo '<div id=boutique>';
        echo '<div id=div2>';

        //lien avec les infos du produit
        ?><a href="pageproduit.php?titre=<?php echo $nice['titre']; ?>" style="font-size:120%; background-color:white; border:none; text-align:center; color:black" > <?php echo '<p id=titre> Titre:'.$nice['titre']." <p>  "; ?> </a> <?php
        echo 'Description:'.$nice['descriptio']."<br/>";
        echo 'Prix:'.$nice['prix']."<br/>";
        echo 'stock:'.$nice['stock']."<br/>";

        //on affiche "ajouter au panier" seulement s'il y a encore des produits en stock
        if ($nice['stock']!=0){ ?><br><br><a class=acheter href="panier.php?action=ajout&amp;titre=<?= $nice['titre']; ?>&amp;quantite=1&amp;prix=<?= $nice['prix']; ?>"> Ajouter au panier <br/> </a><?php }
        else{echo 'Stock épuisé';} ?>
        <?php

        echo '</div>';
        echo '</div>';
    }




    

?>


