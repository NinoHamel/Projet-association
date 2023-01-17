<link rel="stylesheet" href="CSS/info.css" />

<?php session_start() // on démarre la session car on va faire une vérification sur la personne qui démarre cette page ?>
<form name="changerrole">
<a href='admin.php'>Retourner à la page d'administration</a>

<?php

    include 'includes/database.php';

    if ($_SESSION['role'] == 'Admin')           // si la personne connectée est bien un admin 
    {
        if (isset($_GET['pseudo']))             
        {
            $pseudo=$_GET['pseudo'];
            $promouvoir = $db -> prepare("UPDATE utilisateurs SET roleutilisateur= 'Admin' WHERE pseudo=:pseudo");// rendre administrateur la personne 
            $promouvoir-> execute(['pseudo' => $pseudo]);                                                 // dont le pseudo est celui dans la barre de recherche

            echo " <br/> Le compte associé au pseudo " . $pseudo . " a bien été promu administrateur ";
            
        }
        else
        {
            echo " Admin plutôt idiot, tu essayes de promouvoir un compte qui n'existe pas ";
        }
    }
    else 
    {
        header('Location: indedx.php');    
    }

?>
</form>