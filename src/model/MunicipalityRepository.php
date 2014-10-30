<?php
namespace model;

require_once('./src/model/Municipality.php');
require_once('./src/model/Repository.php');

class MunicipalityRepository extends Repository {

	// Inserts object into db
	public function add(Municipality $municipality) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . MUNICIPALITY_TABLE . " (" . MUNICIPALITY_ID_COLUMN . ", " . MUNICIPALITY_NAME_COLUMN . ", " . MUNICIPALITY_COUNTY_ID_COLUMN . ") VALUES (?, ?, ?)";
		$params = array($municipality->getMunicipalityId(), $municipality->getName(), $municipality->getCountyId());
		
		$query = $db->prepare($sql);
		$query->execute($params);
	}

	// Fetches object from db based on primary key id
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
	
	// Fetches all rows from db as objects in an array
	public function getAllFromDb() {
		$db = $this->connection();

		$sql = "SELECT * FROM " . MUNICIPALITY_TABLE;

		$query = $db->prepare($sql);
		$query->execute();

		$result = $query->fetchAll();
		$municipalities = array();
		
		foreach($result as $row) {
			$municipality = new Municipality($row[ID_COLUMN], $row[MUNICIPALITY_ID_COLUMN], $row[MUNICIPALITY_NAME_COLUMN], $row[MUNICIPALITY_COUNTY_ID_COLUMN]);
			$municipalities[] = $municipality;
		}
		
		return $municipalities;
	}
	
	// Fetches multiple records from the db based on foreign key and returns them as objects in an array
	public function getFromDbByCounty($countyId) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . MUNICIPALITY_TABLE . " WHERE " . MUNICIPALITY_COUNTY_ID_COLUMN . " = ?";
		$params = array($countyId);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetchAll();
		$municipalities = array();

		foreach($result as $row) {
			$municipality = new Municipality($row[ID_COLUMN], $row[MUNICIPALITY_ID_COLUMN], $row[MUNICIPALITY_NAME_COLUMN], $row[MUNICIPALITY_COUNTY_ID_COLUMN]);
			$municipalities[] = $municipality;
		}

		return $municipalities;
	}
	
	// Fetches parent id (fk) and returns it
	public function getCountyIdFromDbByMunicipalityId($municipalityId) {
		$db = $this->connection();

		$sql = "SELECT " . MUNICIPALITY_COUNTY_ID_COLUMN . " FROM " . MUNICIPALITY_TABLE . " WHERE " . MUNICIPALITY_ID_COLUMN . " = ? LIMIT 1";
		$params = array($municipalityId);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetch();

		return $result[0];
	}
	
	// Fetches object from db by municipality name
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
	
	// Removes a record from the db
	public function delete(\model\Municipality $municipality) {
		$db = $this->connection();

		$sql = "DELETE FROM " . MUNICIPALITY_TABLE . " WHERE " . MUNICIPALITY_ID_COLUMN . " = ?";
		$params = array($municipality->getMunicipalityId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
	
	// Fetches records from an xml source and returns them as objects in an array
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
