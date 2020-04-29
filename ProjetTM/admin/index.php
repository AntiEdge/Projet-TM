<?php

session_start();

$user1='al';
$password1='al';

if(isset($_POST['submit'])){
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if($username&&$password){
		
		if($username==$user1&&$password==$password1){
			
			$_SESSION['username']=$username;
			header('Location: admin.php');
		
		}else{
			
			echo 'Identifiants éronnés !';
		
		}
		
	}else{
		
		echo 'Veuillez remplir les champs';
		
	}
	
}	

?>

<link href="../styles/bootstrap.css" type="text/css" rel="stylesheet"/>
<h1>Administration - Connexion</h1>
<form action="" method="POST">
	<h3>Pseudo :</h3><input type="text" name="username"/><br/><br/>
	<h3>Mot-de-passe :</h3><input type="text" name="password"/><br/><br/>
	<input type="submit" name="submit"/><br/><br/>
</form>