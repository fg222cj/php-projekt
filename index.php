<?php
require_once("./config.php");
require_once("./DatabaseRefactor.php");
require_once("./src/view/HTMLView.php");
require_once("./src/controller/DataPresentationController.php");
require_once("./src/controller/DataScrapeController.php");
require_once("./src/controller/NavigationController.php");

$navigationController = new \controller\NavigationController();
$navigationController->doControl();

/*
$dpc = new \controller\DataPresentationController();
$HTMLBody = $dpc->doControl();
*/
/*
$dsc = new \controller\DataScrapeController();
$HTMLBody = $dsc->doControl();
*/
/*
$dr = new \DatabaseRefactor();
$HTMLBody = $dr->refactor();
*/

/*
$countyRepo = new \model\CountyRepository();
$countyRepo->populateCountiesAndMunicipalities();
*/

/*
$jobCatRepo = new \model\JobCategoryRepository();
$jobCatRepo->populateJobTables();
*/

/*
$jobGroupRepo = new \model\JobGroupRepository();
$jobGroupRepo->populateJobTables();
*/

/*
$jobAdRepo = new \model\JobAdRepository();
$jobAdRepo->populateJobAdTable();
echo "Platsannonser har lästs in."
*/
?>

