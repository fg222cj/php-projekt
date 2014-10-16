<?php
namespace model;

class County {
	private $id;
	private $countyId;
	private $name;
	
	public function __construct($id = 0, $countyId, $name) {
		$this->id = $id;
		$this->countyId = $countyId;
		$this->name = $name;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getCountyId() {
		return $this->countyId;
	}
	
	public function getName() {
		return $this->name;
	}
}

?>