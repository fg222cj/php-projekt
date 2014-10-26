<?php
namespace model;

class ScrapeLog {
	private $id;
	private $tableName;
	private $newRecords;
	private $startedAt;
	private $finishedAt;
	
	public function __construct($id = 0, $tableName, $newRecords, $startedAt, $finishedAt) {
		$this->id = $id;
		$this->tableName = $tableName;
		$this->newRecords = $newRecords;
		$this->startedAt = $startedAt;
		$this->finishedAt = $finishedAt;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getTableName() {
		return $this->tableName;
	}
	
	public function getNewRecords() {
		return $this->newRecords;
	}
	
	public function getStartedAt() {
		return $this->startedAt;
	}
	
	public function getFinishedAt() {
		return $this->finishedAt;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function setNewRecords($newRecords)	{
		$this->newRecords = $newRecords;
	}
	
	public function setFinishedAt($time) {
		$this->finishedAt = $time;
	}
}

?>