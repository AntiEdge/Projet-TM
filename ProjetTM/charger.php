<?php

session_start();

$titre="Tchat online";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

if(!empty($_GET['id'])){ // on vérifie que l'id est bien présent et pas vide

    $id = (int) $_GET['id']; // on s'assure que c'est un nombre
    $id_receveur = (int) $_GET['idd'];

    // on récupère les messages ayant un id plus grand que celui donné

    $requete = $db->prepare("SELECT t.*, m.membre_pseudo FROM tchat t LEFT JOIN membres m ON m.membre_id = t.id_pseudo WHERE ((id_receveur = ? AND id_pseudo = ?) OR (id_receveur = ? AND id_pseudo = ?)) AND t.id > ? ORDER BY id ASC");
    $requete->execute(array($id_receveur, $_SESSION['id'], $_SESSION['id'] , $id_receveur, $id));
    $donnees = $requete->fetchAll();

    $messages = null;

    // on inscrit tous les nouveaux messages dans une variable
    foreach($donnees as $d){
      $date_message = $d['date_message'];
      // on affiche le message (l'id servira plus tard)
      if(isset($_SESSION['id']) && $d['id_pseudo'] == $_SESSION['id']) { ?>

        <div style="float: right; width: auto; max-width: 80%; margin-right: 26px; position: relative;padding: 7px 20px; color: #fff; background: #0093F6; border-radius: 5px; margin-bottom: 15px; clear: both;">

            <?php echo "<p id=\"" . $d['id'] . "\">" . $d['message'] . "</p>"; ?>

          <div style="font-size: 10px; text-align: right; margin-top: 10px;">Par <?= $d['membre_pseudo']?>, le <?= $date_message ?></div>

        </div>
        <?php
      }else{
        ?>
        <div style="position: relative; padding: 7px 20px; background: #E5E5EA; border-radius: 5px; color: #000; float: left; width: auto; max-width: 80%; margin-left: 10px; margin-bottom: 15px; clear: both;">

          <?php echo "<p id=\"" . $d['id'] . "\">" . $d['message'] . "</p>"; ?>

          <div style="font-size: 10px; text-align: right; margin-top: 10px;">Par <?= $d['membre_pseudo']?>, le <?= $date_message ?></div>
        </div>
        <?php
      }
    }

    echo $messages; // enfin, on retourne les messages à notre script JS

}

?>
