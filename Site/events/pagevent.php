<?php session_start(); error_reporting(0);// pour identifier qui s'est connecté ?> 

<?php 
    include '../includes/menunavigation.php'; 
    include '../includes/database.php';
?>

<link rel="stylesheet" href="../CSS/inscription.css" />

<?php 

    $q = $db -> prepare("SELECT * FROM events WHERE Titre=:Titre ");
    $q -> execute(['Titre'=> $_GET['Titre']]);                                  // récupérer toutes les informations de l'event demandé
    $nice = $q -> fetch();

    echo '<div id=box>';

    echo '<h1> Titre:'.$nice['Titre']." </h1> <br/> ";
    echo 'Lieu:'.$nice['Lieu']."<br/>";
    echo 'Date de début:'.$nice['datedebut']."<br/>";
    echo 'Date de fin:'.$nice['datefin']."<br/>";
    echo 'Jeux:'.$nice['Jeux']."<br/>";                                                             // lignes 18 à 25 : affichage des informations de l'évènement 
    echo 'Prix:'.$nice['prix']."<br/>";
    echo 'Nombre de participants:'. $nice['nbr_participants']."<br/><br/>";
    echo 'Description:'.$nice['Descriptio']."<br/><br/><br/>"; 

    $c2 = $db -> prepare('SELECT Eventitre FROM inscriptionsevents WHERE Pseudojoueur = :Pseudojoueur ');     // on va vérifier si le pseudo est déjà existant dans la base de données
    $c2 ->execute(['Pseudojoueur' => $_SESSION['pseudo']]);
    $result_titre = $c2 -> fetch();

    if (isset($_SESSION['email']))          // si il y a une connexion 
    {
        if ( $result_titre['Eventitre'] == $_GET['Titre'])          // si le joueur est inscrit à un évènement avec le même titre que celui obtenu par la méthode GET
        {
            echo ' <h2>Tu es déjà inscrit à cet évenement</h2> ';
        }
        else                                                       // si le joueur n'est pas inscrit à cet évènement 
        {
            ?> <a href="inscriptionevent.php?Titre=<?php echo $nice['Titre']; ?>"> S'inscrire à l'évenement <br/> </a> <!-- lien pour s'inscrire à l'évènement --> 
            <?php
        }
    }
    else
    {
        echo " <h2>Il faut être connecté pour pouvoir s'inscrire à un évènement</h2> ";
    }

echo '</div>';

?>