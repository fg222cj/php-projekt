<?php
namespace model;

class JobAd {
	private $id;
	private $adId;
	private $adHeading;
	private $adText;
	private $jobTitle;
	private $jobId;
	private $publicationDate;
	private $positionsAvailable;
	private $municipalityName;
	
	public function __construct($id = 0, $adId, $adHeading, $adText, $jobTitle, $jobId, $publicationDate, $positionsAvailable, $municipalityName) {
		$this->id = $id;
		$this->adId = $adId;
		$this->adHeading = $adHeading;
		$this->adText = $adText;
		$this->jobTitle = $jobTitle;
		$this->jobId = $jobId;
		$this->publicationDate = $publicationDate;
		$this->positionsAvailable = $positionsAvailable;
		$this->municipalityName = $municipalityName;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getAdId() {
		return $this->adId;
	}
	
	public function getAdHeading() {
		return $this->adHeading;
	}
	
	public function getAdText() {
		return $this->adText;
	}
	
	public function getJobTitle() {
		return $this->jobTitle;
	}
	
	public function getJobId() {
		return $this->jobId;
	}
	
	public function getPublicationDate() {
		return $this->publicationDate;
	}
	
	public function getPositionsAvailable() {
		return $this->positionsAvailable;
	}
	
	public function getMunicipalityName() {
		return $this->municipalityName;
	}
}


?>