<?php
namespace model;

class JobTitle {
	private $id;
	private $jobTitleId;
	private $name;
	private $jobGroupId;
	
	public function __construct($id = 0, $jobTitleId, $name, $jobGroupId) {
		$this->id = $id;
		$this->jobTitleId = $jobTitleId;
		$this->name = $name;
		$this->jobGroupId = $jobGroupId;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getJobTitleId() {
		return $this->jobTitleId;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getJobGroupId() {
		return $this->jobGroupId;
	}
}

?>