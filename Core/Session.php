<?php 
include_once("Request.php");
include_once("Output.php");
include_once("Db.php");
include_once("Rules.php");
// TODO: Integrate Database into Session stuff

class Session{
	private $id;
	function __construct($id = null){
		if(!is_null($id)){
			if($this->valid_id($id)){
				session_id($id);
			}else{
				$OUTPUT = new Output();
				$OUTPUT->error(2, "Session_id is invalid");
			}
		}
		if(!$this->session_active()){
			session_start();
		}
		$this->id = session_id();
	}
	function id(){
		return $this->id;
	}
	function set($key, $value = null){
		$REQUEST = new Request();
		if(is_null($value)){
			$_SESSION[$key] = $REQUEST->get($key);
		}else{
			$_SESSION[$key] = $value;
		}
	}

	function get($key){
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}else{
			$copy = $_SESSION;
			return $copy;
		}
	}
	private function valid_id($id){
	    return preg_match('/^[-,a-zA-Z0-9]{1,128}$/', $id) > 0;
	}
	private function session_active(){
	    if ( php_sapi_name() !== 'cli' ) {
		if ( version_compare(phpversion(), '5.4.0', '>=') ) {
		    return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
		} else {
		    return isset($_SESSION);
		}
	    }
	    return FALSE;
	}

}
