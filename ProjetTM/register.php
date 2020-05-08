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
	echo '<h1>Inscription</h1>';
	echo '<form method="post" action="register.php" enctype="multipart/form-data">

	<fieldset><legend>Identifiants</legend>
	<label for="pseudo">* Pseudo :</label>  <input name="pseudo" type="text" id="pseudo" placeholder=" Pseudo"/> (le pseudo doit contenir entre 3 et 15 caractères)<br />
	<label for="password">* Mot de Passe : </label><input type="password" name="password" id="password" placeholder=" Mot de passe"/><br />
	<label for="confirm">* Confirmer le mot de passe : </label><input type="password" name="confirm" id="confirm" placeholder=" Mot de passe"/>
	</fieldset>

	<fieldset><legend>Contacts</legend>
	<label for="email">* Votre adresse Mail : </label><input type="text" name="email" id="email" placeholder=" E-Mail"/><br />
	</fieldset>

	<p>Les champs précédés d un * sont obligatoires</p>
	<p><input type="submit" value="S\'inscrire" /></p></form>

	</html>';


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
