<?php 
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
  <title>CY Games</title>
  	<link rel="icon" href="img/troll.jpg" />
  	<meta charset="utf-8">
	<link rel="stylesheet" href="CSS/css.css" />
  	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<meta http-equiv="content-language" content="FR"/>
	<script src="JS/javascript.js" defer></script>
</head>


<body>

<?php 
	error_reporting(0);						// on enlève l'affichage des warnings / errors en php 
	include 'includes/menunavigation.php';	// on inclut le menu de navigation en haut de page, cela sera fait au début de nombreuses pages
	include 'includes/database.php';		// on inclut le fichier qui permet la connexion à la base de données 
	global $db;

	echo "Bonjour " . $_SESSION['pseudo'] .", bienvenue sur le site de CY Games !";		// petit message d'accueil 
	
 ?>

 <div class=wrapper>
 
 <center> <h1> CY Games </h1> </center>

 <a class="util" href="ficheutilisateur.php?pseudo=<?php echo $_SESSION['pseudo']; ?>">Voir ta fiche utilisateur</a> <!-- lien vers la fiche utilisateur -->
 
 <div class=desc>
 <h2> Pourquoi nous rejoindre ? </h2>
 <center> <h4> CY Games vous proposera des lans au cours de l'année pour venir affronter vos camarades dans des parties pleines de tension. Mais nous ne proposons pas que ça, vous
 pouvez aussi nous retrouver en CY 123 pour jouer avec nous ou de votre côté dans nos locaux. Etant donné que nous sommes une association de jeux-vidéos, nous 
 proposons parfois quelques jeux auxquels vous pouvez jouer chez vous que nous avons testé auparavant.</h4> </center>
 </div>

 <div class=desc>
 <h2> Avantages pour les cotisants : </h2>
 <center> <h4> Durant les lans et dans les locaux, vous bénéficierez de tarifs préférentiels sur les boissons et snacks, en plus de cela, vous soutenez l'association
 et nous offrez un soutien pour continuer à vous proposer des services de qualité. Pour cotiser, vous devez vous rendre au bureau avec 7 euros en liquide 
 ou bien 7 euros par lydia. </h4> </center>
 </div>

<div id=question>
<h1> Tu as une question ? <br/> </h1> 
<a href='forum.php' img='img/reviews.jpg'>Page des questions</a>   <!-- lien vers la page des questions à poser -->
</div>
 
<div id=review>
<h1> Recommandations du staff : </h1> 
<a href='reviews.php' img='img/reviews.jpg'>Reviews du staff </a>			<!-- lien vers la page des revues faites par nous-même -->
</div>
<br/><br/>

	<div class="push"></div>
 </div>

<footer> 
	<a href="https://discord.gg/V9Kw7Sqreh" target="blank" style="border: none;"><img src="img/discord.png" style="height: 40px; float:left; margin-left: 10px; margin-top: 10px;"></imf></a>
 	<button id="openBtn"> Contact </button>
        <dialog id="contact">
         <button id="closeBtn"> Fermer </button>
         <p class="centre"> <h4> Contact : </h4> EISTI <br> Avenue du Parc <br> Cergy-Pontoise, France <br> CYGames@gmail.com <br> </p>
         </dialog>
<!-- tout ce qui est dans la balise footer correspond aux moyens de nous contacter ( factices ) -->
</footer>

</body>