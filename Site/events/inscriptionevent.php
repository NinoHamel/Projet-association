<?php session_start() // on démarre la session car on va faire une vérification sur la personne qui démarre cette page ?>
<a href='evenements.php'>Retourner à la page des évènements</a>

<link rel="stylesheet" href="../CSS/info.css" />

<?php

    include '../includes/database.php';

    $titre = $_GET['Titre'];

    $q = $db -> prepare("SELECT nbr_participants FROM events WHERE Titre=:Titre ");
    $q -> execute(['Titre'=> $_GET['Titre']]);
    $resultat = $q -> fetch();

    $nouveaunbr = $resultat['nbr_participants'] + 1;

    if (isset($_SESSION['email']))
    {
        if (isset($_GET['Titre']))             
        {
            $updateparticipants = $db -> prepare("UPDATE events SET nbr_participants =:nouveaunbr WHERE Titre = :titre");
            $updateparticipants -> execute(
                ['titre'=>$titre,
                'nouveaunbr'=>$nouveaunbr
                ]);

            $inscrire = $db -> prepare('INSERT INTO inscriptionsevents(Eventitre,Pseudojoueur) VALUES (:Eventitre,:Pseudojoueur)');
            $inscrire -> execute([
                'Eventitre' => $titre,
                'Pseudojoueur' => $_SESSION['pseudo']
                ]);

            echo " <br/> Tu es maintenant inscrit à l'évènement " . $titre;
        }
        else
        {
            echo " Erreur, réessaye de t'inscrire en retournant à la page des évènements ";
        }
    }
    else
    {
        echo " Il faut être connecté pour pouvoir s'inscrire à un évènement ";
    }
?>

