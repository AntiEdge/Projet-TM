<?php

session_start();

$titre="Index du site";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

?>

<body>

	<?php
		require_once("includes/menu.php");
	?>

	<html>
	<head>
		<title>Access Google Maps API in PHP</title>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script type="text/javascript" src="js/googlemap.js"></script>
		<style type="text/css">
			.container {
				height: 450px;
			}
			#map {
				width: 100%;
				height: 100%;
				border: 1px solid blue;
			}
			#data, #allData {
				display: none;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<center><h1>Afficher les membres sur la Map</h1></center>

			<?php
				require 'includes/vile.php';
				$ville = new ville;
	// récupère toutes les villes qui n'ont pas encore de lat et lng.
				$coll = $ville->getCitysBlankLatLng();
	// Encode au format json ce qui est retourne.
				$coll = json_encode($coll, true);
	// L'on renvoi les données en json pour être interprêté par javascript.
				echo '<div id="data">' . $coll . '</div>';

				$allData = $ville->getAllCitys();
				$allData = json_encode($allData, true);
				echo '<div id="allData">' . $allData . '</div>';
			 ?>
			 <!-- C'est ici qu'on affiche la map grace au div -->
			<div id="map"></div>
		</div>
	</body>
	<!-- Script qui fait appel aux services de Google Api afin d'utiliser les fonctions de la map. grace à un API -->
	<!-- async: demande au nav de charger le reste du site pendant le chargement de maps javascript api. a la fin appendChild
	callback
	defer: demande au navigateur de parse dabord le doc html avant de charger le script.-->
	<script async defer
	    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7e9DqluJecLSL2w7QlE0hddPluhX42Jo&callback=loadMap">
	</script>
	</html>
