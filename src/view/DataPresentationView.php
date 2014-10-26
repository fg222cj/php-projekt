<?php
namespace view;

require_once("./src/model/Result.php");

class DataPresentationView {
	private $message = "";
	private $dataPresentationModel;
	
	public function __construct($dataPresentationModel) {
		$this->dataPresentationModel = $dataPresentationModel;
	}
	
	public function getAction() {
		if(isset($_GET[GET_ACTION_KEYWORD]) && $_GET[GET_ACTION_KEYWORD] != "") {
			return GET_ACTION_KEYWORD;
		}
		
		if(isset($_GET[GET_ACTION_COUNTY]) && $_GET[GET_ACTION_COUNTY] != 0) {
			return GET_ACTION_COUNTY;
		}
		
		if(isset($_GET[GET_ACTION_MUNICIPALITY]) && $_GET[GET_ACTION_MUNICIPALITY] != 0) {
			return GET_ACTION_MUNICIPALITY;
		}
		
		if(isset($_GET[GET_ACTION_JOB_CATEGORY]) && $_GET[GET_ACTION_JOB_CATEGORY] != 0) {
			return $_GET[GET_ACTION_JOB_CATEGORY];
		}
		
		if(isset($_GET[GET_ACTION_JOB_GROUP]) && $_GET[GET_ACTION_JOB_GROUP] != 0) {
			return $_GET[GET_ACTION_JOB_GROUP];
		}
		
		if(isset($_GET[GET_ACTION_JOB_TITLE]) && $_GET[GET_ACTION_JOB_TITLE] != 0) {
			return $_GET[GET_ACTION_JOB_TITLE];
		}
		
		if(isset($_GET[GET_ACTION_OPTIONS])) {
			return GET_ACTION_OPTIONS;
		}
	}
	
	public function getKeyword() {
		if(isset($_GET[GET_ACTION_KEYWORD]) && $_GET[GET_ACTION_KEYWORD] != "") {
			return $_GET[GET_ACTION_KEYWORD];
		}
	}
	
	public function getCounty() {
		if(isset($_GET[GET_ACTION_COUNTY]) && $_GET[GET_ACTION_COUNTY] != 0) {
			return $_GET[GET_ACTION_COUNTY];
		}
	}
	
	public function getMunicipality() {
		if(isset($_GET[GET_ACTION_MUNICIPALITY]) && $_GET[GET_ACTION_MUNICIPALITY] != 0) {
			return $_GET[GET_ACTION_MUNICIPALITY];
		}
	}
	
	public function getJobCategory() {
		if(isset($_GET[GET_ACTION_JOB_CATEGORY]) && $_GET[GET_ACTION_JOB_CATEGORY] != 0) {
			return $_GET[GET_ACTION_JOB_CATEGORY];
		}
	}
	
	public function getJobGroup() {
		if(isset($_GET[GET_ACTION_JOB_GROUP]) && $_GET[GET_ACTION_JOB_GROUP] != 0) {
			return $_GET[GET_ACTION_JOB_GROUP];
		}
	}
	
	public function getJobTitle() {
		if(isset($_GET[GET_ACTION_JOB_TITLE]) && $_GET[GET_ACTION_JOB_TITLE] != 0) {
			return $_GET[GET_ACTION_JOB_TITLE];
		}
	}
	
	public function getOption() {
		if(isset($_GET[GET_ACTION_OPTIONS]) && $_GET[GET_ACTION_OPTIONS] != "") {
			return $_GET[GET_ACTION_OPTIONS];
		}
	}
	
	public function getOptionId() {
		if(isset($_GET[GET_ACTION_OPTIONS_ID]) && $_GET[GET_ACTION_OPTIONS_ID] != "") {
			return $_GET[GET_ACTION_OPTIONS_ID];
		}
	}
	
	public function getCountyOptions() {
		$countyOptions = "<option value='0'>Alla län</option>";
		$counties = $this->dataPresentationModel->getCounties();
		
		foreach($counties as $county) {
			if($this->getCounty() == $county->getCountyId()) {
				$countyOptions .= "<option value='" . $county->getCountyId() . "' selected>" . $county->getName() . "</option>";
			}
			else {
				$countyOptions .= "<option value='" . $county->getCountyId() . "'>" . $county->getName() . "</option>";
			}
		}
		
		return $countyOptions;
	}
	
	public function getMunicipalityOptions($countyId = 0) {
		$municipalityOptions = "<option value='0'>Alla kommuner</option>";
		$municipalities = $this->dataPresentationModel->getMunicipalities($countyId);
		
		foreach($municipalities as $municipality) {
			if($this->getMunicipality() == $municipality->getMunicipalityId()) {
				$municipalityOptions .= "<option value='" . $municipality->getMunicipalityId() . "' selected>" . $municipality->getName() . "</option>";
			}
			else {
				$municipalityOptions .= "<option value='" . $municipality->getMunicipalityId() . "'>" . $municipality->getName() . "</option>";
			}
		}
		
		return $municipalityOptions;
	}
	
	public function getJobCategoryOptions() {
		$jobCategoryOptions = "<option value='0'>Alla yrkeskategorier</option>";
		$jobCategories = $this->dataPresentationModel->getJobCategories();
		
		foreach($jobCategories as $jobCategory) {
			if($this->getJobCategory() == $jobCategory->getJobCategoryId()) {
				$jobCategoryOptions .= "<option value='" . $jobCategory->getJobCategoryId() . "' selected>" . $jobCategory->getName() . "</option>";
			}
			else {
				$jobCategoryOptions .= "<option value='" . $jobCategory->getJobCategoryId() . "'>" . $jobCategory->getName() . "</option>";
			}
		}
		
		return $jobCategoryOptions;
	}
	
	public function getJobGroupOptions($jobCategoryId = 0) {
		$jobGroupOptions = "<option value='0'>Alla yrkesgrupper</option>";
		$jobGroups = $this->dataPresentationModel->getJobGroups($jobCategoryId);
		
		foreach($jobGroups as $jobGroup) {
			if($this->getJobGroup() == $jobGroup->getJobGroupId()) {
				$jobGroupOptions .= "<option value='" . $jobGroup->getJobGroupId() . "' selected>" . $jobGroup->getName() . "</option>";
			}
			else {
				$jobGroupOptions .= "<option value='" . $jobGroup->getJobGroupId() . "'>" . $jobGroup->getName() . "</option>";
			}
		}
		
		return $jobGroupOptions;
	}
	
	public function getJobTitleOptions($jobGroupId = 0) {
		$jobTitleOptions = "<option value='0'>Alla yrken</option>";
		$jobTitles = $this->dataPresentationModel->getJobTitles($jobGroupId);
		
		foreach($jobTitles as $jobTitle) {
			if($this->getMunicipality() == $jobTitle->getJobTitleId()) {
				$jobTitleOptions .= "<option value='" . $jobTitle->getJobTitleId() . "' selected>" . $jobTitle->getName() . "</option>";
			}
			else {
				$jobTitleOptions .= "<option value='" . $jobTitle->getJobTitleId() . "'>" . $jobTitle->getName() . "</option>";
			}
		}
		
		return $jobTitleOptions;
	}
	
	public function searchForm() {
		$countyOptions = $this->getCountyOptions();
		$municipalityOptions = $this->getMunicipalityOptions($this->getCounty());
		$jobCategoryOptions = $this->getJobCategoryOptions();
		$jobGroupOptions = $this->getJobGroupOptions($this->getJobCategory());
		$jobTitleOptions = $this->getJobTitleOptions($this->getJobGroup());
		
		$html = "
		<script src='" . FILE_PATH_JS_AJAX . "'></script>
		<form action='' method='get'>
			<fieldset>
				<legend>Sökning</legend>
				$this->message
				Nyckelord: <input name='" . GET_ACTION_KEYWORD . "' type='text' value='" . $this->getKeyword() . "' />
				<br />
				Län: <select name='" . GET_ACTION_COUNTY . "' onchange='getMunicipalityOptions(this.value)'>
					$countyOptions
				</select>
				<br />
				Kommun: <select name='" . GET_ACTION_MUNICIPALITY . "' id='" . GET_ACTION_MUNICIPALITY . "'>
					$municipalityOptions
				</select>
				<br />
				<br />
				Yrkeskategori: <select name='" . GET_ACTION_JOB_CATEGORY . "' onchange='getJobGroupOptions(this.value)'>
					$jobCategoryOptions
				</select>
				<br />
				Yrkesgrupp: <select name='" . GET_ACTION_JOB_GROUP . "' id='" . GET_ACTION_JOB_GROUP . "'  onchange='getJobTitleOptions(this.value)'>
					$jobGroupOptions
				</select>
				<br />
				Yrke: <select name='" . GET_ACTION_JOB_TITLE . "' id='" . GET_ACTION_JOB_TITLE . "'>
					$jobTitleOptions
				</select>
				<br />
				<input type='submit' value='Sök'>
			</fieldset>
		</form>
		";
		
		return $html;
	}
	
	public function showResult($result) {
		$html = $this->searchForm();
		
		$html .= "
		<h3>\"" . $result->getKeyword() . "\"</h3>
		";
		
		foreach($result->getGraphs() as $graph) {
			$html .= "
			<img src='$graph' />
			<br />
			";
		}
		
		if($result->getRelatedJobTitles() !== null) {
			$html .= "
			<table>
			";
			foreach($result->getRelatedJobTitles() as $jobTitle) {
				$html .= "
					<tr>
						<td>" . $jobTitle[0]->getName() . "</td>
						<td>" . $jobTitle[1] . "</td>
					</tr>
					";
			}
			$html .= "
			</table>
			";
		}
		
		return $html;
	}

	public function showOptions() {
		$options = "";
		switch($this->getOption()) {
			case GET_ACTION_MUNICIPALITY:
				$options = $this->getMunicipalityOptions($this->getOptionId());
				break;
			case GET_ACTION_JOB_GROUP:
				$options = $this->getJobGroupOptions($this->getOptionId());
				break;
			case GET_ACTION_JOB_TITLE:
				$options = $this->getJobTitleOptions($this->getOptionId());
				break;
		}
		echo $options;
	}
	
	public function setMessage($message) {
		switch($message) {
			case ERROR_EMPTY_DATA_SET:
				$this->message .= "<p>Nyckelordet förekom inte, försök med ett annat ord</p>";
				break;
			default:
				$this->message .= "<p>Ett oväntat fel har inträffat, kontakta administratören eller försök igen senare</p>";
				break;
		}
	}
}



?>