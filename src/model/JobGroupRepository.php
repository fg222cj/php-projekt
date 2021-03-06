<?php
namespace model;

require_once('./src/model/JobGroup.php');
require_once('./src/model/Repository.php');
require_once('./src/model/JobTitleRepository.php');

class JobGroupRepository extends Repository {
	private $jobTitleRepository;
	
	public function __construct() {
		$this->jobTitleRepository = new JobTitleRepository();
	}

	// Inserts object into db
	public function add(JobGroup $jobGroup) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . JOB_GROUP_TABLE . " (" . JOB_GROUP_ID_COLUMN . ", " . JOB_GROUP_NAME_COLUMN . ", " . JOB_GROUP_JOB_CATEGORY_ID_COLUMN . ") VALUES (?, ?, ?)";
		$params = array($jobGroup->getJobGroupId(), $jobGroup->getName(), $jobGroup->getJobCategoryId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}

	// Fetches object from db based on primary key id
	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_GROUP_TABLE . " WHERE " . ID_COLUMN . " = ?";
		$params = array($id);

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		if ($result) {
			$jobGroup = new \model\JobGroup($result[ID_COLUMN], $result[JOB_GROUP_ID_COLUMN], $result[JOB_GROUP_NAME_COLUMN], $result[JOB_GROUP_JOB_CATEGORY_ID_COLUMN]);
			return $jobGroup;
		}

		return null;
	}
	
	// Fetches multiple records from the db based on foreign key and returns them as objects in an array
	public function getFromDbByJobCategory($jobCategoryId) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_GROUP_TABLE . " WHERE " . JOB_GROUP_JOB_CATEGORY_ID_COLUMN . " = ?";
		$params = array($jobCategoryId);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetchAll();
		$jobGroups = array();

		foreach($result as $row) {
			$jobGroup = new JobGroup($row[ID_COLUMN], $row[JOB_GROUP_ID_COLUMN], $row[JOB_GROUP_NAME_COLUMN], $row[JOB_GROUP_JOB_CATEGORY_ID_COLUMN]);
			$jobGroups[] = $jobGroup;
		}

		return $jobGroups;
	}
	
	// Fetches object from db based on job group id
	public function getFromDbByJobGroupId($jobGroupId) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_GROUP_TABLE . " WHERE " . JOB_GROUP_ID_COLUMN . " = ?";
		$params = array($jobGroupId);

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		if ($result) {
			$jobGroup = new \model\JobGroup($result[ID_COLUMN], $result[JOB_GROUP_ID_COLUMN], $result[JOB_GROUP_NAME_COLUMN], $result[JOB_GROUP_JOB_CATEGORY_ID_COLUMN]);
			return $jobGroup;
		}

		return null;
	}
	
	// Fetches parent id based on job group id
	public function getJobCategoryIdFromDbByJobGroupId($jobGroupId) {
		$db = $this->connection();

		$sql = "SELECT " . JOB_GROUP_JOB_CATEGORY_ID_COLUMN . " FROM " . JOB_GROUP_TABLE . " WHERE " . JOB_GROUP_ID_COLUMN . " = ? LIMIT 1";
		$params = array($jobGroupId);

		$query = $db->prepare($sql);
		$query -> execute($params);

		$result = $query->fetch();

		return $result[0];
	}
	
	// Removes a record from the db
	public function delete(\model\JobGroup $jobGroup) {
		$db = $this -> connection();

		$sql = "DELETE FROM " . JOB_GROUP_TABLE . " WHERE " . JOB_GROUP_ID_COLUMN . " = ?";
		$params = array($jobGroup->getJobGroupId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
	
	// Fetches records from an xml source and returns them as objects in an array
 	public function getFromXML($XMLPath, $foreignKey) {
 		$xml = $this->loadXML($XMLPath);
		$jobGroups = array();
        if(isset($xml) && is_object($xml)) {
            foreach ($xml->sokdata as $jobGroupNode) {
                $jobGroup = new JobGroup(0, $jobGroupNode->id, $jobGroupNode->namn, $foreignKey);
                $jobGroups[] = $jobGroup;
            }
        }
		return $jobGroups;
 	}
	
	// Fetches children from xml source and inserts them into the db
	public function populateJobTables($XMLPath, $foreignKey) {
		$jobGroups = $this->getFromXML($XMLPath, $foreignKey);
		foreach($jobGroups as $jobGroup) {
			$this->add($jobGroup);
			
			$jobTitles = $this->jobTitleRepository->getFromXML(BASE_PATH . AD_PATH . SEARCH_LIST_PATH . JOB_TITLE_PATH . $jobGroup->getJobGroupId(), $jobGroup->getJobGroupId());
			
			foreach($jobTitles as $jobTitle) {
				$this->jobTitleRepository->add($jobTitle);
			}
			set_time_limit(40);
		}
	}

}
