

<?php

session_start();
require_once('includes/identifiants.php');
require_once('includes/debut.php');

?>

    <!-- Unhides dive for thank you -->

  <script type="text/javascript">
     function showHide() {
       var div = document.getElementById("hidden_div");
       if (div.style.display == 'none') {
        div.style.display = '';
      }
       else {
        div.style.display = 'none';
      }
     }
  </script>




<body>
  <?php
    require_once("includes/menu.php");
  ?>
  <?php

    if(empty($_POST['name'])){

    echo '<div class="registration-form">
          <form method="post" action="maskofferform.php">
              <div class="form-icon">
                  <span><i class="icon icon-user"></i></span>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control item" id="name" name="name" placeholder="Nom" required>
              </div>
              <div class="form-group">
                  <input type="text" class="form-control item" id="rue" name="rue" placeholder="Rue" required>
                  <input type="number" class="form-control item" id="housenumber" name="housenumber" placeholder="n°" required>
                  <input type="number" class="form-control item" id="codepostal" name="codepostal" placeholder="Code postal" required>
              </div>

              <div class="form-group">
                  <input type="number" class="form-control item" id="nbmask" name="nbmask" placeholder="Nombre de mask disponible" required>
                  <select class="form-control item" id="type" name="type" size="1">
                  <option>HOMEMADE</option>
                  <option>FFP1</option>
                  <option>FFP2</option>
                  <option>FFP3</option>
                  <option>N95</option>
                  </select>
              </div>
              <div class="form-group">
                  <input name="submit" type="submit" value="Valider" class="btn btn-block create-account" required>
              </div>
          </form>
          <div class="social-media">
              <div id="hidden_div" style="display:none"><h5>Thank you for your donation !</h5></div>
          </div>
      </div>';

      }
      else {

        $name = $_POST['name'];
         $address = $_POST['housenumber'].','.$_POST['rue'].','.$_POST['codepostal'];
         $type = $_POST['type'];
         $nb_mask = $_POST['nbmask'];
         $membre_id = $_SESSION['id'];

         $query=$db->prepare('SELECT membre_id FROM localisation WHERE membre_id = ?');
         $query->execute(array($_SESSION['id']));
         $membre = $query->fetchAll();
         foreach ($membre as $m) {
           $membre_existant = $m['membre_id'];
         }

         if($membre_id != $membre_existant){

           $query=$db->prepare('INSERT INTO localisation (name, address, type,lat,lng,
           nbmask,membre_id)
           VALUES (?, ?, ?, ?, ?, ?, ?)');
           $query->execute(array($name,$address,$type,NULL,NULL,$nb_mask,$membre_id));
           $query->CloseCursor();

           echo'<h1>Formulaire terminée</h1>';
           echo'<p>Merci '.stripslashes(htmlspecialchars($_SESSION['pseudo'])).' pour votre contribution à la communauté</p>
         	<p>Cliquez <a href="./index.php">ici</a> pour revenir à la page d accueil</p>';

        }else{

          echo 'Le formulaire est unique.<br/>Vous avez surement déjà fait un don de masque. Pour introduire une nouvelle demande veuillez contactez le support !';
          echo '<p>Cliquez <a href="./index.php">ici</a> pour revenir à la page d accueil</p>';

        }
      }
  ?>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</body>




</html>
