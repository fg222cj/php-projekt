<?php
namespace view;

class DataScrapeView {
	private $dataScrapeModel;
	private $message = "";
	
	public function __construct($dataScrapeModel) {
		$this->dataScrapeModel = $dataScrapeModel;
	}
	
	public function getAction() {
		if(isset($_POST[POST_ACTION_SCRAPE_ADS])) {
			return POST_ACTION_SCRAPE_ADS;
		}
		
		if(isset($_POST[POST_ACTION_SCRAPE_JOB_TABLES])) {
			return POST_ACTION_SCRAPE_JOB_TABLES;
		}
		
		if(isset($_POST[POST_ACTION_SCRAPE_REGION_TABLES])) {
			return POST_ACTION_SCRAPE_REGION_TABLES;
		}
	}
	
	public function adminForm() {
		// Fetch logs so we can show info about current and past tasks.
		$logAdTable = $this->dataScrapeModel->getScrapeLog(JOB_AD_TABLE);
		$logJobTables = $this->dataScrapeModel->getScrapeLog(JOB_CATEGORY_TABLE);
		$logRegionTables = $this->dataScrapeModel->getScrapeLog(COUNTY_TABLE);
		
		// Turn the logs into useful data and make it helpful.
		$logAdText = $this->calculateLastUpdate($logAdTable);
		$logJobText = $this->calculateLastUpdate($logJobTables);
		$logRegionText = $this->calculateLastUpdate($logRegionTables);
		
		// If there's an ongoing update we need to show that and disable the appropriate controls.
		$adUpdateDisabled = $this->disableUpdate($logAdTable);
		$jobUpdateDisabled = $this->disableUpdate($logJobTables);
		$regionUpdateDisabled = $this->disableUpdate($logRegionTables);
		
		$html = "
		<form action='' method='post'>
			<fieldset>
				<legend>Administration</legend>
				$this->message
				<input type='submit' name='" . POST_ACTION_SCRAPE_JOB_TABLES . "' value='Uppdatera jobbinfo' $jobUpdateDisabled>
				$logJobText
				<br />
				<input type='submit' name='" . POST_ACTION_SCRAPE_REGION_TABLES . "' value='Uppdatera regioninfo' $regionUpdateDisabled>
				$logRegionText
				<br />
				<input type='submit' name='" . POST_ACTION_SCRAPE_ADS . "' value='Samla jobbannonser' $adUpdateDisabled>
				$logAdText
			</fieldset>
		</form>
		";
		
		return $html;
	}

	public function defineKeywordsForm($keyword, $jobCategory) {
		$html = "
		<h2>$keyword</h2>
		<p>Är \"$keyword\" ett relevant nyckelord?</p>
		<form action='' method='post'>
			<fieldset>
				<legend>Nyckelordsdefiniering</legend>
				$this->message
				<input type='hidden' name='" . POST_ACTION_DEFINE_KEYWORD . "'>
				<input type='hidden' name='" . POST_ACTION_DEFINE_KEYWORD_JOB_CATEGORY . "' value='" . $jobCategory->getJobCategoryId() . "'>
				<input type='submit' name='" . POST_ACTION_DEFINE_KEYWORD_NO . "' value='NEJ!'>
				&nbsp;&nbsp;
				<input type='submit' name='" . POST_ACTION_DEFINE_KEYWORD_YES . "' value='JA!'>
			</fieldset>
		</form>
		";
		
		return $html;
	}

	// Takes a ScrapeLog object, calculates time differences and returns a formatted string.
	public function calculateLastUpdate(\model\ScrapeLog $scrapeLog = null) {
		$logText = "";
		
		if(isset($scrapeLog)) {
			if($scrapeLog->getFinishedAt() !== null) {
				$startTime = new \DateTime($scrapeLog->getStartedAt());
				$finishTime = new\DateTime($scrapeLog->getFinishedAt());
				$interval = $startTime->diff($finishTime);
				$duration = $interval->format("%h timmar, %i minuter, %S sekunder");
				$logText = "<p>Senast uppdaterad: " . $scrapeLog->getFinishedAt() . ". Tidsåtgång: " . $duration . "</p>";
			}
			else {
				$logText = "<p>Uppdatering pågår.</p>";
			}
		}
		
		return $logText;
	}
	
	// Takes a ScrapeLog object and checks if the task has been completed. Otherwise it's in progress and we return a "disabled" string.
	public function disableUpdate(\model\ScrapeLog $scrapeLog = null) {
		$disableText = "";
		
		if(isset($scrapeLog)) {
			if($scrapeLog->getFinishedAt() === null) {
				$disableText = "disabled";
			}
		}
		
		return $disableText;
	}
	
	// Sets a message that is displayed to the user.
	public function setMessage($message) {
		switch($message) {
			case ERROR_UPDATE_IN_PROGRESS:
				$this->message .= "<p>En uppdatering pågår redan, vänta tills den har kört klart innan du påbörjar nästa!</p>";
				break;
			default:
				$this->message .= "<p>Ett oväntat fel har inträffat, kontakta administratören eller försök igen senare</p>";
				break;
		}
	}
}



?>