<?php

session_start();

$titre="Profil de ";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

if (!isset($_SESSION['id'])) {

	header('location: ./index.php');
	exit;

}

$utilisateur_id = (int) $_SESSION['id'];

if (empty($utilisateur_id)) {

	header('location: ./membre.php');
	exit;

}

$req = $db->prepare("SELECT * FROM membres WHERE membre_id = ?");
$req->execute(array($utilisateur_id));
$voir_utilisateur = $req->fetch();

if(!isset($voir_utilisateur['membre_id'])){

	header('location: ./membre.php');
	exit;

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
			</div>
  		</div>
	</div>

</body>
</html>