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
		$this->dataPresentationView = new \view\DataPresentationView();
	}
	
	public function doControl() {
		try {
			switch($this->dataPresentationView->getAction()) {
				case GET_ACTION_KEYWORD:
					return $this->keywordSearch($this->dataPresentationView->getKeyword());
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
	
	public function keywordSearch($keyword) {
		$result = $this->dataPresentationModel->getResult($keyword);
		return $this->dataPresentationView->showResult($result);
	}
}
?>