<?php
namespace model;

require_once("./src/model/JobAdRepository.php");

class DataModel {
	private $jobAdRepository;
	
	public function __construct() {
		$this->jobAdRepository = new \model\JobAdRepository();
	}
	
	public function getCount($keyword) {
		$hitCount = $this->jobAdRepository->getCount($keyword);
		return $hitCount;
	}
}



?>