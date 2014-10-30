<?php
namespace model;

require_once('./src/model/Keyword.php');
require_once('./src/model/Repository.php');

class KeywordRepository extends Repository {
	// Inserts object into db
	public function add(\model\Keyword $keyword) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . KEYWORD_TABLE . " (" . KEYWORD_NAME . ", " . KEYWORD_RELEVANT . ", " . KEYWORD_JOB_CATEGORY_ID . ") VALUES (?, ?, ?)";
		$params = array($keyword->getKeyword(), $keyword->getRelevant(), $keyword->getJobCategoryId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
	
	// Fetches object from db based on primary key id
	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . KEYWORD_TABLE . " WHERE " . ID_COLUMN . " = ?";
		$params = array($id);

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		if ($result) {
			$keyword = new \model\Keyword($result[ID_COLUMN], $result[KEYWORD_NAME], $result[KEYWORD_RELEVANT], $result[KEYWORD_JOB_CATEGORY_ID]);
			return $keyword;
		}

		return null;
	}
	
	// Fetches all rows from db as objects in an array
	public function getAllFromDb() {
		$db = $this->connection();

		$sql = "SELECT * FROM " . KEYWORD_TABLE;

		$query = $db->prepare($sql);
		$query->execute();

		$result = $query->fetchAll();
		$keywords = array();
		
		foreach($result as $row) {
			$keyword = new Keyword($row[ID_COLUMN], $row[KEYWORD_NAME], $row[KEYWORD_RELEVANT], $row[KEYWORD_JOB_CATEGORY_ID]);
			$keywords[] = $keyword;
		}
		
		return $keywords;
	}
	
	// Fetches all keyword-related records from the db and returns them as objects in an array
	public function getAllRelevantFromDbByJobCategory($jobCategoryId) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . KEYWORD_TABLE . " WHERE " . KEYWORD_RELEVANT . " = TRUE AND " . KEYWORD_JOB_CATEGORY_ID . " = ?";

		$query = $db->prepare($sql);
		$query->execute();

		$result = $query->fetchAll();
		$keywords = array();
		
		foreach($result as $row) {
			$keyword = new Keyword($row[ID_COLUMN], $row[KEYWORD_NAME], $row[KEYWORD_RELEVANT], $row[KEYWORD_JOB_CATEGORY_ID]);
			$keywords[] = $keyword;
		}
		
		return $keywords;
	}
	
	// Removes a record from the db
	public function delete(\model\JobCategory $jobCategory) {
		$db = $this -> connection();

		$sql = "DELETE FROM " . JOB_CATEGORY_TABLE . " WHERE " . JOB_CATEGORY_ID_COLUMN . " = ?";
		$params = array($jobCategory->getJobCategoryId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
	
	// Fetches records from an xml source and returns them as objects in an array
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
