<?php
////////////////////////
// PDO CRUD functions //
////////////////////////
$dbhost = '';
$dbname = '';
$dbuser = ''; 
$dbpass = '';
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';', $dbuser, $dbpass);

//creates a new row in table. returns last insert id or false
//$tbl = string, table name to insert data into
//$h = array, key=>value to be inserted
function db_insert($tbl, $h){
	global $db;
	
	if($tbl && count($h)){
		$dbInsVar = array();
		$dbInsVal = array();
		foreach ($h as $dbVar=>$dbVal) {
			array_push($dbInsVar,$dbVar);
			if (strtolower($dbVal) == 'null') {
				array_push($dbInsVal,'null');
			}
			else {
				array_push($dbInsVal,$dbVal);
			}
		}
		$q = "INSERT INTO ".$tbl." (".implode(", ",$dbInsVar).") VALUES (:".implode(", :",$dbInsVar).")";
	
		try { 
			$stmt = $db->prepare($q); 
			$stmt->execute($h);  
		}catch(PDOException $ex){ 
			return false; 
		}
	
		return $db->lastInsertId();
	}else
		return false;
}

//reads entries from table returns entries or false
//$tbl = string, table name
//$k = string, table columns to be returned
//$id = number, ID of row if only 1
//$sort = string, column to sort by
function db_read($tbl, $k, $id=false,$sort=false){
	global $db;
	
	$q = 'SELECT '.$k.' FROM ' . $tbl;
	if($id)	
		$q .= ' WHERE id=' . $id;

	if($sort)
		$q .= ' ORDER BY ' . $sort . ' ASC';
	
	$rows = array();
	
	foreach($db->query($q) as $row)
		array_push($rows, $row);
		
	return $rows;
}

//updates row from table. returns true or false
//$tbl = string, table name
//$h = array, columns to be updated
//$id = number, id of row
function db_update($tbl, $h, $id){
	global $db;
	if (($tbl) && (count($h)) && ($id)) {
		$dbStr = array();
		foreach ($h as $dbVar=>$dbVal) {
			if ((strtolower($dbVal) == 'null') || (is_null($dbVal))) {
				array_push($dbStr,$dbVar."=null");
			}
			else { // else encapsulate in quotes
				array_push($dbStr,$dbVar."='".$dbVal."'");
			}
		}
		$q = "UPDATE ".$tbl." SET ".implode(", ",$dbStr)." WHERE id='".$id."'";
		
		try { 
			$stmt = $db->prepare($q); 
			$stmt->execute();  
		}catch(PDOException $ex){ 
			return false; 
		}
		return true;
	}else
		return false;
}

//deletes row from table. returns true or false
//$tbl = string, table name
//$id = number, id of row
function db_delete($tbl, $id){
	global $db;
	if (($tbl) && ($id)) {
		$q = "DELETE FROM ".$tbl." WHERE id='".(int)$id."' LIMIT 1";
		if($db->exec($q))
			return true;
		else 
			return false;
	}else 
		return false;
}
