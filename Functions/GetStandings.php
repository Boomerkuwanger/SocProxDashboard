<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Game.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Point.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class GetStandings {
    
    private static $m_aGames;
    private static $m_iLimit = 5;
    private static $m_strGameName;
    private static $m_strMAC;
    
    // RETURN CODES:
    // 0  = success
    // -1 = no such game for game name supplied
    // -2 = no such user for MAC address supplied
    // -3 = the user given is not involved in any games
    
    public static function Execute (){
        self::$m_aGames = array();
        
        if (isset(self::$m_strGameName)) {
            // The game name has been passed in, use that to find the game id and return just the standings for that game
            $game = DB_Controller::GetGame(self::$m_strGameName);
            if (!isset($game)) return -1;
            $game = DB_Controller::GetStandings(self::$m_iLimit, $game->ID());
            self::$m_aGames[] = $game;
            
            DB_Controller::Log(self::$m_strGameName, "Get Standings");
        } else {
            if (isset(self::$m_strMAC)) {
                // We are returning the standings for all the games the user is involved in
                $user = DB_Controller::GetUserByMac(self::$m_strMAC);
                if (!isset($user)) return -2;
                // Find out which games the user is involved in
                $aPoints = DB_Controller::GetPointsForUser($user);
                if (!isset($aPoints)) return -3;
                foreach ($aPoints as $point) {
                    // For each game the user is involved in, hit the DB and find the standings
                    $game = DB_Controller::GetStandings(self::$m_iLimit, $point->GameID());
                    self::$m_aGames[] = $game;
                }
                
                DB_Controller::Log(self::$m_strMAC, "Get Standings");
            } else {
                // No user or game name is given, so return the standings for all games
                $aAllGames = DB_Controller::GetAllGame();
                foreach ($aAllGames as $game) {
                    // For each game, get the standings
                    $gameStandings = DB_Controller::GetStandings(self::$m_iLimit, $game->ID());
                    self::$m_aGames[] = $gameStandings;
                }
                DB_Controller::Log("", "Get Standings");
            }            
        }
        return 0;
    }
    
    public static function GameName($m_strName = null) {
        if(isset($m_strName)) self::$m_strGameName = $m_strName;
        return self::$m_strGameName;
    }
    
    public static function Limit($m_iLimit = null) {
        if(isset($m_iLimit) && is_numeric($m_iLimit)) {
            self::$m_iLimit = $m_iLimit;
        }
        return self::$m_iLimit;
    }
    
    public static function Games(){
        return self::$m_aGames;
    }
    
    public static function Mac($m_strMAC = null) {
        if(isset($m_strMAC)) self::$m_strMAC = $m_strMAC;
        return self::$m_strMAC;
    }
}

?>