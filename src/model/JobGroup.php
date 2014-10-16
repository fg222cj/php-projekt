<?php
namespace model;

class JobGroup {
	private $id;
	private $jobGroupId;
	private $name;
	private $jobCategoryId;
	
	public function __construct($id = 0, $jobGroupId, $name, $jobCategoryId) {
		$this->id = $id;
		$this->jobGroupId = $jobGroupId;
		$this->name = $name;
		$this->jobCategoryId = $jobCategoryId;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getJobGroupId() {
		return $this->jobGroupId;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getJobCategoryId() {
		return $this->jobCategoryId;
	}
}

?>