<?php
    error_reporting(0);
    include '../includes/database.php';
    include 'panierfonctions.php';
    include '../includes/menunavigation.php';
    
    


?>

<link rel="stylesheet" href="../CSS/panier.css" />
<script src="../JS/javascript.js" defer></script>
<br/>

<?php 

session_start();

//par défaut il n'y a pas d'erreur
$erreur = false;

$action = (isset($_POST['action'])?$_POST['action']:(isset($_GET['action'])?$_GET['action']:null));
//si post action existe alors $action = post action sinon si get action existe alors $action = get action sinon = null

if($action!==null){ //s'il y a une action d'indiquée dans l'url

    if(!in_array($action, array('ajout','suppression','refresh'))) //si action différent de ajout suppr ou refresh alors il y a une erreur
        $erreur = true;

    //recup des infos primaires (dans l'url / depuis un formulaire)
    $t = (isset($_POST['t'])?$_POST['t']:(isset($_GET['titre'])?$_GET['titre']:null));
    $q = (isset($_POST['q'])?$_POST['q']:(isset($_GET['quantite'])?$_GET['quantite']:null));
    $p = (isset($_POST['p'])?$_POST['p']:(isset($_GET['prix'])?$_GET['prix']:null));

    //comme p est dans l'url, on le transforme en nombre plutot que chaine
    $p = floatval($p);

    //$q = tableau de l'ensemble des quantités de produit
    if(is_array($q)){

        $quantite = array();

        $i = 0;

        //transfert du contenu de $q dans $quantité, on transforme les infos en nombre
        foreach($q as $contenu){

            $quantite[$i++] = intval($contenu);

        }

    }else{
        
        //s'il n'y a qu'un seul produit, $q n'est pas un tableau, on peut juste récup la valeur et la mettre en nombre
        $q = intval($q);

    }

}


if(!$erreur){

    switch($action){ //on effectue l'action demandée dans l'url

        case "ajout":
        ajoutarticle($t,$q,$p);
        break;

        case "suppression":
        
        supprimerarticle($t);

        break;

        case "refresh":
        
        // count($quantite) = le nombre de produit unique
        for($i=0; $i<count($quantite); $i++){ 

            //on récupère les infos pour chaque produit
            $titre = $_SESSION['panier']['titre'][$i];
            $nbrachats = $_SESSION['panier']['quantite'][$i];

            // on récupère les infos sur les stocks disponible de ce produit
            $q = $db -> prepare("SELECT stock FROM produits WHERE titre=:titre");
            $q -> execute(array('titre' =>  $titre));
            $recupstock = $q -> fetch();

            if($recupstock['stock'] >= $quantite[$i]){ //si on rentre une quantité plus petite que le reste des stocks

                modifierarticle($_SESSION['panier']['titre'][$i], round($quantite[$i]));  //on affiche la nouvelle quantité

            }else{

                modifierarticle($_SESSION['panier']['titre'][$i], round($recupstock['stock'])); //sinon on affiche le max en stock

            }

        }

        break;

        default:

        break;

    }

}

?>

<!-- Affichage du panier (background)-->
<form method="post" action=''>

    <table width="400">
        <tr>
            <td id=vous colspan="4">Votre panier</td>
        </tr>
            <td>Titre du produit</td>
            <td>Prix unitaire</td>
            <td colspan="2">Quantité</td>

        </tr>
    <?php

    //si on a indiqué de supprimer le panier alors on le supprime
    if(isset($_GET['deletepanier']) && $_GET['deletepanier'] == true){ 

        supprimerpanier();

    }

    if(creationpanier()){ //voir fonction creationpanier --> panierfonctions.php

        $nbproduits = count($_SESSION['panier']['titre']); //on calcul le nombre de produits dans le panier

        if($nbproduits <= 0){ //0 produit = le panier est vide
            
            echo '<a id=retour href="boutique.php">Retourner à la boutique</a><br><br>';
            echo '<h1 style="text-align: center">Le panier est vide </h1><br>';
            
        }else{ //s'il y a des produits, on affiche les produits

            for($i = 0; $i<$nbproduits; $i++){

    ?>

        <tr>
            <!-- affichage du panier (valeurs)-->
            <td><br/><?= $_SESSION['panier']['titre'][$i]; ?></td>
            <td><br/><?= $_SESSION['panier']['prix'][$i]; ?></td>
            <td><br/><input class=quant name="q[]" value="<?= $_SESSION['panier']['quantite'][$i]; ?>" size="5"></td>
            <!-- si on clique sur supprimer un article on l'indique dans l'url -->
            <td><br/><a href="panier.php?action=suppression&amp;titre=<?= rawurlencode($_SESSION['panier']['titre'][$i]); ?>" style="font-size: 28px; border: 12px solid rgb(85, 51, 72); margin:auto;">Supprimer</a></td>
            
        </tr>
        <?php } //fin de la boucle for ?>
        <tr>
            
            <td colspan="4">
            <br>
                <!-- somme totale du panier -->
                <p>Total : <?= montanttotal();?> bobux</p>
                <input type="submit" value="rafraichir">
                <input type="hidden" name="action" value="refresh">
            </td>
        
        </tr>
            <!-- boutons classiques de navigation / suppression / achat -->
            <div id=boutons>
                <a id=retour href='boutique.php'>Retourner à la boutique</a><br><br>
                <br><br><br>
                <a id=suppr href="?deletepanier=true">Supprimer le panier</a> <br><br>
                <br><br><br>
                <a id=ajout href="achat.php?montant=<?php echo montanttotal()?>&amp;prods=" > Passer à l'achat </a>
            </div>

        <?php 

        } 
    
    }
    ?>

    </table>
</form>