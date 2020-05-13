<?php
session_start();
$titre="Enregistrement";
require_once("includes/identifiants.php");
require_once("includes/debut.php");

if (isset($_SESSION['id'])) {

    erreur(ERR_IS_CO);

}

?>
<body>

<?php

require_once("includes/menu.php");

if (empty($_POST['pseudo'])) // Si on la variable est vide, on peut considérer qu'on est sur la page de formulaire
{

  echo '<body>
      <div class="registration-form">
          <form action="register.php" method="post" autocomplete="off">
              <div class="form-icon">
                  <span><i class="icon icon-user"></i></span>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control item" id="pseudo" name="pseudo" placeholder="Username">
              </div>
              <div class="form-group">
                  <input type="password" class="form-control item" id="password" name="password" placeholder="Password">
              </div>
              <div class="form-group">
                  <input type="password" class="form-control item" id="confirm" name="confirm" placeholder="Confirm password">
              </div>
              <div class="form-group">
                  <input type="text" class="form-control item" id="email" name="email" placeholder="Email">
              </div>
              <div class="form-group">
                  <input type="submit" value="S\'inscrire" class="btn btn-block create-account">
              </div>
          </form>
          <div class="social-media">
              <h5>Sign up with social media</h5>
              <div class="social-icons">
                  <a href="#"><i class="icon-social-facebook" title="Facebook"></i></a>
                  <a href="#"><i class="icon-social-google" title="Google"></i></a>
                  <a href="#"><i class="icon-social-twitter" title="Twitter"></i></a>
              </div>
          </div>
      </div>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
      <script src="assets/js/script.js"></script>
      </form>
      </body>';


} //Fin de la partie formulaire
else //On est dans le cas traitement
{
    $pseudo_erreur1 = NULL;
    $pseudo_erreur2 = NULL;
    $mdp_erreur = NULL;
    $email_erreur1 = NULL;
    $email_erreur2 = NULL;

    //On récupère les variables
    $i = 0;
    $pseudo=$_POST['pseudo'];
    $email = $_POST['email'];
    $pass = md5($_POST['password']);
    $confirm = md5($_POST['confirm']);

    //Vérification du pseudo
    $query=$db->prepare('SELECT COUNT(*) AS nbr FROM membres WHERE membre_pseudo =:pseudo');
    $query->bindValue(':pseudo',$pseudo, PDO::PARAM_STR);
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

    //Vérification du mdp
    if ($pass != $confirm || empty($confirm) || empty($pass))
    {
        $mdp_erreur = "Votre mot de passe et votre confirmation diffèrent, ou sont vides";
        $i++;
    }

    //Vérification de l'adresse email

    //Il faut que l'adresse email n'ait jamais été utilisée
    $query=$db->prepare('SELECT COUNT(*) AS nbr FROM membres WHERE membre_email =:mail');
    $query->bindValue(':mail',$email, PDO::PARAM_STR);
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
	echo'<h1>Inscription terminée</h1>';
        echo'<p>Bienvenue '.stripslashes(htmlspecialchars($_POST['pseudo'])).' vous êtes maintenant inscrit sur notre site</p>
	<p>Cliquez <a href="./index.php">ici</a> pour revenir à la page d accueil</p>';

        $query=$db->prepare('INSERT INTO membres (membre_pseudo, membre_mdp, membre_email,
		membre_date_inscription)
        VALUES (:pseudo, :pass, :email, NOW())');
	      $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
	      $query->bindValue(':pass', $pass, PDO::PARAM_STR);
	      $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();

        /*$header="MIME-Version: 1.0\r\n";
        $header.='From:"Test"<support@hotmail.com>'."\n";
        $header.='Content-Type:text/html; charset="uft-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';

        $message='
        <html>
        	<body>
        		<div align="center">
        			<br />
        			Vous avez bien été inscrit !
        			<br />
        		</div>
        	</body>
        </html>
        ';

        mail("<?= $email ?>", "Inscription !", $message, $header);*/

	//Et on définit les variables de sessions
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['id'] = $db->lastInsertId(); ;
        $query->CloseCursor();
    }
    else
    {
        echo'<h1>Inscription interrompue</h1>';
        echo'<p>Une ou plusieurs erreurs se sont produites pendant l incription</p>';
        echo'<p>'.$i.' erreur(s)</p>';
        echo'<p>'.$pseudo_erreur1.'</p>';
        echo'<p>'.$pseudo_erreur2.'</p>';
        echo'<p>'.$mdp_erreur.'</p>';
        echo'<p>'.$email_erreur1.'</p>';
        echo'<p>'.$email_erreur2.'</p>';

        echo'<p>Cliquez <a href="./register.php">ici</a> pour recommencer</p>';
    }
}
?>

</body>

<?php
echo '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
require_once("includes/footer.php");
?>

</html>
