<?php session_start();      

include 'includes/database.php';

error_reporting(0);

$q = $db -> prepare('SELECT roleutilisateur,pseudo FROM utilisateurs WHERE email=:email');
$q -> execute(['email' => $_SESSION['email']]);             // on vérifie qui est connecté et on va plus tard vérifier son rôle 
$recuprole = $q -> fetch();

?>

<link rel="stylesheet" href="CSS/admin.css" />

<?php

    if ($_SESSION['role'] == 'Admin')       // si la personne connectée est un admin 
    {
        $pseudo = $recuprole['pseudo'];
        echo ' Bonjour admin ' . $pseudo . ', voici la liste des utilisateurs et leurs informations :' ?><br/> <?php ;

        $q2 = $db -> query("SELECT COUNT(*) FROM utilisateurs ");
        $nbrlignes = $q2 -> fetch();            // nommbre de lignes dans le tableau utilisateurs 

        echo "Nombre d'utilisateurs inscrits : " . $nbrlignes['COUNT(*)'] . "<br/><br/>";

        $q3 = $db -> query('SELECT * FROM utilisateurs ');
        while ($all = $q3 -> fetch()) 
        {  
            $q4 = $db -> prepare("SELECT * FROM inscriptionsevents WHERE Pseudojoueur = :pseudo ");
            $q4 -> execute(['pseudo' => $all['pseudo']]);          
            echo "<div class=user>";
            echo $all['Prenom'].' ';
            echo $all['Nom']."<br/>";
            echo $all['roleutilisateur']."<br/>";
            echo $all['pseudo']."<br/>";
            echo $all['email']."<br/>";
            echo $all['password']."<br/>";
            echo $all['Sexe']."<br/>";
            echo $all['DDN']."<br/>";
            echo $all['Profession']."<br/>";
            echo $all['ville_resid']."<br/>";
            echo $all['adresse_comp']."<br/><br/>";         // affichage de toutes les personnes présentes dans le tableau utilisateurs grâce au while 
            while ($evenements = $q4 -> fetch()) 
            {
            echo $all['pseudo']." est inscrit à " . $evenements['Eventitre'] . "<br/>";         // affichage des évènements auxquels la personne est inscrite  
            }
            ?>
            <div class=action>
            <a href="supprimer.php?pseudo=<?php echo $all['pseudo']; ?>"> Supprimer utilisateur <br/> </a>  
            <a href="upadmin.php?pseudo=<?php echo $all['pseudo']; ?>"> Promouvoir administrateur <br/></a> 
            <a href="uptresorier.php?pseudo=<?php echo $all['pseudo']; ?>"> Promouvoir trésorier <br/></a>
            <a href="upancienmembre.php?pseudo=<?php echo $all['pseudo']; ?>"> Promouvoir ancien membre <br/><br/><br/><br/></a> 
            </div> <!-- rien à dire pour les 4 lignes du dessus, elles sont évidentes --> 
            <?php
            echo "</div>";
        }           
                        
    }
    else
    {
        header('Location: index.php');
    }
?>