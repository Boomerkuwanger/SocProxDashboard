<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Challenge.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class AddChallenge {
	
	private static $m_oChallenge;
    
    // RETURN CODES:
    // 1  = success, updated challenge
    // 0  = success
    // -1 = cannot make challenge
    public static function Execute ($name, $instructions, $gameid, $start, $end, $minplayers, $maxplayers, $verificationid)
    {
    	//todo FUTURE EVENT: 
    	// by adding GetChallenges which
    	// returns all available challenges
    	
    	/* See if the challenge exists in the DB
    	$existingChallenge = DB_Controller::GetChallenges($name);
		if (isset($existingChallenge))
		{
		    // let's update the Challenge based on the information given
		    self::prepareExistingChallenge($existingChallenge, $name, $instructions, $gameid, $start, $end, $minplayers, $maxplayers, $verificationid);
			DB_Controller::UpdateChallenge($existingChallenge);
			self::$m_oChallenge = $existingChallenge;
			DB_Controller::Log("Controller", "Update Challenge $name");
			return 1;
		}
		*/
		// Create the new Challenge and add it to the Challenge DB table
		//Prepare object...
		$challenge = self::prepareNewChallenge($name, $instructions, $gameid, $start, $end, $minplayers, $maxplayers, $verificationid);
		// Call database function
		DB_Controller::AddChallenge($challenge);
		
		// todo future event: Check to see if the challenge exists
		/*
		 self::$m_oChallenge = DB_Controller::GetChallenges($name);
        if (!isset(self::$m_oChallenge)) {
            return -1;
        }
		*/

        DB_Controller::Log("Controller", "New Challenge $name");
        return 0;
	}

	public static function Challenge(){
		return self::$m_oChallenge;
	}
	/*
	private static function prepareExistingChallenge($existingChallenge, $name, $instructions, $gameid, $start, $end, $minplayers, $maxplayers, $verificationid){
		$existingGame->Name($name);
		$existingGame->Instructions($instructions);
		$existingGame->GameID($gameid);
		$existingGame->StartDate($start);
		$existingGame->EndDate($end);
		$existingGame->MinPlayers($minplayers);
		$existingGame->MaxPlayers($maxplayers);
		$existingGame->VerificationID($verificationid);
	}
	*/
	private static function prepareNewChallenge($name, $instructions, $gameid, $start, $end, $minplayers, $maxplayers, $verificationid){
		$challenge = new Challenge();
		$challenge->Name($name);
		$challenge->Instructions($instructions);
		$challenge->GameID($gameid);
		$challenge->StartDate($start);
		$challenge->EndDate($end);
		$challenge->MinPlayers($minplayers);
		$challenge->MaxPlayers($maxplayers);
		$challenge->VerificationID($verificationid);
		return $challenge;
	}
}