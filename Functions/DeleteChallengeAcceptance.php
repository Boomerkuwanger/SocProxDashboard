<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/ChallengeAcceptance.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class DeleteChallengeAcceptance {
	
	private static $m_oChallengeAcceptance;
    public static function Execute ($challengeAcceptanceId)
    {	
		self::$m_oChallengeAcceptance = self::prepareDeletedChallengeAcceptance($challengeAcceptanceId);
		// Call database function
		DB_Controller::DeleteChallenge(self::$m_oChallengeAcceptance);
        DB_Controller::Log("Controller", "Deleted challenge acceptance with Id = $challengeAcceptanceId");
        return 0;
	}

	public static function ChallengeAcceptance(){
		return self::$m_oChallengeAcceptance;
	}
	
	private function setChallengeAcceptance($challenge)
	{
		self::$m_oChallengeAcceptance = $challenge;
	}
	
	private static function prepareDeletedChallengeAcceptance($Id){
		$challenge = new Challenge();
		$challenge->ID($Id);
		return $challenge;
	}
}