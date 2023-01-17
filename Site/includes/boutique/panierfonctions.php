<?php

    function creationpanier(){ //s'il n'y pas de panier def, on en créer un, sinon on renvoie vrai

        if(!isset($_SESSION['panier'])){

            $_SESSION['panier'] = array();
            $_SESSION['panier']['titre'] = array();
            $_SESSION['panier']['quantite'] = array();
            $_SESSION['panier']['prix'] = array();

        }

        return true;

    }

    function ajoutarticle($titre,$quantite,$prix){ 

        if(creationpanier()){

            $position_produit = array_search($titre,$_SESSION['panier']['titre']);

            if($position_produit !== false){

                $_SESSION['panier']['quantite'][$position_produit] += $quantite;

            }else{

                array_push($_SESSION['panier']['titre'],$titre);
                array_push($_SESSION['panier']['quantite'],$quantite);
                array_push($_SESSION['panier']['prix'],$prix);

            }

        }else{

            echo 'Erreur, ajout d\'un produit qui n\'nest pas dans le panier';

        }
     }

    function modifierarticle($titre,$quantite){ 

        if(creationpanier()){

            if($quantite>0){

                //on cherche dans le panier, la position de l'article à modifier
                $position_produit = array_search($titre, $_SESSION['panier']['titre']);
                
                if($position_produit !== false){

                    $_SESSION['panier']['quantite'][$position_produit] = $quantite;
                    
                }

            }else{ //= on met la quantité à 0 --> on supprime
                supprimerarticle($titre);
            }

        }else{

            echo 'Erreur, vous essayez de modifier un produit qui n\'nest pas dans le panier';

        }

    }

    function supprimerarticle($titre){ //supprime un article du panier

        if(creationpanier()){

            $temp = array();
            $temp['titre'] = array();
            $temp['quantite'] = array();
            $temp['prix'] = array();

            //on refait un panier avec l'élément qu'on veut supprimer en moins
            for($i=0; $i<count($_SESSION['panier']['titre']); $i++){

                if($_SESSION['panier']['titre'][$i] !== $titre){

                    array_push($temp['titre'],$_SESSION['panier']['titre'][$i]);
                    array_push($temp['quantite'],$_SESSION['panier']['quantite'][$i]);
                    array_push($temp['prix'],$_SESSION['panier']['prix'][$i]);

                }

            }
          
            //remplace l'ancien panier avec le nouveau
            $_SESSION['panier'] = $temp;

            unset($temp);

        }else{

        echo 'Erreur, vous essayez de supprimer un produit qui n\'nest pas dans le panier';

        }

    }

    function montanttotal(){ //calcul le montant total du panier

        $total =0;

        for($i=0; $i<count($_SESSION['panier']['titre']); $i++){

            $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];

        }

        return $total;

    }

    function supprimerpanier(){ //supprime le panier

            unset($_SESSION['panier']);

    }

?>