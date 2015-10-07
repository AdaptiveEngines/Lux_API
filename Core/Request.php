<?php
include_once("Output.php");

// functionally working
class Request{

	private $OUTPUT;
	private $parameters;
	private $docSet;

	function __construct(){
		$this->OUTPUT = new Output();
		$this->parameters = array();
		$this->setArray();
		$this->docSet = false;
	}

	function getParameters(){
		return $this->parameters;
	}

	private function setArray(){
		$decoded = json_decode(file_get_contents('php://input'), true);
		if(is_array($decoded)){
			foreach($decoded as $key => $value){
				$_POST[$key] = $value;
				$this->parameters[strtolower($key)] = $value;
			}
		}
		if(is_array($_POST)){
			foreach($_POST as $key => $value){
				$this->parameters[strtolower($key)] = $value;
			}
		}
		if(is_array($_GET)){
			foreach($_GET as $key => $value){
				$this->parameters[strtolower($key)] = $value;
			}
		}
		if(isset($_SESSION) && is_array($_SESSION)){
			foreach($_SESSION as $key => $value){
				$this->parameters[strtolower($key)] = $value;
			}
		}
		global $argv;
		if(is_array($argv)){
			foreach($argv as $key => $value){
				$this->parameters[strtolower($key)] = $value;
			}
		}
	}

	function setDocument($doc){
		if(!$this->docSet){
			$this->docSet = true;
			if(is_array($doc)){
				foreach($doc as $key => $value){
					$this->parameters[strtolower($key)] = $value;
				}
			}
		}
	}

	function avail($var){
		if(!isset($this->parameters[strtolower($var)])){
			return false;
		}else{
			return true;
		}
	}

	function get($var, $default=null){
		if(!isset($this->parameters[strtolower($var)])){
			if(is_null($default)){
				$this->OUTPUT->error("Required Variable is undefined", array("variable" => $var));
			}else{
				return $default;
			}
		}
		return $this->parameters[strtolower($var)];
	}

	function is_get($var, $die=true){
		if(!isset($_GET[$var])){
			if($die){
				$this->OUTPUT->error("Required Variable is undefined", array("variable" => $var));
			}else{
				return false;
			}
		}
		return $_GET[$var];
	}

	function is_post($var, $die=true){
		if(!isset($_POST[$var])){
			if($die){
				$this->OUTPUT->error("Required Variable is undefined", array("variable" => $var));
			}else{
				return false;
			}
		}
		return $_POST[$var];
	}
}


?>
  
