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

	public function add(JobAd $jobAd) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . JOB_AD_TABLE . " (" . JOB_AD_ID_COLUMN . ", " . JOB_AD_HEADING_COLUMN . ", " . JOB_AD_TEXT_COLUMN . ", " . JOB_AD_TITLE_COLUMN . ",
		 " . JOB_AD_JOB_TITLE_ID_COLUMN . ", " . JOB_AD_PUBLICATION_DATE_COLUMN . ", " . JOB_AD_POSITIONS_AVAILABLE_COLUMN . ", " . JOB_AD_MUNICIPALITY_NAME_COLUMN . ") VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$params = array($jobAd->getAdId(), $jobAd->getAdHeading(), $jobAd->getAdText(), $jobAd->getJobTitle(), $jobAd->getJobId(),
		 $jobAd->getPublicationDate(), $jobAd->getPositionsAvailable(), $jobAd->getMunicipalityName());

		$query = $db->prepare($sql);
		$query->execute($params);
	}

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
	
	public function getCount($keyword) {
		$db = $this->connection();

		$sql = "SELECT COUNT(*) FROM " . JOB_AD_TABLE . " WHERE " . JOB_AD_TEXT_COLUMN . " LIKE ?";
		$params = array("%$keyword%");

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetchColumn();

		return $result;

	}
	 
	public function delete(\model\JobAd $jobAd) {
		$db = $this -> connection();

		$sql = "DELETE FROM " . JOB_AD_TABLE . " WHERE " . JOB_AD_ID_COLUMN . " = ?";
		$params = array($jobAd->getJobAdId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}

 	public function getFromXML($XMLPath) {
 		$xml = $this->loadXML($XMLPath);
		$jobAd = new JobAd(0, $xml->annons->annonsid, $xml->annons->annonsrubrik, $xml->annons->annonstext, $xml->annons->yrkesbenamning,
		$xml->annons->yrkesid, $xml->annons->publiceraddatum, $xml->annons->antal_platser, $xml->annons->kommunnamn);
		return $jobAd;
 	}
	
	public function populateJobAdTable() {
		$counties = $this->countyRepository->getFromXML(BASE_PATH . AD_PATH . SEARCH_LIST_PATH . COUNTY_PATH);
		foreach($counties as $county) {
			$xml = $this->loadXML(BASE_PATH . AD_PATH . MATCH_PATH . COUNTY_ID_PATH . $county->getCountyId());
			$pages = $xml->antal_sidor;
			for($x = 1; $x <= $pages; $x++) {
				$xml = $this->loadXML(BASE_PATH . AD_PATH . MATCH_PATH . COUNTY_ID_PATH . $county->getCountyId() . PAGE_PATH . $x);
				foreach($xml->matchningdata as $match) {
					$jobAd = $this->getFromXML(BASE_PATH . AD_PATH . $match->annonsid);
					$this->add($jobAd);
				}
				set_time_limit(60);
			}
		}
	}

}
