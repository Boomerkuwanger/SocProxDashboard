<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Stats.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class GetUserStats {
	
	private static $m_oStats;
	
	// RETURN CODES:
	// 0  = success
	// -1 = no user
	
	public static function Execute ($macaddress){
	    // Get the user from the database
		$user = DB_Controller::GetUserByMac($macaddress);
        
        // User doesn't exist - error out
		if (!isset($user)) return -1;
        
		DB_Controller::Log($macaddress, "Get Stats");
        
        // Create the stats object that will hold the data to return to the client
		self::$m_oStats = new Stats();
		self::$m_oStats->User($user);
        
        // Get the activities that the user is associated with in the database
		$aActivities = DB_Controller::GetActivities($user);
		if (!isset($aActivities)) {
		    // The user has no activities - set the information as such
			self::$m_oStats->ChallengesCompleted(0);
			self::$m_oStats->TotalPoints(0);
			return 0;
		}
        
        // Calculate the total points the user has for each game they are associated with
		$aTotalPoints = array();
		$iChallengesCompleted = 0;
		foreach ($aActivities as $activity){
		    // Cycle through the user's activities and add up their total points to return to the client
			if (!isset($aTotalPoints[$activity->GameID()])) $aTotalPoints[$activity->GameID()] = $activity->Points();
			else $aTotalPoints[$activity->GameID()] += $activity->Points();
			$iChallengesCompleted++;
		}
		self::$m_oStats->TotalPoints($aTotalPoints);
		self::$m_oStats->ChallengesCompleted($iChallengesCompleted);
        return 0;
	}
	
	public static function Stats(){
		return self::$m_oStats;
	}
}

?>