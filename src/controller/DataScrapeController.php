<?php
namespace controller;

require_once("./src/model/DataScrapeModel.php");
require_once("./src/view/DataScrapeView.php");

class DataScrapeController {
	private $dataScrapeModel;
	private $dataScrapeView;
	
	public function __construct() {
		$this->dataScrapeModel = new \model\DataScrapeModel();
		$this->dataScrapeView = new \view\DataScrapeView($this->dataScrapeModel);
	}
	
	public function doControl() {
		try {
			switch($this->dataScrapeView->getAction()) {
				case POST_ACTION_SCRAPE_ADS:
					$this->dataScrapeModel->beginTaskUpdateAdTable();
					break;
					
				case POST_ACTION_SCRAPE_JOB_TABLES:
					$this->dataScrapeModel->beginTaskUpdateJobTables();
					break;
					
				case POST_ACTION_SCRAPE_REGION_TABLES:
					$this->dataScrapeModel->beginTaskUpdateRegionTables();
					break;
			}
		}
		
		catch(\Exception $e) {
			$this->dataScrapeView->setMessage($e->getMessage());
		}
		
		return $this->dataScrapeView->adminForm();
	}

}

?>