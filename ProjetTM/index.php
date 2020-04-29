<?php

session_start();

$titre="Index du site";

include("includes/identifiants.php");
include("includes/debut.php");
include("includes/header.php");
echo'<i>Vous êtes ici : </i><a href ="./index.php">Index du forum</a>';

?>



<?php
echo '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
include("includes/footer.php");
?>

</html>
