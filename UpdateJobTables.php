<?php
require_once("./src/model/DataScrapeModel.php");

$dataScrapeModel = new \model\DataScrapeModel();
$dataScrapeModel->populateJobTables();

?>