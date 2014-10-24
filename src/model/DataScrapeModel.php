<?php
namespace model;

require_once("./src/model/JobAdRepository.php");
require_once("./src/model/CountyRepository.php");
require_once("./src/model/JobCategoryRepository.php");
require_once('./src/model/JobGroupRepository.php');
require_once("./src/model/AdRepository.php");
require_once("./src/model/AdAdapter.php");

class DataScrapeModel {
	private $jobAdRepository;
	private $countyRepository;
	private $jobCategoryRepository;
	private $jobGroupRepository;
	private $adRepository;
	private $adAdapter;
	
	public function __construct() {
		$this->adAdapter = new \model\AdAdapter();
		$this->adRepository = new \model\AdRepository();
		$this->jobAdRepository = new \model\JobAdRepository();
		$this->jobCategoryRepository = new \model\JobCategoryRepository();
		$this->jobGroupRepository = new \model\JobGroupRepository();
		$this->countyRepository = new \model\CountyRepository();
	}
	
	public function populateAdTable() {
		$counties = $this->countyRepository->getFromXML(BASE_PATH . AD_PATH . SEARCH_LIST_PATH . COUNTY_PATH);
		foreach($counties as $county) {
			$xml = $this->jobAdRepository->loadXML(BASE_PATH . AD_PATH . MATCH_PATH . COUNTY_ID_PATH . $county->getCountyId());
			$pages = $xml->antal_sidor;
			for($x = 1; $x <= $pages; $x++) {
				$xml = $this->jobAdRepository->loadXML(BASE_PATH . AD_PATH . MATCH_PATH . COUNTY_ID_PATH . $county->getCountyId() . PAGE_PATH . $x);
				foreach($xml->matchningdata as $match) {
					$jobAd = $this->jobAdRepository->getFromXML(BASE_PATH . AD_PATH . $match->annonsid);
					$ad = $this->adAdapter->adapt($jobAd);
					if(isset($ad)) {
						$this->adRepository->add($ad);
					}
				}
				set_time_limit(60);
			}
		}
	}
	
	public function populateJobTables() {
		$jobCategories = $this->jobCategoryRepository->getFromXML(BASE_PATH . AD_PATH . SEARCH_LIST_PATH . JOB_CATEGORY_PATH);
		foreach($jobCategories as $jobCategory) {
			$this->jobCategoryRepository->add($jobCategory);
			
			$this->jobGroupRepository->populateJobTables(BASE_PATH . AD_PATH . SEARCH_LIST_PATH . JOB_GROUP_PATH . $jobCategory->getJobCategoryId(), $jobCategory->getJobCategoryId());
		}
	}
}

?>