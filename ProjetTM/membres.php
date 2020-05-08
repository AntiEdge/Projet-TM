<?php

  class membres {

    private $membre_id;
    private $membre_pseudo;
    private $membre_password;
    private $membre_email;
    private $membre_date_inscription;
    private $conn;

    function setMembre_id($membre_id) { $this->membre_id = $membre_id; }
		function getMembre_id() { return $this->id; }
		function setMembre_pseudo($membre_pseudo) { $this->membre_pseudo = $membre_pseudo; }
		function getMembre_pseudo() { return $this->membre_pseudo; }
		function setMembre_password($membre_password) { $this->membre_password = $membre_password; }
		function getMembre_password() { return $this->membre_password; }
		function setMembre_email($membre_email) { $this->membre_email = $membre_email; }
		function getMembre_email() { return $this->membre_email; }
		function setMembre_date_inscription($membre_date_inscription) { $this->membre_date_inscription = $membre_date_inscription; }
		function getMembre_date_inscription() { return $this->membre_date_inscription; }

    public function __construct() {
			require_once('includes/identifiants.php');
			$conn = new DbConnect;
			$this->conn = $conn->connect();
		}

    public function getMembre($pseudo_receveur){

      $req = $this->conn->prepare("SELECT * FROM membres WHERE membre_pseudo = ?");
      $req->execute(array($pseudo_receveur));
      $receveur = $req->fetch(PDO::FETCH_ASSOC);
      $receveur = json_encode($receveur);
      return $receveur;

    }

    public function getMembre2($pseudo){

      $query=$this->conn->prepare('SELECT membre_mdp, membre_id, membre_pseudo
      FROM membres WHERE membre_pseudo = :pseudo');
      $query->bindValue(':pseudo',$pseudo, PDO::PARAM_STR);
      $query->execute();
      $data=$query->fetch(PDO::FETCH_ASSOC);
      $data = json_encode($data);
      return $data;

    }

    public function getMembre3(){

      $afficher_membre = $this->conn->prepare("SELECT * FROM membres WHERE membre_id <> ?");
    	$afficher_membre->execute(array($_SESSION['id']));
      $afficher_m->$afficher_membre->fetch();
      $afficher_m = json_encode($afficher_m);
      return $afficher_m;

    }

  }

 ?>
