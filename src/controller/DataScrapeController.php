<?php
require_once("./src/model/JobAdRepository.php");
require_once("./src/model/JobAdAdapter.php");

class DataScrapeController {
	private $jobAdRepository;
	private $jobAdAdapter;
	
	public function __construct() {
		$this->jobAdRepository = new \model\JobAdRepository();
	}
	
	public function scrapeJobAds() {
		
	}
}

?>