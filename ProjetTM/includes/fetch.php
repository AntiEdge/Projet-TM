<?php

  session_start();

  require_once("identifiants.php");

  if(isset($_GET['view'])){

    $output = (String) "";

    if(!empty($_GET['view'])) {

      $db->insert("UPDTAE notification SET statut = ? WHERE statut = ?", array(1, 0));

    }

    $req = $db->prepare("SELECT * FROM notification WHERE id_user = ? ORDER BY id DESC LIMIT 10");
    $req->execute(array($_SESSION['id']));
    $req = $req->fetchAll();

    if(count($req) > 0){

      foreach ($req as $r) {

        $output = '<b><a href="demandes-amis.php">' . $r['sujet'] . '</a></b><br/>';

      }

    }
    else {

      $output .= '<li><a href="#"><b>Pas de notification</b></a></li>';

    }

    $req_statut = $db->prepare("SELECT * FROM notification WHERE statut = ? AND id_user = ?");
    $req_statut->execute(array(0,$_SESSION['id']));
    $req_statut = $req_statut->fetchAll();

    $count = count($req_statut);

    $data = array(

      'notification' => $output,
      'unseen_notification' => $count

    );

    echo json_encode($data);

  }

?>
