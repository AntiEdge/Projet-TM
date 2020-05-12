<?php

session_start();

$titre="Tchat online";

require_once("includes/debut.php");

if (!isset($_SESSION['id'])) {

	header('location: ./index.php');
	exit;

}

//Rajouter la vérification ami ou pas
require 'chat.php';
$chat = new chat;

$voir_tchat = $chat->getChatWithoutYourId();
$see_tchat = json_decode($voir_tchat, true);

?>

<body>

		<div id="menu">
			<?php
				require_once("includes/menu.php"); //Menu bar
			?>
		</div>

		<div class="container">

			<?php

						$var = 0;
						$deja_present = array($var => null);

						foreach ($see_tchat as $st){
							if(($st['id_receveur'] == $_SESSION['id']) && !in_array($st['id_pseudo'],$deja_present)){
									$deja_present = array($var => $st['id_pseudo']);
									$var++;
								?>
								<div class="row">
									<div class="rowTchat">
										<div class="col">
											<div class="colTchat">
													<?= $st['membre_pseudo']?>
											</div>
										</div>
										<div class="col">
											<div class="colTchat">
													<?= $st['message'] ?>
											</div>
										</div>
										<div class="col">
											<div class="colTchat">
													<a href="messagerie.php?pseudo=<?= $st['membre_pseudo'] ?>" class="membres-btn-voir">Voir message</a>
											</div>
										</div>
									</div>
								</div>
			<?php
							}
						}
			?>
		</div>

</body>
</html>
