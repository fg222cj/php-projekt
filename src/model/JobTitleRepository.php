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
	}

	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_TITLE_TABLE . " WHERE " . ID_COLUMN . " = ?";
		$params = array($id);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetch();

		if ($result) {
			$jobTitle = new \model\JobTitle($result[ID_COLUMN], $result[JOB_TITLE_ID_COLUMN], $result[JOB_TITLE_NAME_COLUMN], $result[JOB_TITLE_JOB_GROUP_ID_COLUMN]);
			return $jobTitle;
		}

		return null;
	}
	
	public function getFromDbByJobId($jobId) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_TITLE_TABLE . " WHERE " . JOB_TITLE_ID_COLUMN . " = ?";
		$params = array($jobId);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetch();

		if ($result) {
			$jobTitle = new \model\JobTitle($result[ID_COLUMN], $result[JOB_TITLE_ID_COLUMN], $result[JOB_TITLE_NAME_COLUMN], $result[JOB_TITLE_JOB_GROUP_ID_COLUMN]);
			return $jobTitle;
		}

		return null;
	}
	 
	public function delete(\model\JobTitle $jobTitle) {
		$db = $this->connection();

		$sql = "DELETE FROM " . JOB_TITLE_TABLE . " WHERE " . JOB_TITLE_ID_COLUMN . " = ?";
		$params = array($jobTitle->getJobTitleId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}

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
