<?php include"includes/database.php";
global $db;
?>

<?php $evenements = $db->query('SELECT titre FROM events ORDER BY id DESC');           
        
        if(isset($_GET['recherche']) AND !empty($_GET['recherche']))        // si une recherche a été faite 
        {
            $demande = htmlspecialchars($_GET['recherche']);

            //$demande_array = explode(' ',$demande);
            // var_dump($demande_array);

            $evenements = $db->query('SELECT Titre FROM events WHERE titre LIKE "%'.$demande.'%" ORDER BY id DESC ');    // on regarde les évenements qui contiennent le mot recherché

            if($evenements->rowCount == 0)              // si on ne trouve pas de résultat dans le titre
            {
                $evenements = $db->query('SELECT Titre FROM events WHERE CONCAT(Titre, description) LIKE"%'.$demande.'%"ORDER BY id DESC '); // aller chercher dans la description aussi
            }
        }

        ?>
        <form method="GET">
            <input type="search" name="recherche" placeholder="Rechercher"/>
            <input type="submit" value="Rechercher"/>                       <!-- formulaire dans lequel est mise la recerche -->
        </form>
        
        
        <?php if($evenements->rowCount()>0)
        {
            ?>
            <ul>
            <?php while($a=$evenements->fetch())
            {
                ?>
                <li> <?= $a['Titre'] ?> <br/> <?= $a['concatenation']; ?> </li>
            <?php } ?>
            </ul>
        <?php 
        } 
        else 
        {
            ?>
            Aucun résultat pour :<?= $demande ?>
        <?php } ?>

    </ul>