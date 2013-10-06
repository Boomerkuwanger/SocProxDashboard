<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class GetActiveChallenges {
	
	private static $m_oUser;
    
    // RETURN CODES:
    // object  = success
    // -1      = no user
	
	public static function Execute ($macAddress){
	    // Get the user 
		self::$m_oUser = DB_Controller::GetUserByMac($macAddress);
		//echo self::$m_oUser->m_strUsername;
		if (isset(self::$m_oUser)) {
		    // We got the user - so get the challenges
			$aChallenges = DB_Controller::GetChallenges(self::$m_oUser);
        	DB_Controller::Log($macAddress, "Get Challenges");
			return $aChallenges;
		}
		else return -1;
	}
	
	public static function User(){
		return self::$m_oUser;
	}
	
}

?>