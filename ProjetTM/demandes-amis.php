<?php

session_start();

$titre="Demande d'ami";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

if(!isset($_SESSION['id'])){

	header('location : ./index.php');
	exit;

}

$mes_demandes = $db->query("SELECT r.*,m.membre_pseudo
  FROM relation r 
  LEFT JOIN membres m ON m.membre_id = r.id_demandeur 
  WHERE r.id_receveur = ? AND r.statut = ?",
  array($_SESSION['id'], 1));
 
$mes_demandes = $mes_demandes->fetchAll();
?>

<body>

<?php
		require_once("includes/menu.php"); //Menu bar
?>

<table>
  <tr>
    <th>Pseudo</th>
    <th></th>
    <th></th>
  </tr>
  <?php
    foreach($mes_demandes as $md){ 
  ?>  
  <tr>
    <form method="post">
      <td>
        <?= $md['membre_pseudo']?> 
        <input type="hidden" name="id_demande" value="<?= $md['id']?>"/>
      </td>
      <td>
        <input type="submit" name="accepter" value="Accepter"/>
      </td>
      <td>
        <input type="submit" name="refuser" value="Refuser"/>
      </td>
    </form>
  </tr>   
  <?php
    }
  ?>
</table>
</body>
</html>

<?php
if(isset($_POST['accepter'])){
  $id_demande = (int) $id_demande;
 
  $verifier_demande = $db->query("SELECT *
    FROM relation 
    WHERE id = ?",
    array($id_demande));
 
  $verifier_demande = $verifier_demande->fetch();
 
  if(isset($verifier_demande['id'])){
    $db->insert('UPDATE relation SET statut = ? WHERE id = ?',
      array(2, $verifier_demande['id']));
 
    header('Location: ./demandes-amis.php'); 
    exit;
  }
}
if(isset($_POST['refuser'])){
 
  $id_demande = (int) $id_demande;
 
  $db->insert('DELETE FROM relation WHERE id = ?',
    array($id_demande));
 
  header('Location: ./demandes-amis.php'); 
  exit;
}

?>
