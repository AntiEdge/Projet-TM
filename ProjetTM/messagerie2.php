<?php

session_start();

$titre="Tchat online";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

if (!isset($_SESSION['id'])) {

	header('location: ./index.php');
	exit;

}

$pseudo_receveur = $_GET['pseudo'];

$req = $db->prepare("SELECT * FROM membres WHERE membre_pseudo = ?");
$req->execute(array($pseudo_receveur));
$receveur = $req->fetch();

if (isset($receveur['membre_id'])) {

	$id_receveur = $receveur['membre_id'];

}

?>

    <body>

			<div id="menu">
				<?php
					require_once("includes/menu.php"); //Menu bar
				?>
			</div>

			<div class="container">
		  		<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<h3><?= $pseudo_receveur ?></h3>
						<div id="messages" style="border: 1px solid:#cccccc; padding: 10px 0; border-radius: 5px; overflow: scroll; height: 400px; margin: 10px 0; background: white;">

					<?php

							// on récupère les 10 derniers messages postés
							$requete = $db->prepare("SELECT t.*, m.membre_pseudo FROM tchat t LEFT JOIN membres m ON m.membre_id = t.id_pseudo WHERE (id_receveur = ? AND id_pseudo = ?) OR (id_receveur = ? AND id_pseudo = ?) ORDER BY id ASC LIMIT 0,5000");
							$requete->execute(array($id_receveur, $_SESSION['id'], $_SESSION['id'] , $id_receveur));
							$donnees = $requete->fetchAll();

							foreach ($donnees as $d) {

									$date_message = $d['date_message'];
									// on affiche le message (l'id servira plus tard)
									if(isset($_SESSION['id']) && $d['id_pseudo'] == $_SESSION['id']) { ?>

										<div style="float: right; width: auto; max-width: 80%; margin-right: 26px; position: relative; padding: 7px 20px; color: #fff; background: #0093F6; border-radius: 5px; margin-bottom: 15px; clear: both;">

												<?php echo "<p id=\"" . $d['id'] . "\">" . $d['message'] . "</p>"; ?>

											<div style="font-size: 10px; text-align: right; margin-top: 10px;">Par <?= $d['membre_pseudo']?>, le <?= $date_message ?></div>

										</div>
										<?php
									}else{
										?>
										<div style="position: relative; padding: 7px 20px; background: #E5E5EA; border-radius: 5px; color: #000; float: left; width: auto; max-width: 80%; margin-left: 10px; margin-bottom: 15px; clear: both;">

											<?php echo "<p id=\"" . $d['id'] . "\">" . $d['message'] . "</p>"; ?>

											<div style="font-size: 10px; text-align: right; margin-top: 10px;">Par <?= $d['membre_pseudo']?>, le <?= $date_message ?></div>
										</div>
										<?php
									}
									//echo "<p id=\"" . $d['id'] . "\">" . $d['membre_pseudo'] . " dit : " . $d['message'] . "</p>";

							}

							$requete->closeCursor();

					?>

        </div>

			<?php
				if(isset($_SESSION['id'])){
			?>
				<div style="border: 1px solid #cccccc; border-radius: 5px; position: relative; padding-top: 5px; background: white;">
					<form method="post" action="traitement.php">

						<input type="hidden" name="idreceveur" id="id_receveur" value="<?= $id_receveur ?>" /><br />
						<textarea class="autoExpand" rows="1" data-min-rows="1" name="message" id="message" class="msg" placeholder="Envoyer votre message" style="border: none; overflow: none; resize: none; width: 90%; outline: none; padding: 0 5px;"></textarea>
						<div style="position: absolute; top: -5px; right: 2px; font-size: 28px;">
							<input id="envoi" type="submit" name="submit" value="Send" style="border: none; background: transparent; outline: none;">
						</div>

					</form>

				</div>
			<?php
		}
			?>
		</div>
		</div>
</div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript">

					document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;

						$('#envoi').click(function(e){
								e.preventDefault(); // on empêche le bouton d'envoyer le formulaire

						 		var pseudo = <?php echo $_SESSION['id'] ?>;// on sécurise les données
								var message = encodeURIComponent( $('#message').val() );
								var id_receveur = encodeURIComponent(<?php echo $id_receveur ?>);

								if(message != ""){ // on vérifie que les variables ne sont pas vides
										$.ajax({
												url : "traitement.php?msg=" + message + '&id=' + id_receveur, // on donne l'URL du fichier de traitement
												type : "GET", // la requête est de type POST
											//data : "message=" + message  // et on envoie nos données
												success : function(html){
														$('#messages').prepend(html);
												}
										});
										document.getElementById("message").value = "";
									 //$('#messages').append("<p>" + pseudo + " dit : " + message + "</p>"); // on ajoute le message dans la zone prévue
								}
						});

						function charger(){

								setTimeout( function(){

										var premierID = $('#messages p:last').attr('id');
										var id_receveur =  <?php echo $id_receveur; ?>// on récupère l'id le plus récent

									 console.log('go');

										$.ajax({
												url : "charger.php?id=" + premierID + '&idd=' + id_receveur, // on passe l'id le plus récent au fichier de chargement
												type : "GET",
												success : function(html){
														$('#messages').append(html);
														document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
												}
										});

										charger();

								}, 5000);

						}

						charger();

				</script>
    </body>
</html>
