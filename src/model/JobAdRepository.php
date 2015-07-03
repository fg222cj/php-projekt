<?php
namespace model;

require_once('./src/model/JobAd.php');
require_once('./src/model/Repository.php');
require_once('./src/model/CountyRepository.php');

class JobAdRepository extends Repository {
	private $countyRepository;
	
	public function __construct() {
		$this->countyRepository = new CountyRepository();
	}

	// Inserts object into db
	public function add(JobAd $jobAd) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . JOB_AD_TABLE . " (" . JOB_AD_ID_COLUMN . ", " . JOB_AD_HEADING_COLUMN . ", " . JOB_AD_TEXT_COLUMN . ", " . JOB_AD_TITLE_COLUMN . ",
		 " . JOB_AD_JOB_TITLE_ID_COLUMN . ", " . JOB_AD_PUBLICATION_DATE_COLUMN . ", " . JOB_AD_POSITIONS_AVAILABLE_COLUMN . ", " . JOB_AD_MUNICIPALITY_NAME_COLUMN . ") VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$params = array($jobAd->getAdId(), $jobAd->getAdHeading(), $jobAd->getAdText(), $jobAd->getJobTitle(), $jobAd->getJobId(),
		 $jobAd->getPublicationDate(), $jobAd->getPositionsAvailable(), $jobAd->getMunicipalityName());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
	
	// Fetches object from db based on primary key id
	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . JOB_AD_TABLE . " WHERE " . JOB_AD_ID_COLUMN . " = ?";
		$params = array($unique);

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		if ($result) {
			$jobAd = new \model\JobAd($result[JOB_AD_ID_COLUMN], $result[JOB_AD_HEADING_COLUMN]);
			return $jobAd;
		}

		return null;
	}
	
	// Counts the number of records in the db that match the parameter
	public function getCount($keyword) {
		$db = $this->connection();

		$sql = "SELECT COUNT(*) FROM " . JOB_AD_TABLE . " WHERE " . JOB_AD_TEXT_COLUMN . " LIKE ?";
		$params = array("%$keyword%");

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetchColumn();

		return $result;

	}
	
	// Removes a record from the db
	public function delete(\model\JobAd $jobAd) {
		$db = $this -> connection();

		$sql = "DELETE FROM " . JOB_AD_TABLE . " WHERE " . JOB_AD_ID_COLUMN . " = ?";
		$params = array($jobAd->getJobAdId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
	
	// Fetches records from an xml source and returns them as objects in an array
 	public function getFromXML($XMLPath) {
 		$xml = $this->loadXML($XMLPath);
        if(isset($xml) && is_object($xml)) {
            $jobAd = new JobAd(0, $xml->annons->annonsid, $xml->annons->annonsrubrik, $xml->annons->annonstext, $xml->annons->yrkesbenamning,
                $xml->annons->yrkesid, $xml->annons->publiceraddatum, $xml->annons->antal_platser, $xml->annons->kommunnamn);
        }
		return $jobAd;
 	}
	
	// Requests and inserts job ads into the db.
	public function populateJobAdTable() {
		$counties = $this->countyRepository->getFromXML(BASE_PATH . AD_PATH . SEARCH_LIST_PATH . COUNTY_PATH);
		foreach($counties as $county) {
			$xml = $this->loadXML(BASE_PATH . AD_PATH . MATCH_PATH . COUNTY_ID_PATH . $county->getCountyId());
            if(isset($xml) && is_object($xml)) {
                $pages = $xml->antal_sidor;
                for ($x = 1; $x <= $pages; $x++) {
                    $xml = $this->loadXML(BASE_PATH . AD_PATH . MATCH_PATH . COUNTY_ID_PATH . $county->getCountyId() . PAGE_PATH . $x);
                    if(isset($xml) && is_object($xml)) {
                        foreach ($xml->matchningdata as $match) {
                            $jobAd = $this->getFromXML(BASE_PATH . AD_PATH . $match->annonsid);
                            $this->add($jobAd);
                        }
                    }
                    set_time_limit(60);
                }
            }
		}
	}

}
