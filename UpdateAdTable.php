<?php
// This file is responsible for updating the job ad table and can be executed independently.

require_once("./src/model/DataScrapeModel.php");

$dataScrapeModel = new \model\DataScrapeModel();
$dataScrapeModel->populateAdTable();

?>