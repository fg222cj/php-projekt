<?php
namespace model;

require_once('./src/model/Ad.php');
require_once('./src/model/Repository.php');

class AdRepository extends Repository {
	
	public function __construct() {
	}

	public function add(\model\Ad $ad) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . JOB_AD_TABLE . " (" . JOB_AD_ID_COLUMN . ", " . JOB_AD_HEADING_COLUMN . ", " . JOB_AD_TEXT_COLUMN . ", " . JOB_AD_TITLE_COLUMN . ",
		 " . JOB_AD_JOB_TITLE_ID_COLUMN . ", " . JOB_AD_PUBLICATION_DATE_COLUMN . ", " . JOB_AD_POSITIONS_AVAILABLE_COLUMN . ", " . JOB_AD_MUNICIPALITY_NAME_COLUMN . ", 
		 " . JOB_AD_MUNICIPALITY_ID_COLUMN . ", " . JOB_AD_COUNTY_ID_COLUMN . ", " . JOB_AD_JOB_GROUP_ID_COLUMN . ", " . JOB_AD_JOB_CATEGORY_ID_COLUMN . ") 
		 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$params = array($ad->getAdId(), $ad->getAdHeading(), $ad->getAdText(), $ad->getJobTitle(), $ad->getJobId(), $ad->getPublicationDate(),
		 $ad->getPositionsAvailable(), $ad->getMunicipalityName(), $ad->getMunicipalityId(), $ad->getCountyId(), $ad->getJobGroupId(), $ad->getJobCategoryId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}

	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_AD_TABLE . " WHERE " . ID_COLUMN . " = ?";
		$params = array($id);

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		if ($result) {
			$ad = new \model\Ad($result[ID_COLUMN], $result[JOB_AD_ID_COLUMN], $result[JOB_AD_HEADING_COLUMN], $result[JOB_AD_TEXT_COLUMN], $result[JOB_AD_TITLE_COLUMN], 
			$result[JOB_AD_JOB_TITLE_ID_COLUMN], $result[JOB_AD_PUBLICATION_DATE_COLUMN], $result[JOB_AD_POSITIONS_AVAILABLE_COLUMN], $result[JOB_AD_MUNICIPALITY_NAME_COLUMN], 
			$result[JOB_AD_MUNICIPALITY_ID_COLUMN], $result[JOB_AD_COUNTY_ID_COLUMN], $result[JOB_AD_JOB_GROUP_ID_COLUMN], $result[JOB_AD_JOB_CATEGORY_ID_COLUMN]);
			return $ad;
		}

		return null;
	}
	
	public function getCount($keyword, $jobTitle = null, $jobGroup = null, $jobCategory = null, $municipality = null, $county = null) {
		$db = $this->connection();
		$params = array();
		$params[] = "%$keyword%";
		
		$additionalWhere = "";
		
		if(isset($jobTitle)) {
			$additionalWhere .= " AND WHERE " . JOB_AD_JOB_TITLE_ID_COLUMN . " = ? ";
			$params[] = $jobTitle;
		}
		
		if(isset($jobGroup)) {
			$additionalWhere .= " AND WHERE " . JOB_AD_JOB_GROUP_ID_COLUMN . " = ? ";
			$params[] = $jobGroup;
		}
		
		if(isset($jobCategory)) {
			$additionalWhere .= " AND WHERE " . JOB_AD_JOB_CATEGORY_ID_COLUMN . " = ? ";
			$params[] = $jobCategory;
		}
		
		if(isset($municipality)) {
			$additionalWhere .= " AND WHERE " . JOB_AD_MUNICIPALITY_ID_COLUMN . " = ? ";
			$params[] = $municipality;
		}
		
		if(isset($county)) {
			$additionalWhere .= " AND WHERE " . JOB_AD_COUNTY_ID_COLUMN . " = ? ";
			$params[] = $county;
		}

		$sql = "SELECT YEAR(" . JOB_AD_PUBLICATION_DATE_COLUMN . "), WEEK(" . JOB_AD_PUBLICATION_DATE_COLUMN . "), SUM(" . JOB_AD_POSITIONS_AVAILABLE_COLUMN . ") FROM " . JOB_AD_TABLE . " 
		WHERE " . JOB_AD_TEXT_COLUMN . " LIKE ? " . $additionalWhere . " GROUP BY YEARWEEK(" . JOB_AD_PUBLICATION_DATE_COLUMN . ") ORDER BY YEARWEEK(" . JOB_AD_PUBLICATION_DATE_COLUMN . ") ASC";
		
		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetchAll();
		return $result;
	}

	public function getRelatedJobTitlesData($keyword) {
		$db = $this->connection();
		
		$sql = "SELECT " . JOB_AD_JOB_TITLE_ID_COLUMN . ", SUM(" . JOB_AD_POSITIONS_AVAILABLE_COLUMN . ") FROM " . JOB_AD_TABLE . " WHERE " . JOB_AD_TEXT_COLUMN . " LIKE ? 
		GROUP BY " . JOB_AD_JOB_TITLE_ID_COLUMN . " ORDER BY SUM(" . JOB_AD_POSITIONS_AVAILABLE_COLUMN . ") DESC LIMIT 10";
		
		$params = array();
		$params[] = "%$keyword%";
		
		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetchAll();
		return $result;
	}
	 
	public function delete(\model\Ad $ad) {
		$db = $this -> connection();

		$sql = "DELETE FROM " . JOB_AD_TABLE . " WHERE " . JOB_AD_ID_COLUMN . " = ?";
		$params = array($ad->getJobAdId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
}
