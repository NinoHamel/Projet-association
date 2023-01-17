<?php 
session_start();
?>

<?php error_reporting(0); ?>

<script src="../JS/javascript.js" defer></script>

<link rel="stylesheet" href="../CSS/modifevent.css" />

<?php
include "../includes/database.php";
?>

<?php 

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin' && 'Tresorier'){

  header('Location: evenements.php');
}
?>

<a id= retour href="evenements.php"> Revenir à la page des événements </a>

<h1>PANNEAU ADMIN DES EVENTS</h1>

<br>

<?php

        $q = $db -> prepare("SELECT * FROM events"); //on affiche tous les events
        $q -> execute();
        
            echo "<table>";

        while($affiche=$q->fetch(PDO::FETCH_OBJ)){

            echo "<tr>";
            echo "<td>";
            echo $affiche->Titre;
            echo "</td>";
            ?>
            <td>
            <a href="?action=modifier&amp;ID=<?= $affiche->ID; ?>">Modifier</a>
            </td>
            <td>
            <a href="?action=suppr&amp;ID=<?= $affiche->ID; ?>">Supprimer</a><br>
            </td>
        </tr>

        <?php     
        }

    echo "</table>";


if($_GET['action']=='modifier') //si on clique sur modifier on affiche un formulaire pour modifier un event
{

    $ID=$_GET['ID'];

    $q = $db -> prepare("SELECT * FROM events WHERE ID=$ID");
    $q -> execute();

    $infos = $q->fetch(PDO::FETCH_OBJ);

    ?>
    <br><br>
    <form action='' method="post">
        <input type="text" name="Titre" ID="Titre" value="<?php echo $infos->Titre; ?>" placeholder="Titre" required><br/>
        <input type="text" name="Lieu" ID="Lieu" value="<?php echo $infos->Lieu; ?>" placeholder="Litre" required><br/>
        <input type="date" name="datedebut" ID="datedebut" value="<?php echo $infos->datedebut; ?>" placeholder="Date de début" required><br/>
        <input type="date" name="datefin" ID="datefin" value="<?php echo $infos->datefin; ?>" placeholder="Date de fin" required><br/>
        <input type="text" name="Jeux" ID="Jeux" value="<?php echo $infos->Jeux; ?>" placeholder="Jeux" required><br/>              <!-- formulaire pour modifier un évènement -->
        <textarea name="Descriptio" ID="Description" placeholder="Description" required><?php echo $infos->Descriptio; ?></textarea><br/>
        <input type="text" name="prix" ID="prix" placeholder="prix" value="<?php echo $infos->prix; ?>" ><br/>
        <input type="submit" name="modifevent" ID="modifevent" value = " Modifier l'event "><br/>
    </form>
    <?php

    if(isset($_POST['modifevent'])){

        $Titre=$_POST['Titre'];
        $Lieu=$_POST['Lieu'];
        $datedebut=$_POST['datedebut'];                     // ici on applique les modifications à l'évènement
        $datefin=$_POST['datefin'];
        $Jeux=$_POST['Jeux'];
        $Descriptio=$_POST['Descriptio'];
        $prix=$_POST['prix'];

        $update = $db->prepare("UPDATE events SET Titre='$Titre',Lieu='$Lieu',datedebut='$datedebut',datefin='$datefin',Jeux='$Jeux',Descriptio='$Descriptio',prix='$prix' WHERE ID=$ID");
        $update->execute();

        header('Location: supprimevent.php');

    }
} 

elseif($_GET['action']=='suppr') //si on clique sur la croix on supprime
{
    $ID=$_GET['ID'];
    $delete = $db -> prepare("DELETE FROM events WHERE ID=$ID");
    $delete -> execute();

    header('Location: supprimevent.php');
} 

    
?>