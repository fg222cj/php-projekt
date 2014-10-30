<?php
require_once("./config.php");
require_once("./DatabaseRefactor.php");
require_once("./src/view/HTMLView.php");
require_once("./src/controller/DataPresentationController.php");
require_once("./src/controller/DataScrapeController.php");
require_once("./src/controller/NavigationController.php");

$navigationController = new \controller\NavigationController();
$navigationController->doControl();
?>

