<link rel="stylesheet" href="CSS/info.css" />

<?php session_start() // on démarre la session car on va faire une vérification sur la personne qui démarre cette page ?>
<form name="supprimer">
<a href='admin.php'>Retourner à la page d'administration</a>

<?php

    include 'includes/database.php';

    if ($_SESSION['role'] == 'Admin')           // si la personne connectée est bien un admin 
    {
        if (isset($_GET['pseudo']))             
        {
            $pseudo=$_GET['pseudo'];
            $supprimer = $db -> prepare('DELETE FROM utilisateurs WHERE pseudo=:pseudo');           // supprimer l'utilisateur dont le pseudo est celui dans la barre de recherche
            $supprimer-> execute(['pseudo' => $pseudo]);

            echo " <br/> Le compte associé au pseudo " . $pseudo . " a bien été supprimé ";
        }
        else
        {
            echo " Admin plutôt idiot, tu essayes de supprimer un compte qui n'existe pas ";
        }
    }
    else 
    {
        header('Location: index.php');    
    }

?>
</form>