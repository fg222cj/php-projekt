<?php
namespace controller;

require_once("./src/model/DataScrapeModel.php");
require_once("./src/view/DataScrapeView.php");

class DataScrapeController {
	private $dataScrapeModel;
	private $dataScrapeView;
	
	public function __construct() {
		$this->dataScrapeModel = new \model\DataScrapeModel();
		$this->dataScrapeView = new \view\DataScrapeView();
	}
	
	public function doControl() {
		switch($this->dataScrapeView->getAction()) {
			case POST_ACTION_SCRAPE_ADS:
				return $this->scrapeJobAds();
				break;
				
			case POST_ACTION_SCRAPE_JOB_TABLES:
				return $this->scrapeJobTables();
				break;
				
			default:
				return $this->dataScrapeView->adminForm();
				break;
		}
	}
	
	public function scrapeJobAds() {
		$this->dataScrapeModel->populateAdTable();
		return "klar!";
	}
	
	public function scrapeJobTables() {
		$this->dataScrapeModel->populateJobTables();
		return "uppdaterat jobb-tjofräs!";
	}
}

?>