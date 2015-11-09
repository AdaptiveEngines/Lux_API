<?php
include_once("Db.php");

// functionally working
class Logging{

	private $DB;
	private $OUTPUT;
	private $log;
	private $API; 

	function __construct($API){
		$this->DB = new Db("Analytics");
		$this->OUTPUT = new Output();
		$this->log = $this->DB->selectCollection("Logging");
		$this->API = $API;
	}
	function log($client, $event=0, $trigger=0, $severity=100, $message=""){
		$logDoc = $this->OUTPUT->getLog($client, $event, $trigger, $severity, $message, $this->API);
		$this->addToDb($logDoc);	
	}
	private function addToDb($logDoc){
		echo json_encode($logDoc);
		$this->log->insert($logDoc);
	}
}
