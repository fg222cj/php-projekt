<?php
namespace model;

require_once('./src/model/JobTitle.php');
require_once('./src/model/Repository.php');

class JobTitleRepository extends Repository {
	
	// Inserts object into db
	public function add(JobTitle $jobTitle) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . JOB_TITLE_TABLE . " (" . JOB_TITLE_ID_COLUMN . ", " . JOB_TITLE_NAME_COLUMN . ", " . JOB_TITLE_JOB_GROUP_ID_COLUMN . ") VALUES (?, ?, ?)";
		$params = array($jobTitle->getJobTitleId(), $jobTitle->getName(), $jobTitle->getJobGroupId());
		
		$query = $db->prepare($sql);
		$query->execute($params);
	}

	// Fetches object from db based on primary key id
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
	
	// Fetches multiple records from the db based on foreign key and returns them as objects in an array
	public function getFromDbByJobGroup($jobGroupId) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_TITLE_TABLE . " WHERE " . JOB_TITLE_JOB_GROUP_ID_COLUMN . " = ?";
		$params = array($jobGroupId);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetchAll();
		$jobTitles = array();

		foreach($result as $row) {
			$jobTitle = new JobTitle($row[ID_COLUMN], $row[JOB_TITLE_ID_COLUMN], $row[JOB_TITLE_NAME_COLUMN], $row[JOB_TITLE_JOB_GROUP_ID_COLUMN]);
			$jobTitles[] = $jobTitle;
		}

		return $jobTitles;
	}
	
	// Fetches object from db based on job title id
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
	
	// Fetches parent id (fk) and returns it
	public function getJobGroupIdFromDbByJobTitleId($jobTitleId) {
		$db = $this->connection();

		$sql = "SELECT " . JOB_TITLE_JOB_GROUP_ID_COLUMN . " FROM " . JOB_TITLE_TABLE . " WHERE " . JOB_TITLE_ID_COLUMN . " = ? LIMIT 1";
		$params = array($jobTitleId);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetch();

		return $result[0];
	}
	
	// Removes a record from the db
	public function delete(\model\JobTitle $jobTitle) {
		$db = $this->connection();

		$sql = "DELETE FROM " . JOB_TITLE_TABLE . " WHERE " . JOB_TITLE_ID_COLUMN . " = ?";
		$params = array($jobTitle->getJobTitleId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
	
	// Fetches records from an xml source and returns them as objects in an array
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
