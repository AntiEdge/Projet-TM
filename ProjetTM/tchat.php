<?php

session_start();

$titre="Tchat online";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

if (!isset($_SESSION['id'])) {

	header('location: ./index.php');
	exit;

}

$req = $db->prepare("SELECT t.*, m.membre_pseudo FROM tchat t LEFT JOIN membres m ON m.membre_id = t.id_receveur WHERE membre_id <> ? ORDER BY date_message LIMIT 100");
$req->execute(array($_SESSION['id']));
$see_tchat = $req->fetchAll();

?>

<body>

		<div id="menu">
			<?php
				require_once("includes/menu.php"); //Menu bar
			?>
		</div>

		<div class="container">
			<?php foreach ($see_tchat as $st){
							if($st['id_pseudo'] == $_SESSION['id']){?>
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

<?php /*
	<div class="container">
  		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<h3>Tchat</h3>
				<div id="msg" style="border: 1px solid:#cccccc; padding: 10px 0; border-radius: 5px; overflow: scroll; height: 400px; margin: 10px 0; background: white;">
					<?php
					foreach ($see_tchat as $st) {
						$date_message = date_create($st["date_message"]);
						$date_message = date_format($date_message, 'd M Y à H:i:s');

						if(isset($_SESSION['id']) && $st['id_pseudo'] == $_SESSION['id']) {
					?>
						<div style="float: right; width: auto; max-width: 80%; margin-right: 26px; position: relative; padding: 7px 20px; color: #fff; background: #0093F6; border-radius: 5px; margin-bottom: 15px; clear: both;">
							<span id="<?= $st['id'] ?>">
								<?= nl2br($st['message']) ?>
							</span>

							<div style="font-size: 10px; text-align: right; margin-top: 10px;">Par <?= $st['membre_pseudo']?>, le <?= $date_message ?></div>

						</div>
					<?php
						}
					}
					?>
					<div id="message_recept"></div>
				</div>

				<?php
					if(isset($_SESSION['id'])){
				?>
					<div style="border: 1px solid #cccccc; border-radius: 5px; position: relative; padding-top: 5px; background: white;">
						<form method="post">

							<textarea class="autoExpand" rows="1" data-min-rows="1" name="texte" id="message" class="msg" placeholder="Envoyer votre message" style="border: none; overflow: none; resize: none; width: 90%; outline: none; padding: 0 5px;"></textarea>
							<div style="position: absolute; top: -5px; right: 2px; font-size: 28px;">
								<input id="envoi" type="submit" class="fa fa-arrow-circle-up" value="Send" style="border: none; background: transparent; outline: none;">
							</div>

						</form>

					</div>
				<?php
					}
				?>
			</div>
  		</div>
	</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script
  src="https://code.jquery.com/jquery-1.12.4.min.js"
  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script type="text/javascript">

		//document.getElementById('msg').scrollTop = document.getElementById('msg').scrollHeight;

		$('#envoi').click(function(e){

			e.preventDefault();

			var message = encodeURIComponent($('#message').val());

			message = message.trim();

			$('#message').val(null);

			if(message != ""){

				$.ajax({
					url : 'function/send_mess.php?message=' + message,
					type : 'GET',
					dataType : "html",
					success : function(data){
						$("#message_recept").append(data);
					}
				});
			}
		});

		setInterval("load_mess()", 1000);

		function load_mess(){

			var lastID = $('#msg span:last').attr('id');

			if(lastID > 0){

				$.ajax({
					url : 'function/load_mess.php?id=' + lastID,
					type : 'GET',
					dataType : "html",
					success : function(data){
						$("#message_recept").append(data);
					}
				});
			}
		};

		$(document).one('focus.autoExpand', 'textarea.autoExpand', function(){

			var savedValue = this.value;
			this.value = '';
			this.baseScrollHeight = this.scrollHeight;
			this.value = savedValue;

		}).on('input.autoExpand', 'textarea.autoExpand', function(){

			var minRows = this.getAttribute('data-min-rows')|0, rows;
			this.rows = minRows;
			rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 20);
			this.rows = minRows + rows;

		});

	</script>

	<div style="float: right; width: auto; max-width: 80%; margin-right: 26px; position: relative; padding: 7px 20px; color: #fff; background: #0093F6; border-radius: 5px; margin-bottom: 15px; clear: both;">
		<span id="<?= $lastID['id'] ?>">
			<?= nl2br($mess) ?>
		</span>
		<div style="font-size: 10px; text-align: right; margin-top: 10px;">Par <?= $_SESSION['membre_pseudo'] ?>, le <?= $date_message ?></div>
	</div>

	<script>
		document.getElementById('msg').scrollTop = document.getElementById('msg').scrollHeight;
	</script>

	*/?>

</body>
</html>
