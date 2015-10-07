<?php
include_once("Db.php");

// functionally working
class Request{

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
		$log = $this->OUTPUT->getLog($client, $event, $trigger, $severity, $message, $this->API);
		$this->addToDb($log);	
	}
	private function addToDb($log){
		$this->log->insert($log);
	}
}
