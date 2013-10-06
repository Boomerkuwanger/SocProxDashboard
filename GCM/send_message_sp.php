<?php
if (isset($_GET["socproxID"]) && isset($_GET["message"])) {
    $socproxID = $_GET["socproxID"];
    $message = $_GET["message"];
	$registatoin_ids = array();
 
    include_once './db_functions.php';
    include_once './GCM.php';
 
    $db = new DB_Functions();
    $gcm = new GCM();
	
	$socproxIDs = explode(",", $socproxID);
	$count = count($socproxIDs);
	for ($i = 0; $i < $count; $i++)
	{
		$tempID = $socproxIDs[$i];
		$regResult = $db->getRegID($tempID);
		while ($row = mysql_fetch_array($regResult))
		{
			$registatoin_ids[] = $row["gcm_regid"];
		}
	}
	
	/*$count = count($registatoin_ids);
	for ($i = 0; $i < $count; $i++)
	{
		echo "{$i} : {$registatoin_ids[$i]}<br>";
	}*/
    $aMessage = explode('=', $message);
    if (count($aMessage == 2)) {
        $messageInt = intval($aMessage[1]);
        if ($messageInt == 0) $messageString = $message;
        else $messageString = $messageInt;
    } else $messageString = $message;
    $message = array("message" => new ResponseObject($messageString));
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;
}

class ResponseObject {
    public $challenge;
    
    public function __construct($challenge){
        $this->challenge = $challenge;   
    }
}
?>