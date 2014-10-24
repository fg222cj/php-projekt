<?php
namespace model;

require_once('./src/model/Municipality.php');
require_once('./src/model/Repository.php');

class MunicipalityRepository extends Repository {

	public function __construct() {

	}

	public function add(Municipality $municipality) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . MUNICIPALITY_TABLE . " (" . MUNICIPALITY_ID_COLUMN . ", " . MUNICIPALITY_NAME_COLUMN . ", " . MUNICIPALITY_COUNTY_ID_COLUMN . ") VALUES (?, ?, ?)";
		$params = array($municipality->getMunicipalityId(), $municipality->getName(), $municipality->getCountyId());
		
		$query = $db->prepare($sql);
		$query->execute($params);
	}

	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . MUNICIPALITY_TABLE . " WHERE " . MUNICIPALITY_ID_COLUMN . " = ?";
		$params = array($id);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetch();

		if ($result) {
			$municipality = new \model\Municipality($result[ID_COLUMN], $result[MUNICIPALITY_ID_COLUMN], $result[MUNICIPALITY_NAME_COLUMN], $result[MUNICIPALITY_COUNTY_ID_COLUMN]);
			return $municipality;
		}

		return null;
	}
	
	public function getFromDbByName($name) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . MUNICIPALITY_TABLE . " WHERE " . MUNICIPALITY_NAME_COLUMN . " = ?";
		$params = array($name);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetch();

		if ($result) {
			$municipality = new \model\Municipality($result[ID_COLUMN], $result[MUNICIPALITY_ID_COLUMN], $result[MUNICIPALITY_NAME_COLUMN], $result[MUNICIPALITY_COUNTY_ID_COLUMN]);
			return $municipality;
		}

		return null;
	}
	 
	public function delete(\model\Municipality $municipality) {
		$db = $this->connection();

		$sql = "DELETE FROM " . MUNICIPALITY_TABLE . " WHERE " . MUNICIPALITY_ID_COLUMN . " = ?";
		$params = array($municipality->getMunicipalityId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}

 	public function getFromXML($XMLPath, $foreignKey) {
 		$xml = $this->loadXML($XMLPath);
		$municipalities = array();
		foreach($xml->sokdata as $municipalityNode) {
			$municipality = new Municipality(0, $municipalityNode->id, $municipalityNode->namn, $foreignKey);
			$municipalities[] = $municipality;
		}
		return $municipalities;
 	}

}
