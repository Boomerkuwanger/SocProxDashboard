<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Game.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class DeleteGame {
	
	private static $m_oGame;
    public static function Execute ($gameId)
    {	
		self::$m_oGame = self::prepareDeletedGame($gameId);
		// Call database function
		DB_Controller::DeleteGame(self::$m_oGame);
        DB_Controller::Log("Controller", "Deleted game with Id = $gameId");
        return 0;
	}

	public static function Game(){
		return self::$m_oGame;
	}
	
	private function setGame($game)
	{
		self::$m_oGame = $game;
	}
	
	private static function prepareDeletedGame($Id){
		$game = new Game();
		$game->ID($Id);
		return $game;
	}
}