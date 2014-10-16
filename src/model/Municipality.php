<?php
namespace model;

class Municipality {
	private $id;
	private $municipalityId;
	private $name;
	private $countyId;
	
	public function __construct($id = 0, $municipalityId, $name, $countyId) {
		$this->id = $id;
		$this->municipalityId = $municipalityId;
		$this->name = $name;
		$this->countyId = $countyId;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getMunicipalityId() {
		return $this->municipalityId;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getCountyId() {
		return $this->countyId;
	}
}

?>