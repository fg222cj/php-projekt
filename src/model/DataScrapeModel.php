<?php
namespace model;

require_once("./src/model/ScrapeLogRepository.php");
require_once("./src/model/JobAdRepository.php");
require_once("./src/model/CountyRepository.php");
require_once("./src/model/MunicipalityRepository.php");
require_once("./src/model/JobCategoryRepository.php");
require_once('./src/model/JobGroupRepository.php');
require_once("./src/model/AdRepository.php");
require_once("./src/model/AdAdapter.php");

class DataScrapeModel {
	private $scrapeLogRepository;
	private $jobAdRepository;
	private $countyRepository;
	private $municipalityRepository;
	private $jobCategoryRepository;
	private $jobGroupRepository;
	private $adRepository;
	private $adAdapter;
	
	public function __construct() {
		$this->scrapeLogRepository = new \model\ScrapeLogRepository();
		$this->adAdapter = new \model\AdAdapter();
		$this->adRepository = new \model\AdRepository();
		$this->jobAdRepository = new \model\JobAdRepository();
		$this->jobCategoryRepository = new \model\JobCategoryRepository();
		$this->jobGroupRepository = new \model\JobGroupRepository();
		$this->countyRepository = new \model\CountyRepository();
		$this->municipalityRepository = new \model\MunicipalityRepository();
	}
	
	// Fetch a ScrapeLog object based on which db table it logged changes on.
	public function getScrapeLog($tableName) {
		$scrapeLog = $this->scrapeLogRepository->getLastFromDbByTableName($tableName);
		return $scrapeLog;
	}
	
	// Fetch job ads from source, adapt them and store them. The task is logged.
	public function populateAdTable() {
		$scrapeLog = $this->addLog(JOB_AD_TABLE);
		
		$counties = $this->countyRepository->getFromXML(BASE_PATH . AD_PATH . SEARCH_LIST_PATH . COUNTY_PATH);
		foreach($counties as $county) {
			$xml = $this->jobAdRepository->loadXML(BASE_PATH . AD_PATH . MATCH_PATH . COUNTY_ID_PATH . $county->getCountyId());
            if(isset($xml) && is_object($xml)) {
                $pages = $xml->antal_sidor;
                for ($x = 1; $x <= $pages; $x++) {
                    $xml = $this->jobAdRepository->loadXML(BASE_PATH . AD_PATH . MATCH_PATH . COUNTY_ID_PATH . $county->getCountyId() . PAGE_PATH . $x);
                    if(isset($xml) && is_object($xml)) {
                        foreach ($xml->matchningdata as $match) {
                            $jobAd = $this->jobAdRepository->getFromXML(BASE_PATH . AD_PATH . $match->annonsid);
                            if(isset($jobAd) && is_object($jobAd)) {
                                $ad = $this->adAdapter->adapt($jobAd);
                                if (isset($ad)) {
                                    $this->adRepository->add($ad);
                                }
                            }
                        }
                        set_time_limit(60);
                    }
                }
            }
		}
		
		$this->updateLog($scrapeLog);
	}
	
	// Fetch job tables data from source and store it. The task is logged.
	public function populateJobTables() {
		$scrapeLog = $this->addLog(JOB_CATEGORY_TABLE);
		
		$jobCategories = $this->jobCategoryRepository->getFromXML(BASE_PATH . AD_PATH . SEARCH_LIST_PATH . JOB_CATEGORY_PATH);
		foreach($jobCategories as $jobCategory) {
			$this->jobCategoryRepository->add($jobCategory);
			
			$this->jobGroupRepository->populateJobTables(BASE_PATH . AD_PATH . SEARCH_LIST_PATH . JOB_GROUP_PATH . $jobCategory->getJobCategoryId(), $jobCategory->getJobCategoryId());
		}
		
		$this->updateLog($scrapeLog);
	}
	
	// Fetch region tables data from source and store it. The task is logged.
	public function populateRegionTables() {
		$scrapeLog = $this->addLog(COUNTY_TABLE);
		
		$counties = $this->countyRepository->getFromXML(BASE_PATH . AD_PATH . SEARCH_LIST_PATH . COUNTY_PATH);
		foreach($counties as $county) {
			$this->countyRepository->add($county);
			
			$municipalities = $this->municipalityRepository->getFromXML(BASE_PATH . AD_PATH . SEARCH_LIST_PATH . MUNICIPALITY_PATH . $county->getCountyId(), $county->getCountyId());
			
			foreach($municipalities as $municipality) {
				$this->municipalityRepository->add($municipality);
			}
		}
		
		$this->updateLog($scrapeLog);
	}
	
	// Start logging data about a task based on the table that is being updated. Returns a ScrapeLog object.
	public function addLog($tableName) {
		$scrapeLog = new \model\ScrapeLog(0, $tableName, 0, date('Y-m-d H:i:s'), null);
		
		// add() returns inserted id, which is added to the ScrapeLog object before returning it.
		$scrapeLogId = $this->scrapeLogRepository->add($scrapeLog);
		$scrapeLog->setId($scrapeLogId);
		
		return $scrapeLog;
	}
	
	// Updates a log entry. 
	public function updateLog($scrapeLog) {
		$scrapeLog->setFinishedAt(date('Y-m-d H:i:s'));
		$this->scrapeLogRepository->update($scrapeLog);
	}
	
	// Starts the job ad update job.
	public function beginTaskUpdateAdTable() {
		$logAdTable = $this->getScrapeLog(JOB_AD_TABLE);
		if($this->updateDisabled($logAdTable) === true) {
			throw new \Exception(ERROR_UPDATE_IN_PROGRESS);
		}
		exec(PHP_EXECUTE_FILE_PATH . " " . BASE_ABSOLUTE_PATH . FILE_PATH_TASK_UPDATE_ADS . " > /dev/null &");
		usleep(50000); // Minor MVC violation. Script is paused shortly to allow for tasks to begin so that when the page is reloaded we will be able to detect that the task is running.
	}
	
	// Starts the job tables update job.
	public function beginTaskUpdateJobTables() {
		$logJobTables = $this->getScrapeLog(JOB_CATEGORY_TABLE);
		if($this->updateDisabled($logJobTables) === true) {
			throw new \Exception(ERROR_UPDATE_IN_PROGRESS);
		}
		exec(PHP_EXECUTE_FILE_PATH . " " . BASE_ABSOLUTE_PATH . FILE_PATH_TASK_UPDATE_JOBS . " > /dev/null &");
		usleep(50000); // Minor MVC violation. Script is paused shortly to allow for tasks to begin so that when the page is reloaded we will be able to detect that the task is running.
	}
	
	// Starts the region tables update job.
	public function beginTaskUpdateRegionTables() {
		$logRegionTables = $this->getScrapeLog(COUNTY_TABLE);
		if($this->updateDisabled($logRegionTables) === true) {
			throw new \Exception(ERROR_UPDATE_IN_PROGRESS);
		}
		exec(PHP_EXECUTE_FILE_PATH . " " . BASE_ABSOLUTE_PATH . FILE_PATH_TASK_UPDATE_REGIONS . " > /dev/null &");
		usleep(50000); // Minor MVC violation. Script is paused shortly to allow for tasks to begin so that when the page is reloaded we will be able to detect that the task is running.
	}
	
	// Takes a ScrapeLog object and checks it to see if a specific task is currently in progress.
	public function updateDisabled(\model\ScrapeLog $scrapeLog = null) {
		if(isset($scrapeLog)) {
			if($scrapeLog->getFinishedAt() === null) {
				return true;
			}
		}
		
		return false;
	}
}

?>