<?php

session_start();

$titre="Profil de ";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

$utilisateur_id = (int) trim($_GET['id']);

if (empty($utilisateur_id)) {

	header('location: ./membre.php');
	exit;

}

if(isset($_SESSION['id'])){

	$req = $db->prepare("SELECT m.*, r.id_receveur, r.id_demandeur, r.statut, r.id_bloqueur
	FROM membres m
	LEFT JOIN relation r ON (id_receveur = m.membre_id AND id_demandeur = :id1) OR (id_receveur = :id1 AND id_demandeur = m.membre_id)
	WHERE m.membre_id = :id2");
	$req->execute(array('id2'=>$utilisateur_id, 'id1'=>$_SESSION['id']));

}else {

	$req = $db->prepare("SELECT m.*
	FROM membres m
	WHERE m.membre_id = :id1");
	$req->execute(array('id1'=>$utilisateur_id));

}

$voir_utilisateur = $req->fetch();

if(!isset($voir_utilisateur['membre_id'])){

	header('location: ./membre.php');
	exit;

}

if(!empty($_POST)){

	if(isset($_POST['envoyer'])){

		header("location:messagerie2.php?pseudo=" . $voir_utilisateur['membre_pseudo'] . "");

	}

	if(isset($_POST['user-ajouter'])){

		try {
		$i=0;
		$query=$db->prepare('SELECT id FROM relation WHERE (id_receveur = ? AND id_demandeur = ?) OR (id_receveur = ? AND id_demandeur = ?)');
	    $query->execute(array($voir_utilisateur['membre_id'], $_SESSION['id'], $_SESSION['id'], $voir_utilisateur['membre_id']));
	    $verif_relation=$req->fetch();
	    $query->CloseCursor();
		}catch(PDOException $e){

			echo $e->getMessage();

		}

	    if(isset($verif_relation['id']))
	    {
	    	echo 3;
	        $relation_erreur1 = "Vous avez déjà une relation";
	        $i++;
	    }

	    if ($i==0)
	    {
	    	try{
	        $query=$db->prepare('INSERT INTO relation (id_demandeur, id_receveur, statut) VALUES (?,?,?)');
	        $query->execute(array($_SESSION['id'],$voir_utilisateur['membre_id'],1));
	        $query->CloseCursor();

					$query=$db->prepare('INSERT INTO notification (sujet,texte,statut,id_user) VALUES (?,?,?,?)');
	        $query->execute(array('Nouvelle demande d\'ami','yo',0,$voir_utilisateur['membre_id']));
	        $query->CloseCursor();

	        //header('location: ./membre.php');
					header('location:voirprofil.php?id=' . $voir_utilisateur['membre_id']);
	        exit;
	    	}catch(PDOException $e){

	    		echo $e->getMessage();

	    	}
	    }
	    else
    	{

	     	//header('location: ./membre.php');
	      header('location:voirprofil.php?id=' . $voir_utilisateur['membre_id']);
	      exit;

    	}

	}elseif(isset($_POST['user-supprimer'])){

		$query=$db->prepare("DELETE FROM relation WHERE (id_receveur = ? AND id_demandeur = ?) OR (id_receveur = ? AND id_demandeur = ?)");
	    $query->execute(array($voir_utilisateur['membre_id'], $_SESSION['id'], $_SESSION['id'], $voir_utilisateur['membre_id']));
	    $query->CloseCursor();

	    //header('location: ./membre.php');
	    header('location:voirprofil.php?id=' . $voir_utilisateur['membre_id']);
	    exit;

	}elseif(isset($_POST['user-bloquer'])){

	    /*$query=$db->prepare('SELECT id FROM relation WHERE (id_receveur = :id1 AND id_demandeur = :id2) OR (id_receveur = :id2 AND id_demandeur = :id1)');
	    $query->execute(array('id1' => $voir_utilisateur['membre_id'], 'id2' => $_SESSION['id']));
	    $verif_relation=$req->fetch();
	    if(isset($verif_relation['id'])){
		    $query=$db->prepare('UPDATE relation SET id_bloqueur = ? WHERE id = ?');
		    $query->execute(array($voir_utilisateur['membre_id'], $verif_relation['id']));
	    }else{
	    	$query=$db->prepare('INSERT INTO relation (id_demandeur, id_receveur, statut, id_bloqueur) VALUES (?,?,?,?)');
		    $query->execute(array($_SESSION['id'], $voir_utilisateur['membre_id'], 3, $voir_utilisateur['membre_id']));
	    }
	    header('location: ./membre.php');
	    //header('location : ./voirprofil.php?id=' . $voir_utilisateur['membre_id']);
	    exit;*/

	    $query=$db->prepare("DELETE FROM relation WHERE (id_receveur = ? AND id_demandeur = ?) OR (id_receveur = ? AND id_demandeur = ?)");
	    $query->execute(array($voir_utilisateur['membre_id'], $_SESSION['id'], $_SESSION['id'], $voir_utilisateur['membre_id']));

	    $query=$db->prepare('INSERT INTO relation (id_demandeur, id_receveur, statut, id_bloqueur) VALUES (?,?,?,?)');
	    $query->execute(array($_SESSION['id'],$voir_utilisateur['membre_id'],3,$voir_utilisateur['membre_id']));
	    $query->CloseCursor();

	    //header('location: ./membre.php');
	    header('location:voirprofil.php?id=' . $voir_utilisateur['membre_id']);
	    exit;

	}elseif(isset($_POST['user-debloquer'])){

	    /*$query=$db->prepare('SELECT id, statut FROM relation WHERE (id_receveur = :id1 AND id_demandeur = :id2) OR (id_receveur = :id2 AND id_demandeur = :id1)');
	    $query->execute(array('id1' => $voir_utilisateur['membre_id'], 'id2' => $_SESSION['id']));
	    $verif_relation=$req->fetch();
	    if(isset($verif_relation['id'])){
	    	if($verif_relation['statut'] == 3){
			    $query=$db->prepare('DELETE FROM relation WHERE id = ?');
			    $query->execute(array($verif_relation['id']));
	    	}else{
		    	$query=$db->prepare('UPDATE relation SET id_bloqueur = ? WHERE id = ?');
			    $query->execute(array( NULL, $verif_relation['id']));
			}
	    }
	    header('location: ./membre.php');
	    //header('location : ./voirprofil.php?id=' . $voir_utilisateur['membre_id']);
	    exit;*/


	    $query=$db->prepare("DELETE FROM relation WHERE (id_receveur = ? AND id_demandeur = ?) OR (id_receveur = ? AND id_demandeur = ?)");
	    $query->execute(array($voir_utilisateur['membre_id'], $_SESSION['id'], $_SESSION['id'], $voir_utilisateur['membre_id']));

	    //header('location: ./membre.php');
	    header('location:voirprofil.php?id=' . $voir_utilisateur['membre_id']);
	    exit;

	}
}

?>

<body>

	<?php
		require_once("includes/menu.php"); //Menu bar
	?>

	<div class="container">
  		<div class="row">
			<div class="col-sm-12">
				<div class="membres--corps">
					<div>
						Pseudo : <?= $voir_utilisateur['membre_pseudo'] ?>
					</div>
					<div>
						E-Mail : <?= $voir_utilisateur['membre_email'] ?>
					</div>
				</div>
				<?php if(isset($_SESSION['id'])){ ?>
				<div>
					<form method="post" class="form-profil">
						<?php if(!isset($voir_utilisateur['statut'])){ ?>
							<input type="submit" class="btn-user" name="user-ajouter" value="Ajouter">
						<?php }elseif(isset($voir_utilisateur['statut']) && $voir_utilisateur['id_demandeur'] == $_SESSION['id'] && !isset($voir_utilisateur['id_bloqueur']) && $voir_utilisateur['statut']<>3){ ?>
							<div>Demande en attente</div>
						<?php
						}elseif(isset($voir_utilisateur['statut']) && $voir_utilisateur['id_receveur'] == $_SESSION['id'] && !isset($voir_utilisateur['id_bloqueur']) && $voir_utilisateur['statut']<>2){ ?>
							<div>Vous avez une demande à accepter</div>
						<?php
						}elseif(isset($voir_utilisateur['statut']) && $voir_utilisateur['statut'] == 2 && !isset($voir_utilisateur['id_bloqueur'])){?>

							<div>Vous êtes amis</div>
							<input type="submit" class="btn-user" name="envoyer" value="Envoyer un message">

						<?php
						}
							if(isset($voir_utilisateur['statut']) && $voir_utilisateur['statut']<>2 && !isset($voir_utilisateur['id_bloqueur']) && $voir_utilisateur['id_demandeur'] == $_SESSION['id']){
						 ?>
							<input type="submit" class="btn-user" name="user-supprimer" value="Supprimer">
						<?php }
							if((isset($voir_utilisateur['statut']) || isset($voir_utilisateur['statut']) == NULL) && !isset($voir_utilisateur['id_bloqueur'])){
						?>
						<input type="submit" class="btn-user" name="user-bloquer" value="Bloquer">
						<?php }
						elseif($voir_utilisateur['id_bloqueur'] <> $_SESSION['id']) {
						?>
						<input type="submit" class="btn-user" name="user-debloquer" value="Débloquer">
						<?php }
						else {
						?>
						<div>Vous avez été bloqué par cet utilisateur !</div>
						<?php } ?>
					</form>
				</div>
			<?php } ?>
			</div>
  		</div>
	</div>

</body>
</html>
