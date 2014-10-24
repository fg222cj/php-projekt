<?php
namespace model;

require_once("./src/model/AdRepository.php");

class DataPresentationModel {
	private $adRepository;
	
	public function __construct() {
		$this->adRepository = new \model\AdRepository();
	}
	
	public function getCount($keyword, $jobTitle = null, $jobGroup = null, $jobCategory = null, $municipality = null, $county = null) {
		$hitCount = $this->adRepository->getCount($keyword, $jobTitle, $jobGroup, $jobCategory, $municipality, $county);
		return $hitCount;
	}
}



?>