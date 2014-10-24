<?php
namespace model;

require_once("./src/model/MunicipalityRepository.php");
require_once("./src/model/JobGroupRepository.php");
require_once("./src/model/JobTitleRepository.php");
require_once("./src/model/JobAd.php");
require_once("./src/model/Ad.php");

class AdAdapter {
	private $municipalityRepository;
	private $jobGroupRepository;
	private $jobTitleRepository;
	
	public function __construct() {
		$this->municipalityRepository = new \model\MunicipalityRepository();
		$this->jobGroupRepository = new \model\JobGroupRepository();
		$this->jobTitleRepository = new \model\JobTitleRepository();
	}
	
	public function adapt(\model\JobAd $jobAd) {
		$municipality = $this->municipalityRepository->getFromDbByName($jobAd->getMunicipalityName());
		if(!isset($municipality)) {
			return null;
		}
		
		$jobTitle = $this->jobTitleRepository->getFromDbByJobId($jobAd->getJobId());
		if(!isset($jobTitle)) {
			return null;
		}
		
		$jobGroup = $this->jobGroupRepository->getFromDbByJobGroupId($jobTitle->getJobGroupId());
		if(!isset($jobGroup)) {
			return null;
		}
		
		$ad = new \model\Ad(0, $jobAd->getAdId(), $jobAd->getAdHeading(), $jobAd->getAdText(), $jobAd->getJobTitle(), $jobAd->getJobId(), $jobAd->getPublicationDate(), 
		$jobAd->getPositionsAvailable(), $jobAd->getMunicipalityName(), $municipality->getMunicipalityId(), $municipality->getCountyId(), $jobTitle->getJobGroupId(), $jobGroup->getJobCategoryId());
		
		return $ad;
	}
}

?>