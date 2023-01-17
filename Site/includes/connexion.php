<?php 
session_start();

$_SESSION['email'] = $_POST['email2'];      // si quelqu'un se connecte, la variable de session aura toujours cette valeur pour toutes les pages qu'il visitera après

$q = $db -> prepare('SELECT roleutilisateur,pseudo,id FROM utilisateurs WHERE email=:email');
$q -> execute(['email' => $_SESSION['email']]);
$recuprole = $q -> fetch();

$_SESSION['pseudo'] = $recuprole['pseudo'];
$_SESSION['id'] = $recuprole['id'];
$_SESSION['role'] = $recuprole['roleutilisateur'];
?>

<?php

    if(isset($_POST['connexion']))  // si les informations de connexion sont envoyées  
    {
        extract($_POST);            // on récupère les informations du formulaire 

        if(!empty($email2) && !empty($mdp2))         // si l'email et le mot de passe ont été entrés 
        {
            $q = $db -> prepare ("SELECT * FROM utilisateurs WHERE email = :email");            // on va vérifier si l'email est bien existant dans la base de données
            $q -> execute (['email' => $email2]);
            $result = $q -> fetch();                   

            if( $result == true )                        // si le compte existe 
            {
                $hashpassword = $result['password'];    // on crée une variable qui récupère le mot de passe crypté dans la base de données
                if(password_verify($mdp2,$hashpassword))    // si le mot de passe en clair correspond bien au mot de passe crypté
                {
                    echo " Connexion réussie mon cher  ";

                    $p = $db -> prepare("SELECT pseudo FROM utilisateurs WHERE email = :email");   // à partir de la on va chercher à récupérer le pseudo en fonction de l'adresse
                    $p -> execute (['email' => $email2]);                                          // mail de la personne connectée
                    $resultat = $p -> fetch();                                                     
                    
                    $pseudo=$resultat['pseudo'];
                    print_r($pseudo . ', redirection en cours ...');                                                  // on affiche la case du tableau qui contient le pseudo
                    
                    echo '<script>
                    var elem = document.getElementById("barre");
                    var width = 1;
                    var id = setInterval(frame, 10);
                    function frame() {
                        if (width >= 100) {
                        clearInterval(id);
                        } else {
                        width++;
                        elem.style.width = width + "%";
                        }
                    }
                    </script>';
                    
                    header("Refresh: 2; URL=index.php");// la connexion est réussie, on notifie l'utilisateur et 2 secondes après il est redirigé vers la page d'accueil

                    exit();
                }
                else
                {
                    echo " Le mot de passe entré n'est pas associé à cette adresse email ";
                }
            }
            else
            {
                echo "Le compte associé à l'email " . $email2 . " n'existe pas ";
            }

        }
        else
        {
            echo " Veuillez compléter l'ensemble des champs ";
        }
    }
?>