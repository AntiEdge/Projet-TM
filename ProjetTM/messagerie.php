<?php
session_start();
$titre="Messages Privés";
include("includes/identifiants.php");
include("includes/debut.php");
include("includes/header.php");

$action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):''; //On récupère la valeur de la variable $action
 
switch($action)
{
	case "consulter": //1er cas : on veut lire un mp
		
		echo'<p><i>Vous êtes ici</i> : <a href="./index.php">Index</a> --> <a href="./messagerie.php">Messagerie privée</a> --> Consulter un message</p>';
	    $id_mess = (int) $_GET['id']; //On récupère la valeur de l'id
	    echo '<h1>Consulter un message</h1><br /><br />';

	    //La requête nous permet d'obtenir les infos sur ce message :
	    $query = $db->prepare('SELECT  msg_expediteur, msg_receveur, msg_titre,               
	    msg_time, msg_text, msg_lu, membre_id, membre_pseudo
	    FROM messages
	    LEFT JOIN membres ON membre_id = msg_expediteur
	    WHERE msg_id = :id');
	    $query->bindValue(':id',$id_mess,PDO::PARAM_INT);
	    $query->execute();
	    $data=$query->fetch();

	    //On vérifie que seul le receveur du mp peut le lire !
	    if ($id != $data['mp_receveur']) erreur(ERR_WRONG_USER);
	       
	    //bouton de réponse
	    echo'<p><a href="./messagerie.php?action=repondre&amp;dest='.$data['msg_expediteur'].'">
	    <img src="./images/repondre.gif" alt="Répondre" 
	    title="Répondre à ce message" /></a></p>';

	    <table>     
		    <tr>
		    <th class="vt_auteur"><strong>Auteur</strong></th>             
		    <th class="vt_mess"><strong>Message</strong></th>       
		    </tr>
		    <tr>
		    <td>
		    <?php echo'<strong>
		    <a href="./voirprofil.php?m='.$data['membre_id'].'&amp;action=consulter">
		    '.stripslashes(htmlspecialchars($data['membre_pseudo'])).'</a></strong></td>
		    <td>Posté à '.date('H\hi \l\e d M Y',$data['mp_time']).'</td>';
		    ?>
		    </tr>
		    <tr>
		    <td>
		    <?php
		        
		    //Ici des infos sur le membre qui a envoyé le mp
		    echo'<p><img src="./images/avatars/'.$data['membre_avatar'].'" alt="" />
		    <br />Membre inscrit le '.date('d/m/Y',$data['membre_inscrit']).'
		    <br />Messages : '.$data['membre_post'].'
		    <br />Localisation : '.stripslashes(htmlspecialchars($data['membre_localisation'])).'</p>
		    </td><td>';
		        
		    echo code(nl2br(stripslashes(htmlspecialchars($data['mp_text'])))).'
		    <hr />'.code(nl2br(stripslashes(htmlspecialchars($data['membre_signature'])))).'
		    </td></tr></table>';


	break;
	 
	case "nouveau": //2eme cas : on veut poster un nouveau mp
	//Ici on a besoin de la valeur d'aucune variable :p
	break;
	 
	case "repondre": //3eme cas : on veut répondre à un mp reçu
	//Ici on a besoin de la valeur de l'id du membre qui nous a posté un mp
	break;
	 
	case "supprimer": //4eme cas : on veut supprimer un mp reçu
	//Ici on a besoin de la valeur de l'id du mp à supprimer
	break;
	 
	default; //Si rien n'est demandé ou s'il y a une erreur dans l'url, on affiche la boite de mp.
	 
	} //fin du switch
?>

