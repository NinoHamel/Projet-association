<?php
    session_start();
    error_reporting(0); ?>
<head>
<link rel="stylesheet" href="../CSS/compte.css" />
</head>

<body>

<?php include 'includes/menunavigation.php'; ?>
<meta charset="utf-8">

<?php 
    include 'includes/database.php';        // on inclut la bdd
    global $db;                             // on récupère la variable db créée dans database.php
?>
Connexion : 
<div id=form>
<br>
<form method="post">
    <input type="email" name="email2" id="email2" placeholder="Adresse mail" required><br/>
    <input type="password" name="mdp2" id="mdp2" placeholder="Mot de passe" required><br/>      <!-- formulaire pour se connecter -->
    <input type="submit" name="connexion" id="envoi" value = " Se connecter "><br/>
</form>
</div>

<?php include 'includes/connexion.php'; ?>    

</body>