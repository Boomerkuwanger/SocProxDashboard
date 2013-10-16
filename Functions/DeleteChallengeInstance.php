<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/ChallengeInstance.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class DeleteChallengeInstance {
	
	private static $m_oChallengeInstance;
    public static function Execute ($challengeInstanceId)
    {	
		self::$m_oChallengeInstance = self::prepareDeletedChallengeInstance($challengeInstanceId);
		// Call database function
		DB_Controller::DeleteChallengeInstance(self::$m_oChallenge);
        DB_Controller::Log("Controller", "Deleted challenge instance with Id = $challengeInstanceId");
        return 0;
	}

	public static function ChallengeInstance(){
		return self::$m_oChallengeInstance;
	}
	
	private function setChallengeInstance($challenge)
	{
		self::$m_oChallengeInstance = $challenge;
	}
	
	private static function prepareDeletedChallengeInstance($Id){
		$challenge = new Challenge();
		$challenge->ID($Id);
		return $challenge;
	}
}