<head>
    <link rel="stylesheet" href="CSS/css.css" />
    <script src="JS/javascript.js" defer></script>
</head>

<body> 

<?php include 'includes/menunavigation.php'; ?>

<h1> Vous n'avez pas de compte ? Rejoignez-nous ici : </h1>
<a href="inscrire.php"> S'inscrire </a>     <!-- lien vers la page permettant l'inscription -->

<h1> Vous avez déjà un compte ? Connectez-vous ici : </h1>
<?php if (!isset($_SESSION['pseudo']))          // on teste : si la personne n'est pas connectée, on affiche le lien vers la page de connexion, sinon, on affiche qu'elle est 
{                                               // déjà connectée
?>
<a href="connecter.php"> Se connecter </a>
<?php
}
else
{
    echo ' Tu es déjà connecté ! <br/>';
}
?>

</body>