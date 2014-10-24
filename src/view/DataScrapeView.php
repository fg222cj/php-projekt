<?php
namespace view;

class DataScrapeView {
	public function getAction() {
		if(isset($_POST[POST_ACTION_SCRAPE_ADS])) {
			return POST_ACTION_SCRAPE_ADS;
		}
		
		if(isset($_POST[POST_ACTION_SCRAPE_JOB_TABLES])) {
			return POST_ACTION_SCRAPE_JOB_TABLES;
		}
	}
	
	public function adminForm() {
		$html = "
		<form action='' method='post'>
			<fieldset>
				<legend>Administration</legend>
				<input type='submit' name='" . POST_ACTION_SCRAPE_JOB_TABLES . "' value='Uppdatera jobbinfo'>
				<br />
				<input type='submit' name='" . POST_ACTION_SCRAPE_ADS . "' value='Samla jobbannonser'>
			</fieldset>
		</form>
		";
		
		return $html;
	}
}



?>