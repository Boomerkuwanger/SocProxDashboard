<?php
 
// response json
$json = array();
 
/**
 * Registering a user device
 * Store reg id in users table
 */
if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["regId"]) && isset($_POST["socproxID"])) {
    
    // Store user details in db
    include_once './db_functions.php';
    include_once './GCM.php';
 
    $db = new DB_Functions();
    $gcm = new GCM();
	
	$socproxUser = $_POST["socproxID"]; // socproxID given by application will be username
	$socproxResult = $db->getSocproxID($socproxUser);
	if ($row = mysql_fetch_array($socproxResult))
	{
		$socproxID = $row["UserID"]; // socprox ID
	}
	else
	{
		$socproxID = -1;
	}
	
    $name = $_POST["name"];
    $email = $_POST["email"];
    $gcm_regid = $_POST["regId"]; // GCM Registration ID
 
    $res = $db->storeUser($name, $email, $gcm_regid, $socproxID);
 
    $registatoin_ids = array($gcm_regid);
    $message = array("push_notifications" => "enabled");
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;
} else {
    // user details missing
}
?>