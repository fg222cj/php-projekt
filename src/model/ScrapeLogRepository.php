<?php
namespace model;

require_once('./src/model/ScrapeLog.php');
require_once('./src/model/Repository.php');

class ScrapeLogRepository extends Repository {
	public function add(\model\ScrapeLog $scrapeLog) {
		$db = $this->connection();

		$sql = "INSERT IGNORE INTO " . SCRAPE_LOG_TABLE . " (" . SCRAPE_LOG_TABLE_NAME_COLUMN . ", 
		" . SCRAPE_LOG_NEW_RECORDS_COLUMN . ", " . SCRAPE_LOG_STARTED_AT_COLUMN . ", " . SCRAPE_LOG_FINISHED_AT_COLUMN . ") VALUES (?, ?, ?, ?)";
		$params = array($scrapeLog->getTableName(), $scrapeLog->getNewRecords(), $scrapeLog->getStartedAt(), $scrapeLog->getFinishedAt());

		$query = $db->prepare($sql);
		$query->execute($params);
		
		return $db->lastInsertId();
	}
	
	public function getAllFromDb() {
		$db = $this->connection();

		$sql = "SELECT * FROM " . SCRAPE_LOG_TABLE;

		$query = $db->prepare($sql);
		$query->execute();

		$result = $query->fetchAll();
		$counties = array();
		
		foreach($result as $row) {
			$scrapeLog = new \model\ScrapeLog($row[ID_COLUMN], $row[SCRAPE_LOG_TABLE_NAME_COLUMN], $row[SCRAPE_LOG_NEW_RECORDS_COLUMN], 
			$row[SCRAPE_LOG_STARTED_AT_COLUMN], $row[SCRAPE_LOG_FINISHED_AT_COLUMN]);
			$scrapeLogs[] = $scrapeLog;
		}
		
		return $scrapeLogs;
	}

	public function getFromDb($id) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . SCRAPE_LOG_TABLE . " WHERE " . ID_COLUMN . " = ?";
		$params = array($id);

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		if ($result) {
			$scrapeLog = new \model\ScrapeLog($result[ID_COLUMN], $result[SCRAPE_LOG_TABLE_NAME_COLUMN], $result[SCRAPE_LOG_NEW_RECORDS_COLUMN], 
			$result[SCRAPE_LOG_STARTED_AT_COLUMN], $result[SCRAPE_LOG_FINISHED_AT_COLUMN]);
			return $scrapeLog;
		}

		return null;
	}
	
	public function getLastFromDbByTableName($tableName) {
		$db = $this->connection();

		$sql = "SELECT * FROM " . SCRAPE_LOG_TABLE . " WHERE " . SCRAPE_LOG_TABLE_NAME_COLUMN . " = ? ORDER BY " . ID_COLUMN . " DESC LIMIT 1";
		$params = array($tableName);

		$query = $db->prepare($sql);
		$query->execute($params);

		$result = $query->fetch();

		if ($result) {
			$scrapeLog = new \model\ScrapeLog($result[ID_COLUMN], $result[SCRAPE_LOG_TABLE_NAME_COLUMN], $result[SCRAPE_LOG_NEW_RECORDS_COLUMN], 
			$result[SCRAPE_LOG_STARTED_AT_COLUMN], $result[SCRAPE_LOG_FINISHED_AT_COLUMN]);
			return $scrapeLog;
		}

		return null;
	}
	
	public function update(\model\ScrapeLog $scrapeLog) {
		$db = $this->connection();

		$sql = "UPDATE " . SCRAPE_LOG_TABLE . " SET " . SCRAPE_LOG_TABLE_NAME_COLUMN . " = ?, " . SCRAPE_LOG_NEW_RECORDS_COLUMN . " = ?, 
		" . SCRAPE_LOG_STARTED_AT_COLUMN . " = ?, " . SCRAPE_LOG_FINISHED_AT_COLUMN . " = ? WHERE " . ID_COLUMN . " = ?";
		
		$params = array($scrapeLog->getTableName(), $scrapeLog->getNewRecords(), $scrapeLog->getStartedAt(), $scrapeLog->getFinishedAt(), $scrapeLog->getId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}
	 
	public function delete(\model\ScrapeLog $scrapeLog) {
		$db = $this -> connection();

		$sql = "DELETE FROM " . SCRAPE_LOG_TABLE . " WHERE " . ID_COLUMN . " = ?";
		$params = array($scrapeLog->getId());

		$query = $db->prepare($sql);
		$query->execute($params);
	}

}
