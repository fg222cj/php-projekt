<?php
namespace view;

class NavigationView {
	public function getAction() {
		if(isset($_GET[GET_ACTION_ADMIN])) {
			return GET_ACTION_ADMIN;
		}
		
		if(isset($_GET[GET_ACTION_SEARCH])) {
			return GET_ACTION_SEARCH;
		}
		
		if(isset($_GET[GET_ACTION_OPTIONS])) {
			return GET_ACTION_OPTIONS;
		}
	}
}

?>