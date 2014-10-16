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

	public function add(JobGroup $jobGroup) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . JOB_GROUP_TABLE . " (" . JOB_GROUP_ID_COLUMN . ", " . JOB_GROUP_NAME_COLUMN . ", " . JOB_GROUP_JOB_CATEGORY_ID_COLUMN . ") VALUES (?, ?, ?)";
		$params = array($jobGroup->getJobGroupId(), $jobGroup->getName(), $jobGroup->getJobCategoryId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}

	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_GROUP_TABLE . " WHERE " . JOB_GROUP_ID_COLUMN . " = ?";
		$params = array($unique);

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		if ($result) {
			$jobGroup = new \model\JobGroup($result[JOB_GROUP_ID_COLUMN], $result[JOB_GROUP_NAME_COLUMN]);
			return $jobGroup;
		}

		return null;
	}
	 
	public function delete(\model\JobGroup $jobGroup) {
		$db = $this -> connection();

		$sql = "DELETE FROM " . JOB_GROUP_TABLE . " WHERE " . JOB_GROUP_ID_COLUMN . " = ?";
		$params = array($jobGroup->getJobGroupId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}

 	public function getFromXML($XMLPath, $foreignKey) {
 		$xml = $this->loadXML($XMLPath);
		$jobGroups = array();
		foreach($xml->sokdata as $jobGroupNode) {
			$jobGroup = new JobGroup(0, $jobGroupNode->id, $jobGroupNode->namn, $foreignKey);
			$jobGroups[] = $jobGroup;
		}
		return $jobGroups;
 	}
	
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
