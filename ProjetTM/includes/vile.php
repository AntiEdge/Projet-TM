<?php

	class ville	{
		private $id;
		private $name;
		private $address;
		private $type;
		private $lat;
		private $lng;
		private $conn;
		private $nbmask;
		private $membre_id;
// variable pour le nom de la table qu'on récupère dans la requête sql.
		private $tableName = "localisation";

//getters et setters de ma classe correspondant aux attributs de la db
		function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
		function setName($name) { $this->name = $name; }
		function getName() { return $this->name; }
		function setAddress($address) { $this->address = $address; }
		function getAddress() { return $this->address; }
		function setType($type) { $this->type = $type; }
		function getType() { return $this->type; }
		function setLat($lat) { $this->lat = $lat; }
		function getLat() { return $this->lat; }
		function setLng($lng) { $this->lng = $lng; }
		function getLng() { return $this->lng; }
		function setNbmask($lng) { $this->nbmask = $nbmask; }
		function getNbmask() { return $this->nbmask; }
		function setMembre_id($lng) { $this->membre_id = $membre_id; }
		function getMembre_id() { return $this->membre_id; }

//Constructeur de ma classe ville, l'on crée un objet connexion pour établir la connexion à la db
		public function __construct() {
			require_once('identifiants.php');
			$conn = new identifiants;
			$this->conn = $conn->connect();
		}

//fonction sql permettant de récupérer uniquement les villes qui n'ont pas encore de lat et lng
		public function getCitysBlankLatLng() {
			$sql = "SELECT * FROM $this->tableName WHERE lat IS NULL AND lng IS NULL";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
//PDO::FETCH_ASSOC : retourne tous les éléments en tant qu'un tableau indexé par le nom des colonnes.
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

// fonction sql permettant de récupérer toutes les villes de la db
		public function getAllCitys() {
			$sql = "SELECT * FROM $this->tableName";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

//fonction permettant de mettre à jours les coordonnées de notre ville dans la db.
		public function updateCitysWithLatLng() {
			$sql = "UPDATE $this->tableName SET lat = :lat, lng = :lng WHERE id = :id";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':lat', $this->lat);
			$stmt->bindParam(':lng', $this->lng);
			$stmt->bindParam(':id', $this->id);

			if($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		}
	}

?>
