<?php
namespace model;

require_once('./src/model/JobTitle.php');
require_once('./src/model/Repository.php');

class JobTitleRepository extends Repository {

	public function __construct() {

	}

	public function add(JobTitle $jobTitle) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . JOB_TITLE_TABLE . " (" . JOB_TITLE_ID_COLUMN . ", " . JOB_TITLE_NAME_COLUMN . ", " . JOB_TITLE_JOB_GROUP_ID_COLUMN . ") VALUES (?, ?, ?)";
		$params = array($jobTitle->getJobTitleId(), $jobTitle->getName(), $jobTitle->getJobGroupId());
		
		$query = $db->prepare($sql);
		$query->execute($params);
		/*
		foreach($participant->getProjects()->toArray() as $project) {
			$sql = "INSERT INTO ".self::$projectTable." (" . JOB_TITLE_ID_COLUMN . ", " . JOB_TITLE_NAME_COLUMN . ", participantUnique) VALUES (?, ?, ?)";
			$query = $db->prepare($sql);
			$query->execute(array($project->getUnique(), $project->getName(), $participant->getUnique()));
		}
		 */
	}

	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_TITLE_TABLE . " WHERE " . JOB_TITLE_ID_COLUMN . " = ?";
		$params = array($unique);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetch();

		if ($result) {
			$jobTitle = new \model\JobTitle($result[JOB_TITLE_ID_COLUMN], $result[JOB_TITLE_NAME_COLUMN]);
			// Hämtar allt som tillhör ovan objekt.
			/*
			$sql = "SELECT * FROM ".self::$projectTable. " WHERE ".ProjectRepository::$owner." = ?";
			$query = $db->prepare($sql);
			$query->execute (array($result[JOB_TITLE_ID_COLUMN]));
			$projects = $query->fetchAll();
			foreach($projects as $project) {
				$proj = new Project($project['projectName'], $project['uniqueKey']);
				$user->add($proj);
			}
			 * */
			return $jobTitle;
		}

		return null;
	}

	/*
	public function find($unique) {
		$db = $this -> connection();

		$sql = "SELECT * FROM JOB_TITLE_TABLE WHERE " . JOB_TITLE_ID_COLUMN . " LIKE '%:unique%'";
		$params = array($unique);

		$query = $db -> prepare($sql);
		$query -> execute(array(':unique' => $unique));

		$participantList = new \model\ParticipantList();

		foreach ($query->fetchAll() as $result) {
			$participantList -> add(new \model\Participant($result[JOB_TITLE_NAME_COLUMN], $result[JOB_TITLE_ID_COLUMN]));
		}

		return $participantList;

	}
	 */
	 
	public function delete(\model\JobTitle $jobTitle) {
		$db = $this->connection();

		$sql = "DELETE FROM " . JOB_TITLE_TABLE . " WHERE " . JOB_TITLE_ID_COLUMN . " = ?";
		$params = array($jobTitle->getJobTitleId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
/*
	public function toList() {
		try {
			$db = $this -> connection();

			$sql = "SELECT * FROM JOB_TITLE_TABLE";
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
		$jobTitles = array();
		foreach($xml->sokdata as $jobTitleNode) {
			$jobTitle = new JobTitle(0, $jobTitleNode->id, $jobTitleNode->namn, $foreignKey);
			$jobTitles[] = $jobTitle;
		}
		return $jobTitles;
 	}

}
