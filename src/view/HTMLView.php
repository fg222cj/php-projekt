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
						</head>
						<body>
							<h1>ArbetsmarknadsGuiden</h1>
							<a href='?'>Hem</a>&nbsp;&nbsp;<a href='?" . GET_ACTION_ADMIN . "'>Admin</a>
							$body
						</body>
					</html>
			";
	}
}

?>