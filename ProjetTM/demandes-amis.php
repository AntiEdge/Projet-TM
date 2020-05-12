<?php

session_start();

$titre="Demande d'ami";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

if(!isset($_SESSION['id'])){

	header('location : ./index.php');
	exit;

}

//Récupère toutes les demandes associées à l'id de session

$req = $db->prepare("SELECT r.*,m.membre_pseudo FROM relation r LEFT JOIN membres m ON m.membre_id = r.id_demandeur WHERE r.id_receveur = ? AND r.statut = ?");
$req->execute(array($_SESSION['id'], 1));
$mes_demandes = $req->fetchAll();

//Si un formulaire est créé, traite le bouton accepter et refuser

	if(!empty($_POST)){
		if(isset($_POST['accepter'])){

			//Vérifie qu'il y a bel et bien une demande

			$req = $db->prepare("SELECT * FROM relation WHERE id = ?");
			$req->execute(array($_POST['id_demande']));
			$verifier_demande = $req->fetch();

			//Si il y a une demande alors ça update la relation à "Ami"

			if(isset($verifier_demande['id'])){
				$query=$db->prepare('UPDATE relation SET statut = ? WHERE id = ?');
			  $query->execute(array( 2, $verifier_demande['id']));
				header('location:voirprofil.php?id=' . $_POST['id_demande']);
			}
		}

		if(isset($_POST['refuser'])){

			//Supprimer la demmande d'ami

			$query=$db->prepare('DELETE FROM relation WHERE id = ?');
			$query->execute(array($_POST['id_demande']));

		}
	}
?>

<body>

<?php
	require_once("includes/menu.php"); //Menu bar
?>

<?php //Affiche les demandes d'amis?>

<div class="container">
  		<div class="row">
	    	<?php foreach($mes_demandes as $md){?>

				<div class="col-sm-3">
					<div class="membres--corps">
						<form method="post">
						<div>
							<?= $md['membre_pseudo']?>
							<input type="hidden" name="id_demande" value="<?= $md['id']?>">
						</div>
						<div>
							<input type="submit" name="accepter" value="Accepter"/>
						</div>
						<div>
							<input type="submit" name="refuser" value="Refuser"/>
						</div>
						</form>

					</div>
				</div>

			<?php
				}
			?>
  		</div>
	</div>
</body>
</html>
