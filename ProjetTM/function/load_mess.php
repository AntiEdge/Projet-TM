<?php

session_start();

$titre="Tchat online";

require_once("../includes/identifiants.php");
require_once("../includes/debut.php");

if (isset($_GET['id'])) {

	$id = (int) $_GET['id'];

	$req = $db->prepare("SELECT t.*, m.membre_pseudo FROM tchat t LEFT JOIN membres m ON m.membre_id = t.id_pseudo WHERE t.id > ? ORDER BY date_message");
	$req->execute(array($id));
	$see_tchat = $req->fetchAll();

	if (count($see_tchat) > 0) {

		//Il ne faut que les échanges entre les deux personnes
		foreach ($see_tchat as $st) {

			$date_message = date_create($st["date_message"]);
			$date_message = date_format($date_message, 'd M Y à H:i:s');

			if(isset($_SESSION['id']) && $st['id_pseudo'] == $_SESSION['id']) { ?>

				<div style="float: right; width: auto; max-width: 80%; margin-right: 26px; position: relative; padding: 7px 20px; color: #fff; background: #0093F6; border-radius: 5px; margin-bottom: 15px; clear: both;">

					<span id="<?= $st['id'] ?>">
						<?= nl2br($st['message']) ?>
					</span>

					<div style="font-size: 10px; text-align: right; margin-top: 10px;">Par <?= $st['membre_pseudo']?>, le <?= $date_message ?></div>

				</div>
			<?php
			}else{
			?>
				<div style="position: relative; padding: 7px 20px; background: #E5E5EA; border-radius: 5px; color: #000; float: left; width: auto; max-width: 80%; margin-left: 10px; margin-bottom: 15px; clear: both;">

					<span id="<?= $st['id'] ?>">
						<?= nl2br($st['message']) ?>
					</span>

					<div style="font-size: 10px; text-align: right; margin-top: 10px;">Par <?= $st['membre_pseudo']?>, le <?= $date_message ?></div>
				</div>
			<?php
			}

		}
		?>
		<script>
			document.getElementById('msg').scrollTop = document.getElementById('msg').scrollHeight;
		</script>
	<?php
	}

}
?>
