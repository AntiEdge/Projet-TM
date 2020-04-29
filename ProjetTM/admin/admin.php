<?php

session_start();

	if(isset($_SESSION['username'])){
		
		
		
	}else{
		
		header('Location: ../index.php');
		
	}

?>
<link href="../styles/bootstrap.css" type="text/css" rel="stylesheet"/>
<h1>Bienvenue, <?php echo $_SESSION['username']; ?></h1>