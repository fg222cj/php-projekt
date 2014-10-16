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
		/*
		foreach($participant->getProjects()->toArray() as $project) {
			$sql = "INSERT INTO ".self::$projectTable." (" . MUNICIPALITY_ID_COLUMN . ", " . MUNICIPALITY_NAME_COLUMN . ", participantUnique) VALUES (?, ?, ?)";
			$query = $db->prepare($sql);
			$query->execute(array($project->getUnique(), $project->getName(), $participant->getUnique()));
		}
		 */
	}

	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . MUNICIPALITY_TABLE . " WHERE " . MUNICIPALITY_ID_COLUMN . " = ?";
		$params = array($unique);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetch();

		if ($result) {
			$municipality = new \model\Municipality($result[MUNICIPALITY_ID_COLUMN], $result[MUNICIPALITY_NAME_COLUMN]);
			// Hämtar allt som tillhör ovan objekt.
			/*
			$sql = "SELECT * FROM ".self::$projectTable. " WHERE ".ProjectRepository::$owner." = ?";
			$query = $db->prepare($sql);
			$query->execute (array($result[MUNICIPALITY_ID_COLUMN]));
			$projects = $query->fetchAll();
			foreach($projects as $project) {
				$proj = new Project($project['projectName'], $project['uniqueKey']);
				$user->add($proj);
			}
			 * */
			return $municipality;
		}

		return null;
	}

	/*
	public function find($unique) {
		$db = $this -> connection();

		$sql = "SELECT * FROM MUNICIPALITY_TABLE WHERE " . MUNICIPALITY_ID_COLUMN . " LIKE '%:unique%'";
		$params = array($unique);

		$query = $db -> prepare($sql);
		$query -> execute(array(':unique' => $unique));

		$participantList = new \model\ParticipantList();

		foreach ($query->fetchAll() as $result) {
			$participantList -> add(new \model\Participant($result[MUNICIPALITY_NAME_COLUMN], $result[MUNICIPALITY_ID_COLUMN]));
		}

		return $participantList;

	}
	 */
	 
	public function delete(\model\Municipality $municipality) {
		$db = $this->connection();

		$sql = "DELETE FROM " . MUNICIPALITY_TABLE . " WHERE " . MUNICIPALITY_ID_COLUMN . " = ?";
		$params = array($municipality->getMunicipalityId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
/*
	public function toList() {
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM MUNICIPALITY_TABLE";
			$query = $db -> prepare($sql);
			$query -> execute();

			foreach ($query->fetchAll() as $owner) {
				$name = $owner['name'];
				$unique = $owner['uniqueKey'];

				$parti = new Participant($name, $unique);

				$this -> participants -> add($parti);
			}

			return $this -> participants;
		} catch (\PDOException $e) {
			echo '<pre>';
			var_dump($e);
			echo '</pre>';

			die('Error while connection to database.');
		}
	}
 * 
 */
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
