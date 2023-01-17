<?php 
session_start();
?>

<?php error_reporting(0); ?>

<script src="../JS/javascript.js" defer></script>

<link rel="stylesheet" href="../CSS/modifevent.css" />

<a id= retour href="boutique.php"> Revenir à la page de la boutique </a>

<?php
include "../includes/database.php";

//si la personne qui accède à cette page n'est si un admin si un  trésorier --> on refuse l'accès
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin' && 'Tresorier'){

    header('Location: boutique.php');
    }
?>

<h1>PANNEAU ADMIN DE LA BOUTIQUE</h1>

<br>Argent sur le compte : 

        <?php 
        //on récupère l'argent dans la bdd
        $q = $db -> prepare("SELECT * FROM argent");
        $q -> execute();
        //on cherche la ligne argent et on la transforme en objet pour pouvoir l'afficher
        $affiche_argent = $q -> fetch(PDO::FETCH_OBJ);
        ?>
        <!-- formulaire pour modifier la somme d'argent de l'association -->
        <form action='' method="post">
        <input type="text" name="argent" id="argent" placeholder="argent" value="<?php echo $affiche_argent->argent; ?>"><br/>
        <input type="submit" name="modifargent" id="modifargent" value = " Modifier l'argent en stock "><br/>
        </form>
        
        <br><br>

<br>

<?php

        $q = $db -> prepare("SELECT * FROM produits"); //on récupère les infos de tous les produits
        $q -> execute();

        echo "<table>";
        
        //tant qu'il y a des produits, on place ce produit en objet dans $affiche
        while($affiche=$q->fetch(PDO::FETCH_OBJ)){
            echo "<tr>";
            echo "<td>";
            echo $affiche->titre; //affiche le titre
            echo "</td>";
            ?>
            <td>
            <!-- bouton modifier link avec l'id du produit -->
            <a href="?action=modifier&amp;id=<?= $affiche->id; ?>">Modifier</a> 
            </td>
            <td>
            <!-- bouton supprimer link avec l'id du produit -->
            <a href="?action=suppr&amp;id=<?= $affiche->id; ?>">X</a><br>
            </td>
            <tr>

        <?php     
        }

        echo "</table>";



if($_GET['action']=='modifier') //si on clique sur modifier on affiche un formulaire pour modifier le produit
{

    //on récupère les infos du produit en fonction de son id (stocké dans l'url)
    $id=$_GET['id'];

    $q = $db -> prepare("SELECT * FROM produits WHERE id=$id");
    $q -> execute();

    $infos = $q->fetch(PDO::FETCH_OBJ);

    ?>
    <br><br>
    <!-- formulaire pour modifier un produit -->
    <form action='' method="post">
        <br>Titre :
        <input type="text" name="titre" id="titre" value="<?php echo $infos->titre; ?>" placeholder="Titre" required><br/>
        <br>Description :
        <textarea name="descriptio" id="description" placeholder="Description" required><?php echo $infos->descriptio; ?></textarea><br/>
        <br>Prix :
        <input type="text" name="prix" id="prix" placeholder="Prix" value="<?php echo $infos->prix; ?>" required><br/>
        <br>Stock :
        <input type="text" name="stock" id="stock" placeholder="Stock" value="<?php echo $infos->stock; ?>" required> <br/><br>
        <input type="submit" name="modifprod" id="modifprod" value = " Modifier le produit "><br/>
    </form>
    <?php

    if(isset($_POST['modifprod'])){ //si on a appuyé sur le bouton du formulaire

        //on récupère les infos du formulaire
        $titre=$_POST['titre'];
        $descriptio=$_POST['descriptio'];
        $prix=$_POST['prix'];
        $stock=$_POST['stock'];

        //on update la bdd avec les infos du formulaire
        $update = $db->prepare("UPDATE produits SET titre='$titre',descriptio='$descriptio',prix='$prix',stock='$stock' WHERE id=$id");
        $update->execute();

        //on calcul les différents couts / bénéfices des changements
        $difference_stock = $stock - $infos->stock;
        $difference = $prix * $difference_stock;

        //on update l'argent dans la bdd en fonction des couts / bénéfices
        $update = $db ->prepare( "UPDATE argent SET argent=argent-$difference WHERE 1");
        $update -> execute();

        header('Location: modifierboutique.php');

    }
} 

elseif($_GET['action']=='suppr') //si on clique sur la croix on supprime le produit
{
    $id=$_GET['id'];
    $delete = $db -> prepare("DELETE FROM produits WHERE id=$id");
    $delete -> execute();

    header('Location: modifierboutique.php');
} 

if(isset($_POST['modifargent'])){ //si on a cliqué sur modifier l'argent on modifie l'argent

    $nouveau_argent=$_POST['argent']; //on récupère l'argent dans le formulaire 
    
    //puis on l'injecte dans la bdd
    $update = $db->prepare("UPDATE argent SET argent='$nouveau_argent' WHERE 1");
    $update->execute();

    header('Location: modifierboutique.php');

}

    
?>
