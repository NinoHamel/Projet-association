<?php

    define('HOST','localhost');
    define('DB_NAME','projet');
    define('USER','root');
    define('PASS','');

    try // connexion à la base de données 
    {
        $db= new PDO('mysql:host=' . HOST . ";dbname=" . DB_NAME, USER, PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // on affiche les erreurs qui peuvent apparaître 
    }
    catch(PDOException $error) // si il y a une erreur, on la récupère
    {
        echo $error;
    }

?>