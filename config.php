<?php

/* Database settings - THESE NEED TO BE EDITED ON NEW INSTALLATIONS */
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_CONNECTION", "mysql:host=127.0.0.1;dbname=amg;charset=utf8");


/* Local settings - THESE NEED TO BE EDITED ON NEW INSTALLATIONS */
// Local system paths. Remember to escape backslashes on windows systems.
define("PHP_EXECUTE_FILE_PATH", "php -f");
define("BASE_ABSOLUTE_PATH", "/home/foss/public_html/amg/");


/* XML API settings */
define("BASE_PATH", "http://api.arbetsformedlingen.se/");
define("MATCH_PATH", "matchning?");
define("PAGE_PATH", "&sida=");
define("SEARCH_LIST_PATH", "soklista/");
define("AD_PATH", "platsannons/");
define("COUNTY_PATH", "lan");
define("COUNTY_ID_PATH", "lanid=");
define("MUNICIPALITY_PATH", "kommuner?lanid=");
define("JOB_CATEGORY_PATH", "yrkesomraden");
define("JOB_GROUP_PATH", "yrkesgrupper?yrkesomradeid=");
define("JOB_TITLE_PATH", "yrken?yrkesgruppid=");


/* XML API Fields and attributes (not used) */ //***********//
define("XML_COUNTY_ID", "id");
define("XML_COUNTY_NAME", "namn");
define("XML_COUNTY_NODE", "sokdata");


/* Database tables and columns */
define("COUNTY_TABLE", "lan");
define("MUNICIPALITY_TABLE", "kommuner");
define("JOB_CATEGORY_TABLE", "yrkesomraden");
define("JOB_GROUP_TABLE", "yrkesgrupper");
define("JOB_TITLE_TABLE", "yrken");
define("JOB_AD_TABLE", "platsannonser");
define("SCRAPE_LOG_TABLE", "scrapelog");
define("KEYWORD_TABLE", "keyword");

define("ID_COLUMN", "id");

define("COUNTY_ID_COLUMN", "lanid");
define("COUNTY_NAME_COLUMN", "namn");

define("MUNICIPALITY_ID_COLUMN", "kommunid");
define("MUNICIPALITY_NAME_COLUMN", "namn");
define("MUNICIPALITY_COUNTY_ID_COLUMN", "lanid");

define("JOB_CATEGORY_ID_COLUMN", "yrkesomradeid");
define("JOB_CATEGORY_NAME_COLUMN", "namn");

define("JOB_GROUP_ID_COLUMN", "yrkesgruppid");
define("JOB_GROUP_NAME_COLUMN", "namn");
define("JOB_GROUP_JOB_CATEGORY_ID_COLUMN", "yrkesomradeid");

define("JOB_TITLE_ID_COLUMN", "yrkeid");
define("JOB_TITLE_NAME_COLUMN", "namn");
define("JOB_TITLE_JOB_GROUP_ID_COLUMN", "yrkesgruppid");

define("JOB_AD_ID_COLUMN", "annonsid");
define("JOB_AD_HEADING_COLUMN", "annonsrubrik");
define("JOB_AD_TEXT_COLUMN", "annonstext");
define("JOB_AD_TITLE_COLUMN", "yrkesbenamning");
define("JOB_AD_JOB_TITLE_ID_COLUMN", "yrkesid");
define("JOB_AD_PUBLICATION_DATE_COLUMN", "publiceraddatum");
define("JOB_AD_POSITIONS_AVAILABLE_COLUMN", "antalplatser");
define("JOB_AD_MUNICIPALITY_NAME_COLUMN", "kommunnamn");
define("JOB_AD_MUNICIPALITY_ID_COLUMN", "kommunid");
define("JOB_AD_COUNTY_ID_COLUMN", "lanid");
define("JOB_AD_JOB_GROUP_ID_COLUMN", "yrkesgruppid");
define("JOB_AD_JOB_CATEGORY_ID_COLUMN", "yrkesomradeid");

define("SCRAPE_LOG_TABLE_NAME_COLUMN", "tablename");
define("SCRAPE_LOG_METHOD_COLUMN", "method");
define("SCRAPE_LOG_NEW_RECORDS_COLUMN", "newrecords");
define("SCRAPE_LOG_STARTED_AT_COLUMN", "startedat");
define("SCRAPE_LOG_FINISHED_AT_COLUMN", "finishedat");

define("KEYWORD_NAME", "keyword");
define("KEYWORD_RELEVANT", "relevant");
define("KEYWORD_JOB_CATEGORY_ID", "jobcategoryid");

/* HTTP GET-requests */
define("GET_ACTION_SEARCH", "search");
define("GET_ACTION_KEYWORD", "keyword");
define("GET_ACTION_MUNICIPALITY", "municipality"); 	// If this value is changed, related javascript(s) may also need to be edited.
define("GET_ACTION_COUNTY", "county");				// If this value is changed, related javascript(s) may also need to be edited.
define("GET_ACTION_JOB_CATEGORY", "jobcategory");	// If this value is changed, related javascript(s) may also need to be edited.
define("GET_ACTION_JOB_GROUP", "jobgroup");			// If this value is changed, related javascript(s) may also need to be edited.
define("GET_ACTION_JOB_TITLE", "jobtitle");			// If this value is changed, related javascript(s) may also need to be edited.
define("GET_ACTION_OPTIONS", "options");			// If this value is changed, related javascript(s) may also need to be edited.
define("GET_ACTION_OPTIONS_ID", "optionid");		// If this value is changed, related javascript(s) may also need to be edited.
define("GET_ACTION_ADMIN", "admin");


/* HTTP POST-requests */
define("POST_ACTION_SCRAPE_ADS", "scrapeads");
define("POST_ACTION_SCRAPE_JOB_TABLES", "scrapejobtables");
define("POST_ACTION_SCRAPE_REGION_TABLES", "scraperegiontables");
define("POST_ACTION_DEFINE_KEYWORD_NO", "definekeywordno");
define("POST_ACTION_DEFINE_KEYWORD_YES", "definekeywordyes");
define("POST_ACTION_DEFINE_KEYWORD", "definekeyword");
define("POST_ACTION_DEFINE_KEYWORD_JOB_CATEGORY", "definecategory");


/* Error messages */
define("ERROR_EMPTY_DATA_SET", "emptydataset");
define("ERROR_UPDATE_IN_PROGRESS", "updateinprogress");


/* File and folder paths */
define("FILE_PATH_GRAPHS_FOLDER", "./src/graphs/");
define("FILE_PATH_JS_AJAX", "./src/js/AJAX.js");
define("FILE_PATH_TASK_UPDATE_ADS", "UpdateAdTable.php");
define("FILE_PATH_TASK_UPDATE_JOBS", "UpdateJobTables.php");
define("FILE_PATH_TASK_UPDATE_REGIONS", "UpdateRegionTables.php");

?>