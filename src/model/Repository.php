<?php
namespace model;

require_once("config.php");

abstract class Repository {
	
	protected $dbConnection;
	protected $dbTable;
	
	protected $XMLPath;
	protected $XMLElement;
	
	protected function connection() {
        try {
            if ($this->dbConnection == NULL) {
                $this->dbConnection = new \PDO(DB_CONNECTION, DB_USERNAME, DB_PASSWORD);
            }
            $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch(\Exception $e) {
            throw new \Exception("Unable to reach database");
        }
		return $this->dbConnection;
	}
	
	// Loads XML from path, returns it as an XMLElement
	public function loadXML($XMLPath) {
		$this->XMLPath = $XMLPath;
		$XMLContents = $this->get_url_contents($this->XMLPath);
        try {
            $this->XMLElement = simplexml_load_string($XMLContents);
        }
        catch(\Exception $e) {
            return null;
        }
        if(isset($this->XMLElement) && is_object($this->XMLElement)) {
            return $this->XMLElement;
        }
        return null;
	}
	
	// Fetches remote content as xml
	function get_url_contents($url){
        $curl = curl_init();
        $timeout = 5;
		curl_setopt($curl, CURLOPT_HTTPHEADER, array (
         'Accept: application/xml',
         'Accept-Language:sv-se,sv',
         'Content-Type: application/xml;charset=UTF-8'
     	));
		$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
		curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        curl_setopt ($curl, CURLOPT_URL,$url);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $ret = curl_exec($curl);
        curl_close($curl);
        return $ret;
}

}

?>