<?php 
include "../includes/database.php";
global $db;
?>

<link rel="stylesheet" href="../CSS/recherche.css" />

<a id=back href=evenements.php>Revenir à la page des évenements</a> <br><br>

<?php $evenements = $db->query('SELECT Titre FROM events ORDER BY id DESC');           
        
        if(isset($_GET['recherche']) AND !empty($_GET['recherche']))        // si une recherche a été faite 
        {
            $demande = htmlspecialchars($_GET['recherche']);

            //$demande_array = explode(' ',$demande);
            // var_dump($demande_array);

            $evenements = $db->query('SELECT Titre FROM events WHERE Titre LIKE "%'.$demande.'%" ORDER BY id DESC ');    // on regarde les évenements qui contiennent le mot recherché

            if($evenements->rowCount() == 0)              // si on ne trouve pas de résultat dans le titre
            {
                $evenements = $db->query('SELECT Titre FROM events WHERE CONCAT(Titre, Descriptio, Jeux, Lieu) LIKE"%'.$demande.'%"ORDER BY id DESC '); // aller chercher dans la description, les jeux, ... aussi
            }
        }

        ?>
        <form method="GET">
            <input id=search type="search" name="recherche" placeholder="Rechercher par titre, lieu, catégorie ou description"/>
            <input id=submit type="submit" value="Rechercher"/>
        </form>
        
        
        <?php if($evenements->rowCount()>0)
        {
            ?>
            <ul>
            <?php while($a=$evenements->fetch())
            {
                ?>
                <li> <a href="pagevent.php?Titre=<?php echo$a['Titre']; ?>"> <?php echo $a['Titre'] ?> </a> </li>
            <?php } ?>
            
        <?php 
        } 
        else 
        {
            ?>
            Aucun résultat pour :<?= $demande ?>
        <?php } ?>

    </ul>