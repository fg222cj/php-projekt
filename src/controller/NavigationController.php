<?php
namespace controller;

require_once("./src/view/HTMLView.php");
require_once("./src/view/NavigationView.php");
require_once("./src/controller/DataPresentationController.php");
require_once("./src/controller/DataScrapeController.php");

class NavigationController {
	private $htmlView;
	private $navigationView;
	private $dataPresentationController;
	private $dataScrapeController;
	
	public function __construct() {
		$this->htmlView = new \view\HTMLView();
		$this->navigationView = new \view\NavigationView();
		$this->dataPresentationController = new \controller\DataPresentationController();
		$this->dataScrapeController = new \controller\DataScrapeController();
	}
	
	public function doControl() {
		switch($this->navigationView->getAction()) {
			case GET_ACTION_ADMIN:
				$HTMLBody = $this->dataScrapeController->doControl();
				$this->htmlView->showHTML($HTMLBody);
				break;
			
			case GET_ACTION_OPTIONS:
				$this->dataPresentationController->doControl();
				break;
			
			case GET_ACTION_SEARCH:
			default:
				$HTMLBody = $this->dataPresentationController->doControl();
				$this->htmlView->showHTML($HTMLBody);
				break;
		}
	}
}
?>