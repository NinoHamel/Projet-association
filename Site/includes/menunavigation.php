<?php session_start(); ?>
<head>
<link rel="stylesheet" href="../CSS/cssnavi.css" />
</head>

<header class="navigation">
    <ul>
        <li>
         <a href="../index.php">Accueil</a>  <!-- lien vers l'accueil -->
        </li>
        <li>  
         <a href ="../events/evenements.php">Evenements</a> <!-- lien vers la page évènements -->
        </li>
        <li>
         <a href="../boutique/boutique.php">Boutique</a> <!-- lien vers la boutique -->
        </li>
        <li>
         <a href="../inscrireouconnecter.php">Espace membre</a> <!-- lien vers l'espace membre --> 
        </li>
        <li>
        <?php 
                if(isset($_SESSION['email']))       // si il y a actuellement une connexion 
                {
                ?>
                <form id='fermer' name='fermer' method='post' action='../includes/deconnexion.php'>
                <input type='submit' id='soumettre' value='Se d&eacute;connecter' style='width:120px;height:25px;' /> <!-- bouton de déconnexion -->
                </form>
                </li>
                <?php
            }
            else
            {
                echo "<h3>Tu n'es pas connecté</h3>";
            }
        ?>

</header>
