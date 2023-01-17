<?php 
session_start();

include '../includes/database.php';
?>

<link rel="stylesheet" href="../CSS/compte.css" />

<?php 

//si la personne qui accède à cette page n'est si un admin si un  trésorier --> on refuse l'accès
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin' && 'Tresorier'){ 

  header('Location: boutique.php');
}
?>

<a id=back href='boutique.php'>Retourner à la boutique<br/></a><br><br>

Veuillez entrer les informations du produit que vous souhaitez ajouter : <br>

<!-- formulaire pour ajouter un produit -->
<form action='' method="post">
        <br>Titre : <br>
        <input type="text" name="titre" id="titre"  placeholder="Titre" required><br/>
        <br>Description :  <br>
        <textarea name="descriptio" id="description" placeholder="Description"></textarea>
        <br>Prix : <br>
        <input type="text" name="prix" id="prix" placeholder="Prix" required><br/>
        <br>Stock : <br>
        <input type="text" name="stock" id="stock" placeholder="Stock"  required><br/>
        <input type="submit" name="ajoutprod" id="ajoutprod" value = " Ajouter le produit "><br/>
</form>

<?php
if(isset($_POST['ajoutprod'])){ //si on a appuyé sur le bouton du formulaire

//on récupère les valeurs du formulaire
$titre=$_POST['titre'];
$descriptio=$_POST['descriptio'];
$prix=$_POST['prix'];
$stock=$_POST['stock'];
$nbrachats = 0;

//on ajoute un produit dans la bdd avec les infos qu'on vient de récupérer
$update = $db ->prepare( "INSERT INTO produits(titre,descriptio,prix,stock,nbrachats) VALUES ('$titre','$descriptio',$prix,$stock,$nbrachats)");
$update -> execute();

//calcul des couts de production des produits
$difference = $prix * $stock;

//actualisation de l'argent en fonction des dépenses pour les nouveaux produits
$update = $db ->prepare( "UPDATE argent SET argent=argent-$difference WHERE 1");
$update -> execute();

header('Location: boutique.php');

} 

?>