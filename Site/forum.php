<?php session_start(); ?>          <!-- pour identifier qui est connecté -->

<head>
<link rel="stylesheet" href="CSS/forms.css" />
</head>

<?php include 'includes/menunavigation.php';
      include 'includes/database.php'; ?>

<br/><br/><br/><br/>
<form method="post">
<input type="textarea" name="question" minlength ="10" maxlength="255" style="padding:10px" placeholder =" Si tu as une question à propos d'un évènement ou autre, pose la ici ! " required/><br />
<input type="submit" name="envoi" value = " Envoyer " id="submit">
</form>  <!-- petit form dans lequel entrer sa question -->

<h1> Dernières questions posées </h1>           <!-- affichage des dernières questions posées, auxquelles les admins devront répondre par mail -->

<?php if(isset($_POST['envoi']))    // si une question est envoyée 
{
    extract($_POST);                // on la récupère 

    if (isset($_SESSION['email']))  // si la personne est connectée 
    {
        $q2 = $db -> prepare('SELECT pseudo FROM questions WHERE pseudo=:pseudo');
        $q2 -> execute(['pseudo' => $_SESSION['pseudo']]);
        $nbrquestions = $q2 -> rowCount();              // compter le nombre de questions que la personne a déjà posées

        if($nbrquestions < 2)                           // si il a posé 0 ou 1 question 
        {
            $q3 = $db -> prepare('INSERT INTO questions(Question,pseudo) VALUES (:Question,:pseudo)');
            $q3 -> execute([
                'Question' => $_POST['question'],
                'pseudo' => $_SESSION['pseudo']
            ]); // entrer sa question dans la base de données
        }
        else 
        {
            echo " Tu as déjà posé 2 questions, attends d'obtenir des réponses et que les administrateurs suppriment tes anciennes questions <br/> ";
        }
    }
    else
    {
        echo "Tu n'es pas connecté, tu ne peux pas poser de question.<br/>";
    }
}

echo "<table>";
$q4 = $db -> query('SELECT * FROM questions ');
while ($nice = $q4 -> fetch()) 
{
    echo "<tr>";
    echo "<td>";
    echo $nice['pseudo']. ' demande : ' .$nice['Question'].'<br/>';             // tout ceci n'est qu'un petit affichage des questions présentes dans la base de données 
    echo "</td>";
    echo "</tr>";
} 
echo "</table>";                
?>