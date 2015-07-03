<?php
namespace model;

require_once('./src/model/County.php');
require_once('./src/model/Repository.php');
require_once('./src/model/MunicipalityRepository.php');

class CountyRepository extends Repository {
	private $municipalityRepository;
	
	public function __construct() {
		$this->municipalityRepository = new MunicipalityRepository();
	}

	// Inserts object into db
	public function add(County $county) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . COUNTY_TABLE . " (" . COUNTY_ID_COLUMN . ", " . COUNTY_NAME_COLUMN . ") VALUES (?, ?)";
		$params = array($county->getCountyId(), $county->getName());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
	
	// Fetches all rows from db as objects in an array
	public function getAllFromDb() {
		$db = $this->connection();

		$sql = "SELECT * FROM " . COUNTY_TABLE;

		$query = $db->prepare($sql);
		$query->execute();

		$result = $query->fetchAll();
		$counties = array();
		
		foreach($result as $row) {
			$county = new County($row[ID_COLUMN], $row[COUNTY_ID_COLUMN], $row[COUNTY_NAME_COLUMN]);
			$counties[] = $county;
		}
		
		return $counties;
	}

	// Fetches object from db based on primary key id
	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . COUNTY_TABLE . " WHERE " . ID_COLUMN . " = ?";
		$params = array($id);

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		if ($result) {
			$county = new \model\County($result[ID_COLUMN], $result[COUNTY_ID_COLUMN], $result[COUNTY_NAME_COLUMN]);
			return $county;
		}

		return null;
	}
	
	// Fetches object from db by county id
	public function getFromDbByCountyId($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . COUNTY_TABLE . " WHERE " . COUNTY_ID_COLUMN . " = ?";
		$params = array($id);

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		if ($result) {
			$county = new \model\County($result[ID_COLUMN], $result[COUNTY_ID_COLUMN], $result[COUNTY_NAME_COLUMN]);
			return $county;
		}

		return null;
	}
	
	// Removes a record from the db
	public function delete(\model\County $county) {
		$db = $this -> connection();

		$sql = "DELETE FROM " . COUNTY_TABLE . " WHERE " . COUNTY_ID_COLUMN . " = ?";
		$params = array($county->getCountyId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
	
	// Fetches records from an xml source and returns them as objects in an array
 	public function getFromXML($XMLPath) {
 		$xml = $this->loadXML($XMLPath);
		$counties = array();
        if(isset($xml) && is_object($xml)) {
            foreach ($xml->sokdata as $countyNode) {
                $county = new County(0, $countyNode->id, $countyNode->namn);
                $counties[] = $county;
            }
        }
		return $counties;
 	}
}
