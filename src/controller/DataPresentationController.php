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
		$this->completeViewInfo();	// If there's partial information in the view, we attempt to complete it.
	}
	
	public function doControl() {
		try {
			switch($this->dataPresentationView->getAction()) {
				case GET_ACTION_SEARCH:
					return $this->search($this->dataPresentationView->getKeyword(), $this->dataPresentationView->getJobTitle(), 
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
	
	// Performs a search based on input data. Any and all of these parameters may be null.
	public function search($keyword, $jobTitle, $jobGroup, $jobCategory, $municipality, $county) {
		$result = $this->dataPresentationModel->getResult($keyword, $jobTitle, $jobGroup, $jobCategory, $municipality, $county);
		return $this->dataPresentationView->showResult($result);
	}
	
	// Checks to see if we have orphaned data and attempts to locate the parents.
	public function completeViewInfo() {
		if($this->dataPresentationView->getMunicipality() !== null && $this->dataPresentationView->getCounty() === null) {
			$countyId = $this->dataPresentationModel->getCountyId($this->dataPresentationView->getMunicipality());
			$this->dataPresentationView->setCounty($countyId);
		}
		
		if($this->dataPresentationView->getJobTitle() !== null && $this->dataPresentationView->getJobGroup() === null) {
			$jobGroupId = $this->dataPresentationModel->getJobGroupId($this->dataPresentationView->getJobTitle());
			$this->dataPresentationView->setJobGroup($jobGroupId);
		}
		
		if($this->dataPresentationView->getJobGroup() !== null && $this->dataPresentationView->getJobCategory() === null) {
			$jobCategoryId = $this->dataPresentationModel->getJobCategoryId($this->dataPresentationView->getJobGroup());
			$this->dataPresentationView->setJobCategory($jobCategoryId);
		}
	}
}
?>