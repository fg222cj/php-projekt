<?php
namespace model;

class JobCategory {
	private $id;
	private $jobCategoryId;
	private $name;
	
	public function __construct($id = 0, $jobCategoryId, $name) {
		$this->id = $id;
		$this->jobCategoryId = $jobCategoryId;
		$this->name = $name;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getJobCategoryId() {
		return $this->jobCategoryId;
	}
	
	public function getName() {
		return $this->name;
	}
}

?>