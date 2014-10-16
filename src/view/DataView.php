<?php
namespace view;

class DataView {
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
				Nyckelord: <input name='keyword' type='text' />
				<input type='submit' value='Sök'>
			</fieldset>
		</form>
		";
		
		return $html;
	}
	
	public function showResult($hitCount, $keyword) {
		$html = $this->searchForm();
		$html .= "
		<p>Ordet $keyword förekom i $hitCount jobbannonser.</p>
		";
		
		return $html;
	}
}



?>