<?php
require_once("./config.php");
require_once("./src/view/HTMLView.php");
require_once("./src/controller/DataController.php");

$dc = new \controller\DataController();
$HTMLBody = $dc->doControl();

$htmlView = new \view\HTMLView();
$htmlView->showHTML($HTMLBody);

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

