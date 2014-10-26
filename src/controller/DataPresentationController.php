<?php
namespace controller;

require_once("./src/model/DataPresentationModel.php");
require_once("./src/view/DataPresentationView.php");
require_once("./src/model/Result.php");

class DataPresentationController {
	private $dataPresentationModel;		
	private $dataPresentationView;
	
	public function __construct() {
		$this->dataPresentationModel = new \model\DataPresentationModel();
		$this->dataPresentationView = new \view\DataPresentationView($this->dataPresentationModel);
	}
	
	public function doControl() {
		try {
			switch($this->dataPresentationView->getAction()) {
				case GET_ACTION_KEYWORD:
					return $this->keywordSearch($this->dataPresentationView->getKeyword(), $this->dataPresentationView->getJobTitle(), 
					$this->dataPresentationView->getJobGroup(), $this->dataPresentationView->getJobCategory(), $this->dataPresentationView->getMunicipality(), 
					$this->dataPresentationView->getCounty());
					break;
					
				case GET_ACTION_OPTIONS:
					$this->dataPresentationView->showOptions();
					break;
					
				default:
					return $this->dataPresentationView->searchForm();
					break;
			}
		}
		
		catch(\Exception $e) {
			$this->dataPresentationView->setMessage($e->getMessage());
			return $this->dataPresentationView->searchForm();
		}
	}
	
	public function keywordSearch($keyword, $jobTitle, $jobGroup, $jobCategory, $municipality, $county) {
		$result = $this->dataPresentationModel->getResult($keyword, $jobTitle, $jobGroup, $jobCategory, $municipality, $county);
		return $this->dataPresentationView->showResult($result);
	}
}
?>