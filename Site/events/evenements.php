<?php
    use Twig\Node\Expression\Test\NullTest;
    session_start() 
?>

<?php error_reporting(0); ?>

<?php 
    include '../includes/menunavigation.php';
    include '../includes/database.php';
?>

<a href="pagerechercheevent.php"> Rerchercher un évènement. </a> <br/><br/><br/><br/>

Cliquez sur le titre d'un évènement pour accéder à ses informations où vous inscrire à cet évènement.

<link rel="stylesheet" href="../CSS/event.css" />
<script src="../JS/javascript.js" defer></script>
<br/>

<?php 

    if($_SESSION['role'] == 'Admin')
    {
        ?><br/> <br/><a href="javascript:popupBasique('popup.php')" class=nospace>Création d'évenement</a>  <!-- Lien pour la création d'évènements -->
                     <a href="javascript:popupBasique('supprimevent.php')">Modifier ou supprimer un évènement</a> <!-- Lien pour la modification/suppresion d'évènements -->
        <?php echo "<br/>"; 
    }
    else
    {
        //ici, il n'y à rien à écrire, si le rôle n'est pas admin, on affiche simplement tous les évènements
    }

    if (isset($_POST['newevt']))
    {
        if ($_POST['prix'] == NULL)
        {
            $prix = 'aucun';
        }
        else
        {
            $prix = $_POST['prix'];
        }

        $nbrparti = 0;

        $q2 = $db -> prepare("INSERT INTO events(Titre,Lieu,datedebut,datefin,Jeux,Descriptio,prix,nbr_participants) VALUES (:Titre,:Lieu,:datedebut,:datefin,:Jeux,:Descriptio,:prix,:nbr_participants) ");
        $q2 -> execute([
        'Titre' => $_POST['titre'],
        'Lieu' => $_POST['lieu'],
        'datedebut' => $_POST['ddd'],
        'datefin' => $_POST['ddf'],
        'Jeux' => $_POST['jeux'],
        'Descriptio' => $_POST['description'],
        'prix' => $prix,
        'nbr_participants' => $nbrparti
        ]);

        echo 'Evenement crée !';
    }

    $q4 = $db -> query("SELECT COUNT(*) FROM events ");
    $nbrlignes = $q4 -> fetch();

    $q = $db -> query('SELECT * FROM events ');
    while ($nice = $q -> fetch()) 
    {
        echo '<div id=event>';
        echo '<div id=div2>';

        ?><a href="pagevent.php?Titre=<?php echo $nice['Titre']; ?>" style="font-size:120%; background-color:white; border:none; text-align:center; color:black" > <?php echo '<p id=titre> Titre:'.$nice['Titre']." <p>  "; ?> </a> <?php
        echo 'Lieu: '.$nice['Lieu']."<br/>";
        echo 'Date de début: '.$nice['datedebut']."<br/>";
        echo 'Date de fin: '.$nice['datefin']."<br/>";
        echo 'Jeux: '.$nice['Jeux']."<br/>";
        echo 'Prix: '.$nice['prix']."<br/>";
        echo 'Nombre de participants: '. $nice['nbr_participants']."<br/><br/><br/><br/>"; 

    echo '</div>';
    echo '</div>';
    }

    
?>


