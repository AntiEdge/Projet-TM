

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
                  <input type="text" class="form-control item" id="type" name="type" placeholder="Type de mask" required>
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


         $query=$db->prepare('INSERT INTO localisation (name, address, type,lat,lng,
         nbmask,membre_id)
         VALUES (?, ?, ?, ?, ?, ?, ?)');
         $query->execute(array($name,$address,$type,NULL,NULL,$nb_mask,$membre_id));
         $query->CloseCursor();
         header('location:maskofferform.php');

      }
  ?>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</body>




</html>
