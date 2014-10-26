<?php
namespace model;

require_once('./src/model/JobCategory.php');
require_once('./src/model/Repository.php');
require_once('./src/model/JobGroupRepository.php');

class JobCategoryRepository extends Repository {
	private $jobGroupRepository;
	
	public function __construct() {
		$this->jobGroupRepository = new JobGroupRepository();
	}

	public function add(JobCategory $jobCategory) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . JOB_CATEGORY_TABLE . " (" . JOB_CATEGORY_ID_COLUMN . ", " . JOB_CATEGORY_NAME_COLUMN . ") VALUES (?, ?)";
		$params = array($jobCategory->getJobCategoryId(), $jobCategory->getName());

		$query = $db->prepare($sql);
		$query->execute($params);
	}

	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_CATEGORY_TABLE . " WHERE " . JOB_CATEGORY_ID_COLUMN . " = ?";
		$params = array($unique);

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		if ($result) {
			$jobCategory = new \model\JobCategory($result[ID_COLUMN], $result[JOB_CATEGORY_ID_COLUMN], $result[JOB_CATEGORY_NAME_COLUMN]);
			return $jobCategory;
		}

		return null;
	}
	
	public function getAllFromDb() {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_CATEGORY_TABLE;

		$query = $db->prepare($sql);
		$query->execute();

		$result = $query->fetchAll();
		$jobCategories = array();
		
		foreach($result as $row) {
			$jobCategory = new JobCategory($row[ID_COLUMN], $row[JOB_CATEGORY_ID_COLUMN], $row[JOB_CATEGORY_NAME_COLUMN]);
			$jobCategories[] = $jobCategory;
		}
		
		return $jobCategories;
	}
	 
	public function delete(\model\JobCategory $jobCategory) {
		$db = $this -> connection();

		$sql = "DELETE FROM " . JOB_CATEGORY_TABLE . " WHERE " . JOB_CATEGORY_ID_COLUMN . " = ?";
		$params = array($jobCategory->getJobCategoryId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}

 	public function getFromXML($XMLPath) {
 		$xml = $this->loadXML($XMLPath);
		$jobCategories = array();
		foreach($xml->sokdata as $jobCategoryNode) {
			$jobCategory = new JobCategory(0, $jobCategoryNode->id, $jobCategoryNode->namn);
			$jobCategories[] = $jobCategory;
		}
		return $jobCategories;
 	}
}
