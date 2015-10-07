<?php
// seems functionally complete
include_once("Request.php");
include_once("Output.php");
include_once("Rules.php");

class Db{

	private $db;
	private $OUTPUT;
	private $REQUEST;
	private $db_domain;

	function __construct($db){
		$this->OUTPUT = new Output();
		$this->REQUEST = new Request();
		if(class_exists("MongoClient")){
			$MON = new MongoClient("mongodb://localhost/");
		}else{
			$this->OUTPUT->error("Lux is not Properly Set-up, can not find MongoClient");
		}
		if($this->REQUEST->avail("db_domain")){
			$this->db_domain = $this->REQUEST->get("db_domain");
		}else{
			$this->db_domain = $_SERVER["SERVER_NAME"];
		}
		$this->db_domain = str_replace(".","_",$this->db_domain);
		if($db == null){
			$this->db = $MON->selectDB($this->db_domain."_System");
		}else{
			$this->db = $MON->selectDB($this->db_domain."_".$db);
		}
	}

	function selectCollection($collectionName){
		return new Collection($this->db, $collectionName);
	}
}
class Collection{
	
	private $db;
	private $collectionName;
	private $collection;
	function __construct($db, $collectionName){
		$this->db = $db;
		$this->collectionName = $collectionName;
		$this->collection = $this->db->selectCollection($this->collectionName);
	}
	function queryFix($query){
		if(!is_array($query)){
			if(MongoId::isValid($query)){
				$query = array("_id" => new MongoId($query));
			}else{
				$query = array("_id" => $query);
			}
		}
		return $query;
	}
	function resolve($document, $options){
		if(!isset($options["resolve"]) || !$options["resolve"]){
			return $document;
		}
		// check if resolve is set
		// iterate through and resolve all dbRefs to the Recursive level specified
		// also resolve _ids
	}
	function findOne($query, $fields = array(), $options = array()){
		$query = $this->queryFix($query);
		$document = $this->collection->findOne($query, $fields, $options);
		$document = $this->resolve($document, $options);
		return $document;
	}
	function find($query, $options = array()){
		$query = $this->queryFix($query);
		if(isset($options["skip"]) && isset($options["limit"])){
			$documents = $this->collection->find($query, $options)->skip($options["skip"])->limit($options["limit"]);
		}else if(isset($options["skip"])){
			$documents = $this->collection->find($query, $options)->skip($options["skip"]);
		}else if(isset($options["limit"])){
			$documents = $this->collection->find($query, $options)->limit($options["limit"]);
		}else{
			$documents = $this->collection->find($query, $options);
		}
		$documents = iterator_to_array($documents);
		$documents = $this->resolve($documents, $options);
		return $documents;
	}
	function count($query = array()){
		if(is_null($query)){
			return $this->collection->count();
		}else{
			$query = $this->queryFix($query);
			return $this->collection->count($query);
		}
	}

	function metaData($update){
		
		$RULES = new Rules(0);

		// save the update to the document to the document itself
		$update['$push']["mods"][0]["update"] = json_encode($update);
		
		// Add a timestamp for the modification
		$update['$push']["mods"][0]["time_modified"] = new MongoDate();
		
		// add a modifier for the modification
		$update['$push']["mods"][0]["modifier"] = $RULES->getId();

		$update['$push']["mods"][0]["modifier"] = $RULES->getId();
			
		return $update;
	}
	// takes the options remove and sort 
	function findAndModify($query=array(), $update=null, $options=null){
		if(is_null($options)){
			$options = array();
		}
		if(!isset($options["remove"])){
			$options["update"] = true;
			$options["upsert"] = true;
		}
		if(!isset($options["new"])){
			$options["new"] = true;
		}
		$query = $this->queryFix($query);
		$update = $this->metaData($update);
	
		return $this->collection->findAndModify($query, $update, null, $options);
	}	
	function update($query=array(), $update=null, $options=null){
		if(is_null($options)){
			$options = array();
			$options["multiple"] = false;
		}
		$options["upsert"] = true;
		$query = $this->queryFix($query);
		$update = $this->metaData($update);
		
		return $this->collection->update($query, $update, $options);
	}
	function insert($update=array(), $options=null){
		if(is_null($options)){
			$options = array("upsert"=>true, "multiple"=>false);
		}
		$update = $this->metaData($update);
		return $this->collection->insert($update, $options);
	}
}

/* MAYBE Brought back later, for now depreciated

	function publish($document, $AUTH, $priority=0){
		$document["info"] = array("sender" => $AUTH->getClientId(), "timestamp" => microtime(), "priority"=> $priority, "checked_by" => array("python" => false, "node" => false));
		$Published = $this->selectCollection("Published");
		$Published->update(array("_id"=>$document["_id"]),$document, array("upsert"=>true));
	}
	
	function unpublish($document, $AUTH, $priority=0){
		$Published = $this->selectCollection("Published");
		$Published->remove(array("_id"=>$document["_id"]));
	}

	function subscribe($query, $AUTH){
		$subscribers = $this->selectCollection("Subscribers");
		$subDoc = $subscribers->update(
		array("query"=>$query)
		,array('$addToSet'=> array("subscribers" => array("id" => $AUTH->getClientId())) 
	        ,'$set'=>array("timestamp"=>microtime()))
		,array("upsert"=>true));
	}
	
	function unsubscribe($query, $AUTH){
		$subscribers = $this->selectCollection("Subscribers");
		$subDoc = $subscribers->update(
		array("query"=>$query)
		,array('$pull'=> array("subscribers" => array(array("id"=>$AUTH->getClientId()))) 
	        ,'$set'=>array("timestamp"=>microtime()))
		,array("upsert"=>true));
	}
*/
?>




  
