<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Game.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class AddGame {
	
	private static $m_oGame;
    
    // RETURN CODES:
    // 1  = success, updated game
    // 0  = success
    // -1 = cannot make game
    public static function Execute ($name, $description, $criteria, $start, $end, $points)
    {
    	//See if the game exists in the DB
    	$existingGame = DB_Controller::GetGame($name);
		if (isset($existingGame))
		{
		    // let's update the game based on the information given
		    self::prepareExistingGame($existingGame, $name, $description, $criteria, $start, $end, $points);
			DB_Controller::UpdateGame($existingGame);
			self::$m_oGame = $existingGame;
			DB_Controller::Log("Controller", "Update Game $name");
			return 1;
		}
		// Create the new game and add it to the game DB table
		//Prepare object...
		$game = self::prepareNewGame($name, $description, $criteria, $start, $end, $points);
		// Call database function
		DB_Controller::AddGame($game);
		// Check to see if the game exists
		self::$m_oGame = DB_Controller::GetGame($name);
        if (!isset(self::$m_oGame)) {
            return -1;
        }
        DB_Controller::Log("Controller", "New Game $name");
        return 0;
	}
	public static function Game(){
		return self::$m_oGame;
	}
	
	private static function prepareExistingGame($existingGame, $name, $description, $criteria, $start, $end, $points){
		$existingGame->Name($name);
		$existingGame->Description($description);
		$existingGame->Criteria($criteria);
		$existingGame->StartDate($start);
		$existingGame->EndDate($end);
		$existingGame->WinningPoints($points);

	}
	
	private static function prepareNewGame($name, $description, $criteria, $start, $end, $points){
		$game = new Game();
		$game->Name($name);
		$game->Description($description);
		$game->Criteria($criteria);
		$game->StartDate($start);
		$game->EndDate($end);
		$game->WinningPoints($points);
		return $game;
	}
}