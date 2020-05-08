<?php

  class chat {

    private $id;
    private $id_pseudo;
    private $id_receveur;
    private $message;
    private $date_message;
    private $conn;

    function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
		function setId_pseudo($id_pseudo) { $this->id_pseudo = $id_pseudo; }
		function getId_pseudo() { return $this->id_pseudo; }
		function setId_receveur($id_receveur) { $this->id_receveur = $id_receveur; }
		function getId_receveur() { return $this->id_receveur; }
		function setMessage($message) { $this->message = $message; }
		function getMessage() { return $this->message; }
		function setDate_message($date_message) { $this->date_message = $date_message; }
		function getDate_message() { return $this->date_message; }

    public function __construct() {
			require_once('includes/identifiants.php');
			$conn = new DbConnect;
			$this->conn = $conn->connect();
		}

    public function getChatWithoutYourId(){

      $req = $this->conn->prepare("SELECT t.*, m.membre_pseudo FROM tchat t LEFT JOIN membres m ON m.membre_id = t.id_pseudo WHERE m.membre_id <> ? ORDER BY date_message DESC");
      $req->execute(array($_SESSION['id']));
      $voir_tchat = $req->fetchAll(PDO::FETCH_ASSOC);
      $voir_tchat = json_encode($voir_tchat);
      return $voir_tchat;

    }

    public function getJordanLeBogoss($id_receveur) {

      $requete = $this->conn->prepare("SELECT t.*, m.membre_pseudo FROM tchat t LEFT JOIN membres m ON m.membre_id = t.id_pseudo WHERE (id_receveur = ? AND id_pseudo = ?) OR (id_receveur = ? AND id_pseudo = ?) ORDER BY id ASC LIMIT 0,5000");
      $requete->execute(array($id_receveur, $_SESSION['id'], $_SESSION['id'] , $id_receveur));
      $donnees = $requete->fetchAll(PDO::FETCH_ASSOC);
      $donnees = json_encode($donnees);
      return $donnees;

    }

  }

 ?>
