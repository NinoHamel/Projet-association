<?php

use Twig\Extension\EscaperExtension;
           

?>

<link rel="stylesheet" href="CSS/fiche.css" />

<?php include 'includes/menunavigation.php';?>

<?php 
    include 'includes/database.php';

if($_GET['pseudo']!=NULL) // si la méthode get permet d'obtenir un pseudo 
{
    $ptinom = $_GET['pseudo'];

    $p = $db -> prepare("SELECT Prenom,Nom,pseudo,sexe,roleutilisateur,DDN,Profession,ville_resid,adresse_comp,password,pfp FROM utilisateurs WHERE pseudo = :pseudo");   // récupérer dans la base de données les infos de la personne ayant le pseudo
    $p -> execute (['pseudo' => $ptinom]);                                                                                                                                // erécupéré par la méthode GET
    $resultat = $p -> fetch();                                                     // on transforme l'instruction en tableau 


    ?><img class=none id=none src = "avatars/<?php echo $resultat['pfp'];?>"

    
<?php
    echo "<div class=box id=infos> <br>";
    echo "<div class=box id=infos> <br><br><br><br>";
    echo $resultat['pseudo']."<br/><br><br>";
    echo $resultat['sexe']."<br/><br><br>";                                     
    echo $resultat['DDN']."<br/><br><br>";
    echo $resultat['Profession']."<br/><br><br>";                                
    echo $resultat['ville_resid']."<br/><br><br>";    
    echo $resultat['roleutilisateur']."<br/><br>";                          // affichage des informations publiques pour n'importe qui
    echo "</div>";
    echo "</div>";

   
    if($_GET['pseudo'] == $_SESSION['pseudo'])         // si le pseudo obtenu par la méthode GET est aussi celui de la personne connectée 
    {
        echo "<br><br><div class=box id=perso><br><br><br><br>";
        echo $resultat['Prenom']." ".$resultat['Nom']."<br/><br><br>";              // affichage des informations personnelles 
        echo $resultat['adresse_comp']."<br/><br>";
        echo "</div><br><br>";
        ?>
        <div class=box id=mdp>
     <form method="post">
		<input type="password" name="mdpactuel" id="mdpactuel" placeholder="Mot de passe actuel" required/><br> 
        <input type="password" name="nvmdp" id="nvmdp" placeholder="Nouveau mot de passe" required/><br>
        <input type="password" name="cnvmdp" id="cnvmdp" placeholder="Confirmation noveau mot de passe" required/><br>   <!-- formulaire de changement de mot de passe -->
        <input type="submit" name="envoi" id="envoi" value = "Changer votre mot de passe"><br/>
    </form>

    <form method="post" enctype="multipart/form-data">  <!-- enctype="multipart/form-data" est nécessaire si on touche à des images -->
        <input type="file" name="pfp" required/><br/>
        <input type="submit" name="envoipfp" value = " Changer de photo de profil "><br/>           <!-- formulaire pour changer sa photo de profil -->
    </form>
        </div>
    <?php
    }
    else
    {
        echo '';
    }
    if(isset($_POST['envoi']))  // si les informations de changement de mot de passe sont envoyées
    {
        extract($_POST);    // extraire les données du formulaire 

            if($nvmdp==$cnvmdp)     // si nouveau mot de passe et confirmation nouveau mot de passe sont identiques 
            {
                $p3 = $db -> prepare ("SELECT password,email FROM utilisateurs WHERE pseudo = :pseudo");  // on sélectionne le mot de passe associé à ce pseudo
                $p3 -> execute (['pseudo' => $_SESSION['pseudo']]); // sélectionner le mot de passe de la personne connectée
                $result = $p3 -> fetch(); 
                
                $hashpassword = $result['password'];    // on crée une variable qui récupère le mot de passe crypté dans la base de données
                if(password_verify($mdpactuel,$hashpassword))   // password_verify vérifie qu'un mot de passe correspond à un hachage 
                {
                    $options = 
                    [
                    'cost' => 12,
                    ];

                    $hashnewpassword = password_hash($nvmdp, PASSWORD_BCRYPT, $options); // on encode le nouveau mot de passe 

                    $changementmdp = $db->prepare("UPDATE utilisateurs SET password=:password WHERE pseudo = :pseudo "); // on l'insère dans la base de données 
                    $changementmdp -> execute([
                        'password' => $hashnewpassword,
                        'pseudo' => $_SESSION['pseudo']
                        ]); // pour la personne connectée, on change le mdp avec le nouveau mot de passe haché 

                    echo ' Votre mot de passe a été modifié ';
                }
                else
                {
                    echo " Votre mot de passe actuel n'est pas celui que vous avez entré ";
                }
            }
            else
            {
                echo ' Veuillez entrer deux fois le même nouveau mot de passe ';
            }
    }
    else
    {
        echo '';
    }  

if(isset($_FILES['pfp']) AND !empty($_FILES['pfp']['name']))
{
    $tailleMax = 2097152; // limite de 2 Mo
    $extensionsValides = array('jpg', 'jpeg', 'gif', 'png'); // les extensions possibles des photos de profil

    if( $_FILES['pfp']['size'] <= $tailleMax)     // on vérifie la taille de l'image
    {
        $extensionUpload = strtolower(substr(strrchr($_FILES['pfp']['name'], '.'), 1));  // formalité pour vérifier l'extension
        if(in_array($extensionUpload, $extensionsValides))  // on vérifie le format grâce au tableau qu'on a crée plus tôt
        {
            $chemin='avatars/'.$_SESSION['id'].".".$extensionUpload;        //nom qu'il va falloir donner à la photo de profil et où il va falloir la mettre
            $resultat = move_uploaded_file($_FILES['pfp']['tmp_name'], $chemin); // on déplace le fichier uploadé vers notre nouvelle destination, tmp signifie temporary
            if($resultat)
            { 
                $updatePfp = $db -> prepare("UPDATE utilisateurs SET pfp = :pfp WHERE id = :id ");
                $updatePfp -> execute(array(
                'pfp' => $_SESSION['id'].".".$extensionUpload,      
                'id' => $_SESSION['id']
                ));     // on a inséré la nouvelle photo de profil par rapport à l'id de la personne connectée et on peut maintenant l'afficher
                echo "Rafraichis la page si ta nouvelle image de profil n'apparait pas";
            }
            else
            {
                echo " Erreur durant l'importation de ta photo de profil, réessaye. ";
            }
        }
        else
        {
            echo 'Ta photo de profil doit être au format jpg, jpeg, gif ou png.';
        }
    }
    else
    {
        echo ' Ta photo de profil ne doit pas dépasser 2 Mo';
    } 
}

}
?>