<link rel="stylesheet" href="../CSS/info.css" />

<?php session_start(); ?>

<?php session_destroy();        // permet de détruire toutes les informations de connexion

echo 'Tu as bien été deconnecté <br/> ';
?>

<a href="../index.php" > Retour à l'accueil </a>

