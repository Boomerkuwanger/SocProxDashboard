<?php

class Stats {
	
    public $m_oUser;
    public $m_iChallengesCompleted;
    public $m_aUserGameStats;
    
    public function User ($input = null){
        if (isset($input)) $this->m_oUserID = $input;
        return $this->m_oUserID;
    }
    
    public function ChallengesCompleted ($input = null){
        if (isset($input)) $this->m_iChallengesCompleted = $input;
        return $this->m_iChallengesCompleted;
    }
    
    public function UserGameStats ($input = null){
        if (isset($input)) $this->m_aUserGameStats = $input;
        return $this->m_aUserGameStats;
    }
}

/*
        
 * SELECT Activity.GameID, Game.Name AS GameName, Game.Description AS GameDesc, SUM(Activity.Points) AS TotalPoints FROM Activity, Game WHERE Activity.GameID=Game.GameID AND Activity.UserID="1" GROUP BY Activity.GameID
 */

class UserGameStats {
    
    public $m_strGameName;
    public $m_strGameID;
    public $m_strGameDescription;
    public $m_iTotalPoints;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_strGameID = $aValues['gameid'];
            $this->m_strGameName = $aValues['gamename'];
            $this->m_strGameDescription = $aValues['gamedesc'];
            $this->m_iTotalPoints = $aValues['totalpoints'];
        }
    }
    
    public function GameName($gameName = null) {
        if (isset($gameName)) $this->m_strGameName = $gameName;
        return $this->m_strGameName;
    }
    
    public function GameID($gameID = null) {
        if (isset($gameID)) $this->m_strGameID = $gameID;
        return $this->m_strGameID;
    }
    
    public function GameDescription($gameDescription = null) {
        if (isset($gameDescription)) $this->m_strGameDescription = $gameDescription;
        return $this->m_strGameDescription;
    }
    
    public function TotalPoints($total = null) {
        if (isset($total)) $this->m_iTotalPoints = $total;
        return $this->m_iTotalPoints;
    }
}

?>