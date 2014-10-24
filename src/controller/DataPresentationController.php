<?php
namespace controller;

require_once("./src/model/DataPresentationModel.php");
require_once("./src/view/DataPresentationView.php");

class DataPresentationController {
	private $dataPresentationModel;		
	private $dataPresentationView;
	
	public function __construct() {
		$this->dataPresentationModel = new \model\DataPresentationModel();
		$this->dataPresentationView = new \view\DataPresentationView();
	}
	
	public function doControl() {
		switch($this->dataPresentationView->getAction()) {
			case GET_ACTION_KEYWORD:
				return $this->keywordSearch($this->dataPresentationView->getKeyword());
				break;
				
			default:
				return $this->dataPresentationView->searchForm();
				break;
		}
	}
	
	public function keywordSearch($keyword) {
		$hitCount = $this->dataPresentationModel->getCount($keyword);
		return $this->dataPresentationView->showResult($hitCount, $keyword);
	}
}
?>