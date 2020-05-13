<?php

session_start();

$titre="Index du site";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

?>

<!--<body>-->



<!DOCTYPE html>
<html>
	<head>
		<title>Access Google Maps API in PHP</title>

		<style type="text/css">
		.leftside, .rightside{
			height:100vh;
			width:100%;
		}

		.leftside {
			background: red;
		}
			#data, #allData {
				display: none;
			}
			.list-group{
				overflow: scroll;
				max-height: 100vh;
			}

			@media screen and (min-width:768px){
				.rightside, .leftside{
					height: 100vh;

				}
			}
		</style>


	</head>
	<body>
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

	<?php
			require_once("includes/menu.php");
	?>


<!--mettre no gutters pour ne pas avoir de bord sur les côté et évite une page trop grande-->
	<div class="row no-gutters">
			<div class="col-md-3 no-gutters">
					<div class="leftside">
						<div id="searchList">
							<div class="list-group" id="test">


							</div>
						</div>
					</div>

			</div>

			<div class="col-md-9 no-gutters order-first order-md-last">

				<div class="rightside"><div id="map"style=height:100%; width:100% ></div></div>
			</div>


	</div>

















	</body>
	<!-- Script qui fait appel aux services de Google Api afin d'utiliser les fonctions de la map. grace à un API -->
	<!-- async: demande au nav de charger le reste du site pendant le chargement de maps javascript api. a la fin appendChild
	callback
	defer: demande au navigateur de parse dabord le doc html avant de charger le script.-->
	<script async defer
	    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7e9DqluJecLSL2w7QlE0hddPluhX42Jo&callback=loadMap">
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.js"></script>
	<script type="text/javascript" src="js/googlemap.js"></script>
</html>
