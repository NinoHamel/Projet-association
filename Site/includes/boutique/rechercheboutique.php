<?php include "../includes/database.php";
global $db;
?>

<link rel="stylesheet" href="../CSS/recherche.css" />

<a id=back href=boutique.php>Revenir à la page de la boutique</a> <br><br>

<!-- on cherche tous les produits dans la bdd -->
<?php $evenements = $db->query('SELECT titre FROM produits ORDER BY id DESC');           
        
        if(isset($_GET['recherche']) AND !empty($_GET['recherche']))  // si une recherche a été faite 
        {
            $demande = htmlspecialchars($_GET['recherche']); //on récupère ce qu'on a recherché

            //on cherche dans la bdd ce qui contient la demande en titre
            $evenements = $db->query('SELECT titre FROM produits WHERE titre LIKE "%'.$demande.'%" ORDER BY id DESC ');    // on regarde les évenements qui contiennent le mot recherché

            if($evenements->rowCount() == 0)   // si on ne trouve pas de résultat dans le titre
            {
                $evenements = $db->query('SELECT titre FROM produits WHERE CONCAT(titre, descriptio) LIKE"%'.$demande.'%"ORDER BY id DESC '); // aller chercher dans la description aussi
            }
        }

        ?>
        <!-- formulaire recherche / bouton rechercher -->
        <form method="GET">
            <input id=search type="search" name="recherche" placeholder="Rechercher par titre ou description"/>
            <input id=submit type="submit" value="Rechercher"/>
        </form>
        
        
        <?php if($evenements->rowCount()>0) //si on a trouvé des éléments suite aux recherches
        {
            ?>
            <ul>
            <?php while($a=$evenements->fetch()) //on affiche ces éléments
            {
                ?>
                <li> <a href="pageproduit.php?titre=<?php echo $a['titre']; ?>"> <?php echo $a['titre'] ?> </a> </li>
            <?php } ?>
            </ul>
        <?php 
        } 
        else //si on n'a aucun élément
        {
            ?>
            Aucun résultat pour :<?= $demande ?>
        <?php } ?>

    </ul>