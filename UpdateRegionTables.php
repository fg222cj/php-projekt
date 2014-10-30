<?php
// This file is responsible for updating the county and municipality tables and can be executed independently.

require_once("./src/model/DataScrapeModel.php");

$dataScrapeModel = new \model\DataScrapeModel();
$dataScrapeModel->populateRegionTables();

?>