<?php

	session_start();

	$titre = "Déconnexion";

	require_once("includes/identifiants.php");
	require_once("includes/debut.php");

	//Supprime les variables de session
	session_unset();
	session_destroy();

	header('location: ./index.php');
	exit;

?>