<?php session_start() // on démarre la session car on va faire une vérification sur la personne qui démarre cette page ?>
<a href='boutique.php'>Retourner à la boutique<br/></a>

<link rel="stylesheet" href="../CSS/info.css" />

<?php

    include '../includes/database.php';

    if (isset($_SESSION['email'])) //s'il y a eu une connexion on autorise de continuer (sécurité)
    {
        if (isset($_GET['montant']))  //s'il y a bien une commande d'effectuée     
        {
            $montant = $_GET['montant'];
            
                echo "Merci à toi ". $_SESSION['pseudo'] ." pour cet achat, tu t'apprêtes à dépenser ".$montant." bobux.";
                ?>
            <!-- forumulaire carte bancaire -->
            <form method="post">
                <input type="text" name="numcarte" placeholder="Numéro de carte bobux" required><br/>
                <input type="text" name="dateexpi" placeholder="Date d'expiration" required><br/>
                <input type="text" name="cvc" placeholder="CVC ( code de sécurité au dos de la carte bobux )." required><br/>
                <input type="submit" name="envoi" value="Procéder au payement">
            </form>
            <?php

    
            if (isset($_POST['envoi'])) //si on appuie sur le bouton envoyer du formulaire
            {

                $nbproduits = count($_SESSION['panier']['titre']); //nombre d'éléments = nombre de produits

                for($i = 0; $i<$nbproduits; $i++){ 

                    //on récupère les valeurs de chaque produit du panier
                    $titre = $_SESSION['panier']['titre'][$i];
                    $nbrachats = $_SESSION['panier']['quantite'][$i];
                    
                    //récupérer les infos de la bdd afin de pouvoir les mettre à jour
                    $q = $db -> prepare("SELECT stock,nbrachats FROM produits WHERE titre=:titre");
                    $q -> execute(array('titre' =>  $titre));
                    $infosbdd = $q -> fetch();

                    //nouvelles valeurs de la bdd
                    $nouveau_stock = $infosbdd['stock'] - $nbrachats;
                    $nouveau_achats = $infosbdd['nbrachats'] + $nbrachats;
                    
                    //actualisation de la table produit dans la bdd
                    $ajoutachat = $db->prepare("UPDATE produits SET nbrachats = $nouveau_achats, stock = $nouveau_stock WHERE titre = :titre ");
                    $ajoutachat->execute(array(':titre' => $titre));

                    //actualisation de la table argent dans la bdd
                    $update = $db ->prepare( "UPDATE argent SET argent=argent+$montant WHERE 1");
                    $update -> execute();
                }

                echo 'Achat réussi mon cher '. $_SESSION['pseudo'] .' tu vas maintenant être redirigé vers la boutique.';
                header("Refresh: 2; URL=boutique.php");
                unset($_SESSION['panier']); //on supprime le panier
            }
            else //si on a pas rempli le formulaire
                {
                    echo 'Remplis le formulaire avec tes informations BOBUX pour procéder au payement. ';
                }
            }
        else //si le panier est vide
        {
            echo " Erreur, réessaye de remplir le panier avec des produits ";
        }
        
    }
    else //si on est pas connecté
    {
        echo " Il faut être connecté pour pouvoir acheter des produits ";
    }

?>
