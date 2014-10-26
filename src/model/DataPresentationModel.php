<?php
namespace model;

require_once("./src/model/AdRepository.php");
require_once("./src/model/JobCategoryRepository.php");
require_once("./src/model/JobGroupRepository.php");
require_once("./src/model/JobTitleRepository.php");
require_once("./src/model/CountyRepository.php");
require_once("./src/model/MunicipalityRepository.php");
require_once('./src/vendors/phpgraphlib/phpgraphlib.php');
require_once("./src/model/Result.php");

class DataPresentationModel {
	private $adRepository;
	private $jobCategoryRepository;
	private $jobGroupRepository;
	private $jobTitleRepository;
	private $countyRepository;
	private $municipalityRepository;
	
	public function __construct() {
		$this->adRepository = new \model\AdRepository();
		$this->jobCategoryRepository = new \model\JobCategoryRepository();
		$this->jobGroupRepository = new \model\JobGroupRepository();
		$this->jobTitleRepository = new \model\JobTitleRepository();
		$this->countyRepository = new \model\CountyRepository();
		$this->municipalityRepository = new \model\MunicipalityRepository();
	}
	
	public function getResult($keyword = null, $jobTitle = null, $jobGroup = null, $jobCategory = null, $municipality = null, $county = null) {
		$graphs = array();
		
		if(isset($keyword)) {
			$keywordData = array();
			$hitCount = $this->keywordSearch($keyword, $jobTitle, $jobGroup, $jobCategory, $municipality, $county);
			
			// Use gathered data to create an array that's actually useful.
			foreach($hitCount as $week) {
				$key = $week[0] . "-" . $week[1];
				$keywordData[$key] = $week[2];
			}
			
			$filepath = $this->createGraph($keyword, $keywordData);
			$graphs[] = $filepath;
			
			$jobTitleData = array();
			
			$relatedJobTitlesData = array();
			$relatedJobTitlesData = $this->adRepository->getRelatedJobTitlesData($keyword, $jobTitle, $jobGroup, $jobCategory, $municipality, $county);
			if(!empty($relatedJobTitlesData)) {
				$relatedJobTitles = array();
				foreach($relatedJobTitlesData as $data) {
					$relatedJobTitle = $this->jobTitleRepository->getFromDbByJobId($data[0]);
					$relatedJobTitles[] = array($relatedJobTitle, $data[1]);
				}
			}
			
		}
		
		$result = new \model\Result($keyword, $graphs, null, $relatedJobTitles);
		
		return $result;
	}

	public function getCounties() {
		return $this->countyRepository->getAllFromDb();
	}
	
	public function getMunicipalities($countyId) {
		return $this->municipalityRepository->getFromDbByCounty($countyId);
	}
	
	public function getJobCategories() {
		return $this->jobCategoryRepository->getAllFromDb();
	}
	
	public function getJobGroups($jobCategoryId) {
		return $this->jobGroupRepository->getFromDbByJobCategory($jobCategoryId);
	}
	
	public function getJobTitles($jobGroupId) {
		return $this->jobTitleRepository->getFromDbByJobGroup($jobGroupId);
	}
	
	public function keywordSearch($keyword = null, $jobTitle = null, $jobGroup = null, $jobCategory = null, $municipality = null, $county = null) {
		$hitCount = $this->adRepository->getCount($keyword, $jobTitle, $jobGroup, $jobCategory, $municipality, $county);
		return $hitCount;
	}
	
	public function createGraph($keyword, $data) {
		if(empty($data)) {
			throw new \Exception(ERROR_EMPTY_DATA_SET);
		}
		
		// Create data-specific unique filename by hashing the data used.
		// Reason for json-encoding: http://stackoverflow.com/questions/2254220/php-best-way-to-md5-multi-dimensional-array
		$filename = md5($keyword . json_encode($data)) . ".png";
		$filepath = FILE_PATH_GRAPHS_FOLDER . $filename;
		
		// There's no reason to create a new graph if we already have one from the exact same dataset.
		if(file_exists($filepath)) {
			return $filepath;
		}
		
		$title = "\"$keyword\"";
		
		$graph = new \PHPGraphLib(1200,400, $filepath);
		$graph->addData($data);
		$graph->setTitle($title);
		$graph->setXValuesHorizontal(true);
		$graph->setBars(true);
		$graph->setLine(true);
		$graph->setDataPoints(true);
		$graph->setDataPointColor('maroon');
		$graph->setDataValues(true);
		$graph->setDataValueColor('maroon');
		$graph->setGoalLine(.0025);
		$graph->setGoalLineColor('red');
		$graph->createGraph();
		
		return $filepath;
	}
}



?>