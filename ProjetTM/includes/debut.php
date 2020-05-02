<!DOCTYPE html>
<html lang="fr" >
	<head>
		<?php
		//Si le titre est indiqué, on l'affiche entre les balises <title>
		echo (!empty($titre))?'<title>'.$titre.'</title>':'<title> Projet </title>';
		?>

		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<link rel="stylesheet" href="./styles/styles.css" />

	</head>
<?php

//Attribution des variables de session
$pseudo=(isset($_SESSION['pseudo']))?$_SESSION['pseudo']:'';

//On inclue les 2 pages restantes
require_once("./includes/functions.php");
require_once("./includes/constantes.php");
?>
