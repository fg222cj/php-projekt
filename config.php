<?php

/* Database settings */
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_CONNECTION", "mysql:host=127.0.0.1;dbname=amg;charset=utf8");

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

?>