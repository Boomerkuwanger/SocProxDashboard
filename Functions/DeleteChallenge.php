<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Challenge.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class DeleteChallenge {
	
	private static $m_oChallenge;
    public static function Execute ($Id)
    {	
		$challenge = self::prepareDeletedChallenge($Id);
		// Call database function
		DB_Controller::DeleteChallenge($challenge);
        DB_Controller::Log("Controller", "Deleted challenge with Id = $challenge->ID()");
        return 0;
	}

	public static function Challenge(){
		return self::$m_oChallenge;
	}
	
	private function setChallenge($challenge)
	{
		self::$m_oChallenge = $challenge;
	}
	
	private static function prepareDeletedChallenge($Id){
		$challenge = new Challenge();
		$challenge->ID($Id);
		return $challenge;
	}
}