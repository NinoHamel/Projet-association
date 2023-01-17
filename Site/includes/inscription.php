<?php

  if (isset($_POST['envoi']))       // si il y a eu un envoi de formulaire
  {
    extract($_POST);

    if(!empty($mdp) && !empty($cmdp) && !empty($email))        // si il y a un mot de passe 
    {
        if($mdp==$cmdp)  
        {
            $options = 
            [
              'cost' => 12,
            ];
      
            $hashpass = password_hash($mdp, PASSWORD_BCRYPT, $options);     // cryptage du mot de passe 

            $c = $db -> prepare('SELECT email FROM utilisateurs WHERE email = :email');     // on va vérifier si l'email est déjà existant dans la base de données
            $c ->execute(['email' => $email]);
            ([
                'email' => $email
            ]);

            $c2 = $db -> prepare('SELECT pseudo FROM utilisateurs WHERE pseudo = :pseudo');     // on va vérifier si le pseudo est déjà existant dans la base de données
            $c2 ->execute(['pseudo' => $pseudo]);
            ([
                'pseudo' => $pseudo
            ]);

            $result_email =$c -> rowCount();    // comptage du nombre de lignes ou il y a déjà cet email ( cela peut être 0 )
            $result_pseudo = $c2 -> rowCount(); // comptage du nombre de lignes ou il y a déjà ce pseudo ( cela peut être 0 )

            if($_POST['profession'] == NULL)
            {
              $profession = 'etudiant';       
            }
            else
            {
              $profession = $_POST['profession'];
            }

            if($vdr == NULL)                                              // lignes 33 à 49 : remplir des champs automatiquement si laissés nuls dans le formulaire d'inscription
            {
              $vdr = 'profession definie';
            }
            else
            {
              $vdr = $_POST['vdr'];
            }

            $pfp = "default.png";
            
            $role = 'Membre';
            if ($result_email == 0)
            {
              if ($result_pseudo == 0)
              {
                $q = $db->prepare("INSERT INTO utilisateurs(prenom,nom,pseudo,email,password,roleutilisateur,sexe,DDN,Profession,ville_resid,adresse_comp,pfp) VALUES(:prenom,:nom,:pseudo,:email,:password,:roleutilisateur,:sexe,:DDN,:Profession,:ville_resid,:adresse_comp,:pfp)"); // on indique qu'il faut ajouter un nouvel utilisateur dans la base de données
                $q->execute
                ([
                 'prenom' => $prenom,
                 'nom' => $nom,
                 'pseudo' => $pseudo,
                 'email' => $email,
                 'password' => $hashpass,
                 'roleutilisateur' => $role,        // toutes les informations du nouvel utilisateur à entrer dans la base de données
                 'sexe' => $sexe,
                 'DDN' => $ddn,
                 'Profession' => $profession,
                 'ville_resid' => $vdr,
                 'adresse_comp' => $adresse_comp,
                 'pfp' => $pfp
                ]);
                echo ' Le compte a été crée <br/><br/> ';
              }
              else          // si il y a déjà une occurence du pseudo dans le tableau utilisateurs
              {
                echo ' Ce pseudo est déjà utilisé ';
              }
            } 
            else           // si il y a déjà une occurence de l'email dans le tableau utilisateurs
            {
                echo ' Cet email est déjà utilisé ';
            }
        } 
        else
        {
            echo " Veuillez vous assurer que vous avez entré 2 fois le même mot de passe ";
        } 

    }   
  }
  else
  {
    echo " Remplissez le formulaire ";
  }
 ?>