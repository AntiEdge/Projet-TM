<?php

session_start();

$titre="Connexion";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

//Vérifie si l'utilisateur est connecté
if (isset($_SESSION['id'])) {

	erreur(ERR_IS_CO);

}

?>

<body>

	<?php
		require_once("includes/menu.php"); //Menu bar
	?>

<?php
if (!isset($_POST['pseudo'])) //On est dans la page de formulaire
{
    echo '<form method="post" action="connexion.php">
		<link rel="stylesheet" type="text/css" href="styles/styles.css">
		<div class="container-fluid">
		  <div class="row no-gutter">
		    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
		    <div class="col-md-8 col-lg-6">
		      <div class="login d-flex align-items-center py-5">
		        <div class="container">
		          <div class="row">
		            <div class="col-md-9 col-lg-8 mx-auto">
		              <h3 class="login-heading mb-4">Welcome back!</h3>
		              <form>
		                <div class="form-label-group">
		                  <input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Pseudo" required autofocus>
		                 <label for="pseudo">Pseudo</label>
		                </div>

		                <div class="form-label-group">
		                  <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
		                  <label for="password">Password</label>
		                </div>

		                <div class="custom-control custom-checkbox mb-3">
		                  <input type="checkbox" class="custom-control-input" id="customCheck1">
		                  <label class="custom-control-label" for="customCheck1">Remember password</label>
		                </div>
		                <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" value="Connexion" type="submit">Sign in</button>
										<div class="text-center">
                  <a class="small" href="./register.php">Pas encore inscrit?</a></div>
		              </form>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

    </body>
    </html>';
}
else
{

    $message='';
    if (empty($_POST['pseudo']) || empty($_POST['password']) ) //Oublie d'un champ
    {
        $message = '<p>une erreur s\'est produite pendant votre identification.
	Vous devez remplir tous les champs</p>
	<p>Cliquez <a href="./connexion.php">ici</a> pour revenir</p>';
    }
    else //On check le mot de passe
    {
        $query=$db->prepare('SELECT membre_mdp, membre_id, membre_pseudo
        FROM membres WHERE membre_pseudo = :pseudo');
        $query->bindValue(':pseudo',$_POST['pseudo'], PDO::PARAM_STR);
        $query->execute();
        $data=$query->fetch();
		if ($data['membre_mdp'] == md5($_POST['password'])) // Acces OK !
		{
			$_SESSION['pseudo'] = $data['membre_pseudo'];
			$_SESSION['id'] = $data['membre_id'];
			header('location: ./index.php');
			exit;
		}
		else // Acces pas OK !
		{
			$message = '<p>Une erreur s\'est produite
			pendant votre identification.<br /> Le mot de passe ou le pseudo
				entré n\'est pas correcte.</p><p>Cliquez <a href="./connexion.php">ici</a>
			pour revenir à la page précédente
			<br /><br />Cliquez <a href="./index.php">ici</a>
			pour revenir à la page d accueil</p>';
		}
		$query->CloseCursor();
	}

	echo $message;

}

?>

</body>

<?php
echo '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
require_once("includes/footer.php");
?>

</html>
