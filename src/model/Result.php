<?php
namespace model;

class Result {
	private $keyword;
	private $graphs;
	private $relatedKeywords;
	private $relatedJobTitles;
	private $relatedJobGroups;
	private $relatedJobCategories;
	private $relatedCounties;
	private $relatedMunicipalities;
	
	public function __construct($keyword = null, $graphs = null, $relatedKeywords = null, $relatedJobTitles = null, 
	$relatedJobGroups = null, $relatedJobCategories = null, $relatedCounties = null, $relatedMunicipalities = null) {
		
		$this->keyword = $keyword;
		$this->graphs = $graphs;
		$this->relatedKeywords = $relatedKeywords;
		$this->relatedJobTitles = $relatedJobTitles;
		$this->relatedJobGroups = $relatedJobGroups;
		$this->relatedJobCategories = $relatedJobCategories;
		$this->relatedCounties = $relatedCounties;
		$this->relatedMunicipalities = $relatedMunicipalities;
	}
	
	public function getKeyword() {
		return $this->keyword;
	}
	
	public function getGraphs() {
		return $this->graphs;
	}
	
	public function getRelatedKeywords() {
		return $this->relatedKeywords;
	}
	
	public function getRelatedJobTitles() {
		return $this->relatedJobTitles;
	}
	
	public function getRelatedJobGroups() {
		return $this->relatedJobGroups;
	}
	
	public function getRelatedJobCategories() {
		return $this->relatedJobCategories;
	}
	
	public function getRelatedCounties() {
		return $this->relatedCounties;
	}
	
	public function getRelatedMunicipalities() {
		return $this->relatedMunicipalities;
	}
}


?>