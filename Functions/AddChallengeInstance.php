<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/ChallengeInstance.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class AddChallengeInstance {
	
	private static $m_oChallengeInstance;
    
    // RETURN CODES:
    // 0  = success
	
	public static function Execute ($challengeID, $users){
	    // Split up the users given into the separate IDs
		$userIDs = $users[0]->ID();
		for ($i = 1; $i < count($users); $i++)
		{
			$userIDs = $userIDs.';'.$users[$i]->ID();
		}
		
        // Create a new challenge with the IDs given, and add it to the DB
		$challengeInstance = new ChallengeInstance();
		$challengeInstance->ChallengeID($challengeID);
		$challengeInstance->UserIDs($userIDs);
		$lastID = DB_Controller::AddChallengeInstance($challengeInstance);
        
        // Get the challenge instance that was just created from the DB. This is needed for challenge acceptance creation
		self::$m_oChallengeInstance = DB_Controller::GetChallengeInstByID($lastID);
        DB_Controller::Log($lastID.' '.$challengeID.' '.$userIDs, "add challenge instance");
        
        // Cycle through the users and add a challenge acceptance to the DB for the challenge that was just created, so their
        //   acceptance or denial of the challenge can be stored
		foreach ($users as $user)
		{
			$challengeAcceptance = new ChallengeAcceptance();
			$challengeAcceptance->UserID($user->ID());
			$challengeAcceptance->ChallengeInstanceID($lastID);
			$challengeAcceptance->Accepts('pending');
			DB_Controller::AddChallengeAcceptance($challengeAcceptance);
		}
		
        return 0;
	}
	
	public static function ChallengeInstance(){
		return self::$m_oChallengeInstance;
	}
}

?>