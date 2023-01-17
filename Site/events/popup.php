<?php 
session_start();
error_reporting(0);
?>

<?php 
    include '../includes/menunavigation.php'; 
?>

<?php 

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin' && 'Tresorier'){

  header('Location: evenements.php');
}
?>

<link rel="stylesheet" href="../CSS/compte.css" />

Veuillez entrer les informations de l'évènement que vous souhaitez créer : <br>

<form action='evenements.php' method="post">
  <input type="text" name="titre" id="titre" placeholder="Titre" required><br/>
  <input type="text" name="lieu" id="lieu" placeholder="Lieu" required><br/>
  <div id=event> Date de début : <br> <INPUT type="date" name="ddd" required><br/>
  Date de fin : <br> <INPUT type="date" name="ddf" required><br/> </div>
  <input type="text" name="jeux" id="jeux" placeholder="Jeux" required><br/>
  <input type="text" name="description" id="description" placeholder="Description" required><br/>
  <input type="text" name="prix" id="prix" placeholder="Prix" ><br/>
  <input type="submit" name="newevt" id="newevt" value = " Créer l'évènement "><br/>
</form>

<?php   

include '../includes/database.php';

  $q4 = $db -> query("SELECT COUNT(*) FROM events ");
  $nbrlignes = $q4 -> fetch();
  
  ?>