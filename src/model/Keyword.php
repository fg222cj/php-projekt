<?php
namespace model;

class Keyword {
	private $id;
	private $keyword;
	private $relevant;
	private $jobCategoryId;
	
	public function __construct($id = 0, $keyword, $relevant = null, $jobCategoryId = null) {
		$this->id = $id;
		$this->keyword = $keyword;
		$this->relevant = $relevant;
		$this->jobCategoryId = $jobCategoryId;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getKeyword() {
		return $this->keyword;
	}
	
	public function getRelevant() {
		return $this->relevant;
	}
	
	public function getJobCategoryId() {
		return $this->jobCategoryId;
	}
}


?>