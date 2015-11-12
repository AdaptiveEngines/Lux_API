<?php 
include_once("Output.php");
include_once("Db.php");

// TODO: Integrate Database into Session stuff
class Ownership{
	function __construct($RULES){

	}
	function query($documents){

		// foreach
			// check if clear
			//unset if not

		return $documents;
	}
	function adjust($collection, $query){
		// if id, look for id in database
		
		// if query, query Asset Collection and then call to id
			// if Multiple returned, do this foreach
		return $query;
	}
	function id($id){
		$OUTPUT = new Output();
		// save to array of ids that have been looked up thus far
		// look up permissions and check if user is a member of any groups that have permissions
		$OUTPUT->error(3, "Insufficient Document Level Privleges");
		// if document does not exist in this collection, add it to the collection
	}
	function check($documents){
		// see if it is is in the array of ids that have been looked up thus far
		// if it isn't then add it to the collection because it must be a new document. 
		//$REQUEST->get("asset_id");
		return $documents;
	}
	function grant($REQUEST){
		$REQUEST->get("asset_id");
		// grant permissions
	}
	function find($REQUEST){
		// find document ownership
		$REQUEST->get("asset_id");
	}
	function mine($REQUEST){
		// find documents owned by this user
		$REQUEST->get("asset_id");
	}
}
