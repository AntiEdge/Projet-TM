<?php

session_start();

$titre="Modifier mon profil";

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

//Sélectionne le profil de l'id de session

$req = $db->prepare("SELECT * FROM membres WHERE membre_id = ?");
$req->execute(array($utilisateur_id));
$voir_utilisateur = $req->fetch();

if(!isset($voir_utilisateur['membre_id'])){

	header('location: ./membre.php');
	exit;

}

if(!empty($_POST)){

	if(isset($_POST['modifier'])){

		//Traitement des valeurs rentrées dans la form

		$pseudo_erreur1 = NULL;
	    $pseudo_erreur2 = NULL;
	    $email_erreur1 = NULL;
	    $email_erreur2 = NULL;

	    //On récupère les variables
	    $i = 0;
	    $pseudo=$_POST['pseudo'];
	    $email = $_POST['mail'];

	    //Vérification du pseudo
	    $query=$db->prepare('SELECT COUNT(*) AS nbr FROM membres WHERE membre_pseudo =:pseudo AND membre_id <> :id');
	    $query->bindValue(':pseudo',$pseudo, PDO::PARAM_STR);
	    $query->bindValue(':id',$_SESSION['id'], PDO::PARAM_INT);
	    $query->execute();
	    $pseudo_free=($query->fetchColumn()==0)?1:0;
	    $query->CloseCursor();
	    if(!$pseudo_free)
	    {
	        $pseudo_erreur1 = "Votre pseudo est déjà utilisé par un membre";
	        $i++;
	    }

	    if (strlen($pseudo) < 3 || strlen($pseudo) > 15)
	    {
	        $pseudo_erreur2 = "Votre pseudo est soit trop grand, soit trop petit";
	        $i++;
	    }

	    //Vérification de l'adresse email

	    //Il faut que l'adresse email n'ait jamais été utilisée
	    $query=$db->prepare('SELECT COUNT(*) AS nbr FROM membres WHERE membre_email =:mail AND membre_id <> :id');
	    $query->bindValue(':mail',$email, PDO::PARAM_STR);
	    $query->bindValue(':id',$_SESSION['id'], PDO::PARAM_INT);
	    $query->execute();
	    $mail_free=($query->fetchColumn()==0)?1:0;
	    $query->CloseCursor();

	    if(!$mail_free)
	    {
	        $email_erreur1 = "Votre adresse email est déjà utilisée par un membre";
	        $i++;
	    }
	    //On vérifie la forme maintenant
	    if (!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $email) || empty($email))
	    {
	        $email_erreur2 = "Votre adresse E-Mail n'a pas un format valide";
	        $i++;
	    }

	    if ($i==0)
	    {
	    	//Update le membre avec les nouvelles données

	        $query=$db->prepare('UPDATE membres SET membre_pseudo = ?, membre_email = ? WHERE membre_id = ?');
	        $query->execute(array($pseudo,$email,$_SESSION['id']));
	        $query->CloseCursor();
	    }
	    else
	    {
	        echo'<h1>Modification interrompue</h1>';
	        echo'<p>Une ou plusieurs erreurs se sont produites pendant la modification</p>';
	        echo'<p>'.$i.' erreur(s)</p>';
	        echo'<p>'.$pseudo_erreur1.'</p>';
	        echo'<p>'.$pseudo_erreur2.'</p>';
	        echo'<p>'.$email_erreur1.'</p>';
	        echo'<p>'.$email_erreur2.'</p>';

	        echo'<p>Cliquez <a href="./editer-profil.php">ici</a> pour recommencer</p>';
	    }

	}
}

?>

<body>

	<?php
		require_once("includes/menu.php"); //Menu bar
	?>

	<?php //Formulaire de modification de profil?>

	<div class="container">
  		<div class="row">
			<div class="col-sm-12">
				<div class="membres--corps">
					<form method="post">
						<div>
							<?php

								if(!isset($pseudo)){

									$pseudo=$voir_utilisateur['membre_pseudo'];

								}

							?>
							<label>	Pseudo : </label>

								<input type="text"  name="pseudo" value="<?= $pseudo ?>" style="width: 235px;">

						</div>
						<div>
							<?php

								if(!isset($mail)){

									$mail=$voir_utilisateur['membre_email'];

								}

							?>
							<br/>
							<label> E-Mail : </label>

								<input type="text" name="mail" value="<?= $mail ?>" style="width: 235px;">

						</div>
						<br/>
						<input type="submit" class="btn-user" name="modifier" value="Modifier">
					</form>
				</div>
			</div>
  		</div>
	</div>

</body>
</html>
