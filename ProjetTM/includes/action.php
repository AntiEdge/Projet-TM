<?php
// récupère ville.php et dans la classe ville nous allons écrire les nouveaux éléments grâce aux setters

	require 'vile.php';
	$ville = new ville;
	$ville->setId($_REQUEST['id']);
	$ville->setLat($_REQUEST['lat']);
	$ville->setLng($_REQUEST['lng']);
	//On fait un echo pour voir si les éléments on bient été mis à jours
	$status = $ville->updateCitysWithLatLng();
	if($status == true) {
		echo "Updated...";
	} else {
		echo "Failed...";
	}
 ?>
