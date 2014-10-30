<?php
namespace model;

require_once('./src/model/Ad.php');
require_once('./src/model/Repository.php');

class AdRepository extends Repository {
	
	public function __construct() {
	}
	
	// Inserts object into db
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
	
	// Fetches object from db based on primary key id
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
	
	// Counts the number of records in the db that match the parameters and returns an array with the count and additional data
	public function getCount($keyword = null, $jobTitle = null, $jobGroup = null, $jobCategory = null, $municipality = null, $county = null) {
		$db = $this->connection();
		
		$params = array();
		$whereClauses = "WHERE ";
		
		if(isset($keyword)) {
			$whereClauses .= JOB_AD_TEXT_COLUMN . " LIKE ?";
			$params[] = "%$keyword%";
		}
		
		if(isset($jobTitle)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_JOB_TITLE_ID_COLUMN . " = ?";
			$params[] = $jobTitle;
		}
		
		if(isset($jobGroup)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_JOB_GROUP_ID_COLUMN . " = ?";
			$params[] = $jobGroup;
		}
		
		if(isset($jobCategory)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_JOB_CATEGORY_ID_COLUMN . " = ?";
			$params[] = $jobCategory;
		}
		
		if(isset($municipality)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_MUNICIPALITY_ID_COLUMN . " = ?";
			$params[] = $municipality;
		}
		
		if(isset($county)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_COUNTY_ID_COLUMN . " = ?";
			$params[] = $county;
		}
		
		// If there aren't any clauses in the request we clear this string before it's put into the sql query.
		if($whereClauses == "WHERE ") {
			$whereClauses = "";
		}

		// Groups instances by week and year. Fetches the year and the week as well as the total number of available positions in the matching records.
		$sql = "SELECT YEAR(" . JOB_AD_PUBLICATION_DATE_COLUMN . "), WEEK(" . JOB_AD_PUBLICATION_DATE_COLUMN . "), SUM(" . JOB_AD_POSITIONS_AVAILABLE_COLUMN . ") FROM " . JOB_AD_TABLE . " 
		" . $whereClauses . " GROUP BY YEARWEEK(" . JOB_AD_PUBLICATION_DATE_COLUMN . ") ORDER BY YEARWEEK(" . JOB_AD_PUBLICATION_DATE_COLUMN . ") ASC";
		
		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetchAll();
		return $result;
	}
	
	// Fetches job titles related to the search parameters.
	public function getRelatedJobTitlesData($keyword = null, $jobTitle = null, $jobGroup = null, $jobCategory = null, $municipality = null, $county = null) {
		$db = $this->connection();
		
		$params = array();
		
		$whereClauses = "WHERE ";
		
		if(isset($keyword)) {
			$whereClauses .= JOB_AD_TEXT_COLUMN . " LIKE ?";
			$params[] = "%$keyword%";
		}
		
		if(isset($jobTitle)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_JOB_TITLE_ID_COLUMN . " = ?";
			$params[] = $jobTitle;
		}
		
		if(isset($jobGroup)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_JOB_GROUP_ID_COLUMN . " = ?";
			$params[] = $jobGroup;
		}
		
		if(isset($jobCategory)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_JOB_CATEGORY_ID_COLUMN . " = ?";
			$params[] = $jobCategory;
		}
		
		if(isset($municipality)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_MUNICIPALITY_ID_COLUMN . " = ?";
			$params[] = $municipality;
		}
		
		if(isset($county)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_COUNTY_ID_COLUMN . " = ?";
			$params[] = $county;
		}
		
		// If there aren't any clauses in the request we clear this string before it's put into the sql query.
		if($whereClauses == "WHERE ") {
			$whereClauses = "";
		}
		
		$sql = "SELECT " . JOB_AD_JOB_TITLE_ID_COLUMN . ", SUM(" . JOB_AD_POSITIONS_AVAILABLE_COLUMN . ") FROM " . JOB_AD_TABLE . " " . $whereClauses . " 
		GROUP BY " . JOB_AD_JOB_TITLE_ID_COLUMN . " ORDER BY SUM(" . JOB_AD_POSITIONS_AVAILABLE_COLUMN . ") DESC LIMIT 10";
		
		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetchAll();
		return $result;
	}
	
	// Fetches counties related to the search parameters.
	public function getRelatedCountiesData($keyword = null, $jobTitle = null, $jobGroup = null, $jobCategory = null, $municipality = null, $county = null) {
		$db = $this->connection();
		
		$params = array();
		
		$whereClauses = "WHERE ";
		
		if(isset($keyword)) {
			$whereClauses .= JOB_AD_TEXT_COLUMN . " LIKE ?";
			$params[] = "%$keyword%";
		}
		
		if(isset($jobTitle)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_JOB_TITLE_ID_COLUMN . " = ?";
			$params[] = $jobTitle;
		}
		
		if(isset($jobGroup)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_JOB_GROUP_ID_COLUMN . " = ?";
			$params[] = $jobGroup;
		}
		
		if(isset($jobCategory)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_JOB_CATEGORY_ID_COLUMN . " = ?";
			$params[] = $jobCategory;
		}
		
		if(isset($municipality)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_MUNICIPALITY_ID_COLUMN . " = ?";
			$params[] = $municipality;
		}
		
		if(isset($county)) {
			// if $whereClauses is not in its original state, that means there's another clause before this one. In that case we add an "AND" before the clause.
			if($whereClauses != "WHERE ") {
				$whereClauses .= " AND ";
			}
			$whereClauses .= JOB_AD_COUNTY_ID_COLUMN . " = ?";
			$params[] = $county;
		}
		
		// If there aren't any clauses in the request we clear this string before it's put into the sql query.
		if($whereClauses == "WHERE ") {
			$whereClauses = "";
		}
		
		$sql = "SELECT " . JOB_AD_COUNTY_ID_COLUMN . ", SUM(" . JOB_AD_POSITIONS_AVAILABLE_COLUMN . ") FROM " . JOB_AD_TABLE . " " . $whereClauses . " 
		GROUP BY " . JOB_AD_COUNTY_ID_COLUMN . " ORDER BY SUM(" . JOB_AD_POSITIONS_AVAILABLE_COLUMN . ") DESC LIMIT 10";
		
		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetchAll();
		return $result;
	}

	// Used to discern relevant keywords.
	public function getUnsortedWordByJobCategory($jobCategoryId) {
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
	
	// Removes a record from the db
	public function delete(\model\Ad $ad) {
		$db = $this -> connection();

		$sql = "DELETE FROM " . JOB_AD_TABLE . " WHERE " . JOB_AD_ID_COLUMN . " = ?";
		$params = array($ad->getJobAdId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
}
