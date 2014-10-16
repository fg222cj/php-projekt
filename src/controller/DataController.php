<?php
namespace controller;

require_once("./src/model/DataModel.php");
require_once("./src/view/DataView.php");

class DataController {
	private $dataModel;		
	private $dataView;
	
	public function __construct() {
		$this->dataModel = new \model\DataModel();
		$this->dataView = new \view\DataView();
	}
	
	public function doControl() {
		switch($this->dataView->getAction()) {
			case GET_ACTION_KEYWORD:
				return $this->keywordSearch($this->dataView->getKeyword());
				break;
				
			default:
				return $this->dataView->searchForm();
				break;
		}
	}
	
	public function keywordSearch($keyword) {
		$hitCount = $this->dataModel->getCount($keyword);
		return $this->dataView->showResult($hitCount, $keyword);
	}
}
?>