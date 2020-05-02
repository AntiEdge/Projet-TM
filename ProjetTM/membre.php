<?php

session_start();

$titre="Membre";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

if (isset($_SESSION['id'])) {

	//Récupères tout les membres sauf celui égal à l'id de session

	$afficher_membre = $db->prepare("SELECT * FROM membres WHERE membre_id <> ?");
	$afficher_membre->execute(array($_SESSION['id']));

}
else
{
	//Si il n'y a pas d'id alors ça sélectionne tout les membres

	$afficher_membre = $db->prepare("SELECT * FROM membres");
	$afficher_membre->execute();

}

?>

<body>
	
	<?php
		require_once("includes/menu.php"); //Menu bar
	?>

	<?php //Affiche les membres dans des divs différentes?>

	<div class="container">
  		<div class="row">
	    	<?php foreach($afficher_membre as $am){?>

				<div class="col-sm-3"> 
					<div class="membres--corps">
						<div>
							<?= $am['membre_pseudo'] ?>
						</div>
						<div class="membres-btn">
							<a href="voirprofil.php?id=<?= $am['membre_id'] ?>" class="membres-btn-voir">Voir profil</a>
						</div>
					</div>
				</div>

			<?php 
				} 
			?>
  		</div>
	</div>
	
</body>
</html>