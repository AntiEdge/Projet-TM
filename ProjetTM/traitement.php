<?php

session_start();

$titre="Tchat online";

require_once("includes/identifiants.php");
require_once("includes/debut.php");



//if(isset($_POST['submit'])){ // si on a envoyé des données avec le formulaire


    if(!empty($_GET['msg'])){ // si les variables ne sont pas vides

        $message = $_GET['msg'];
        $id_receveur = $_GET['id'];

         // on sécurise nos données

        // puis on entre les données en base de données :
        $query=$db->prepare('INSERT INTO tchat (id_pseudo, id_receveur, message, date_message) VALUES (?,?,?,now())');
  	    $query->execute(array($_SESSION['id'], $id_receveur, $message));
  	    $query->CloseCursor();

    }
    else{
        echo "Vous avez oublié de remplir un des champs !";
    }

//}

?>
