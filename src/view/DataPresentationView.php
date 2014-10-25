<?php
namespace view;

require_once("./src/model/Result.php");

class DataPresentationView {
	private $message = "";
	
	public function getAction() {
		if(isset($_GET[GET_ACTION_KEYWORD])) {
			return GET_ACTION_KEYWORD;
		}
	}
	
	public function getKeyword() {
		return $_GET[GET_ACTION_KEYWORD];
	}
	
	public function searchForm() {
		$html = "
		<form action='' method='get'>
			<fieldset>
				<legend>Sökning</legend>
				$this->message
				Nyckelord: <input name='keyword' type='text' />
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
	
	public function setMessage($message) {
		switch($message) {
			case ERROR_EMPTY_DATA_SET:
				$this->message .= "<p>Nyckelordet förekom inte eller är inte ett relevant nyckelord, försök med ett annat ord</p>";
				break;
			default:
				$this->message .= "<p>Ett oväntat fel har inträffat, kontakta administratören eller försök igen senare</p>";
				break;
		}
	}
}



?>