<?php
// This file is responsible for updating the job title, job group and job category tables and can be executed independently.

require_once("./src/model/DataScrapeModel.php");

$dataScrapeModel = new \model\DataScrapeModel();
$dataScrapeModel->populateJobTables();

?>