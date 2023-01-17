<head>
<link rel="stylesheet" href="CSS/compte.css" />
<script src="JS/javascript2.js" defer></script>
</head>

<body>

<?php 
include 'includes/menunavigation.php'; 
error_reporting(0);
?>
<meta charset="utf-8">

<?php 
    include 'includes/database.php';        // on inclut la bdd
?>



Inscription :
<br>
<div id=form>
<form method="post">
  <input type="text" name="prenom" id="prenom" placeholder="Prénom" required><br/>
  <input type="text" name="nom" id="nom" placeholder="Nom" required><br/>
  <INPUT type="radio" name="sexe" value="H" checked> Homme <INPUT type="radio" name="sexe" value="F"> Femme <br/>
  <input type="text" name="pseudo" id="pseudo" placeholder="Pseudonyme" required><br/>
  <input type="email" name="email" id="email" placeholder="Adresse mail" required><br/>
  <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required><br/>
  <input type="password" name="cmdp" id="cmdp" placeholder="Confirmation Mot de passe" required><br/>
  <input type="date" name="ddn" id="ddn" required><br/>
  <input type="text" name="profession" id="profession" disabled placeholder="Profession">        <!-- on désactive quand ville est actif et inversement -->
  <input type="checkbox" checked id="bouton2"> Je n'ai pas de profession </button>
  <div id="l2">
		<input type="text" name="vdr" id="vdr" placeholder="Ville de résidence" /><br>    
	</div>
  <input type="text" name="adresse_comp" id="adresse_comp" placeholder="Adresse complète" required><br/>
  <input type="submit" name="envoi" id="envoi" value = " S'inscrire ! "><br/>
</form>
</div>

<?php include 'includes/inscription.php'; ?>    <!-- on inclut le fichier php permettant de  traiter les informations entrées dans le formulaire -->

</body>