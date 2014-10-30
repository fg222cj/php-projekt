<?php
namespace view;

class HTMLView {
	public function showHTML($body) {
		if($body == NULL){
			$body = "Ett okänt fel har inträffat!<br />
			<a href='?'>Till startsidan</a>";
		}
			echo "
					<!DOCTYPE html>
					<html>
						<head>
							<meta charset='UTF-8'>
							<title>ArbetsmarknadsGuiden</title>
							<link rel='stylesheet' href='css/foundation.css' />
    						<script src='js/vendor/modernizr.js'></script>
						</head>
						<body>
							<div class='row'>
								<div class='large-12 columns'>
									<h1>ArbetsmarknadsGuiden</h1>
									<a href='?'>Hem</a>&nbsp;&nbsp;<a href='?" . GET_ACTION_ADMIN . "'>Admin</a>
									$body
								</div>
							</div>
						</body>
					</html>
			";
	}
}

?>