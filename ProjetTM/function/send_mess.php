<?php

session_start();

$titre="Tchat online";

require_once("../includes/identifiants.php");
require_once("../includes/debut.php");

if (isset($_SESSION['id'])) {

	$mess = htmlspecialchars(trim($_GET['message']));

	if (isset($mess) && !empty($mess)) {

		$req = $db->prepare("SELECT membre_id FROM membres WHERE membre_id = ?");
		$req->execute(array($_SESSION['id']));
		$verif_user = $req->fetch();

		if(isset($verif_user['id'])){

			$date_message = date('Y-m-d H:i:s');

			$query=$db->prepare('INSERT INTO tchat (id_pseudo, message, date_message) VALUES (?,?,?)');
	        $query->execute(array($_SESSION['id'],$mess, $date_message));
	        $query->CloseCursor();

	        $req = $db->prepare("SELECT id FROM tchat WHERE id_pseudo = ? ORDER BY date_message DESC LIMIT 1");
			$req->execute(array($_SESSION['id']));
			$lastID = $req->fetch();

			$date_message = date_create($date_message);
			$date_message = date_format($date_message, 'd M Y à H:i:s');
			?>

			<div style="float: right; width: auto; max-width: 80%; margin-right: 26px; position: relative; padding: 7px 20px; color: #fff; background: #0093F6; border-radius: 5px; margin-bottom: 15px; clear: both;">
				<span id="<?= $lastID['id'] ?>">
					<?= nl2br($mess) ?>
				</span>
				<div style="font-size: 10px; text-align: right; margin-top: 10px;">Par <?= $_SESSION['membre_pseudo'] ?>, le <?= $date_message ?></div>
			</div>

			<script>
				document.getElementById('msg').scrollTop = document.getElementById('msg').scrollHeight;
			</script>

<?php
		}

	}

}

?>
