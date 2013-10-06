<?php

class GlobalStats {
    
    public $m_iTotalUsers;
    public $m_iTotalActiveUsers;
    public $m_iGamesStarted;
    public $m_iGamesCompleted;
    public $m_iGamesInProgress;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iTotalUsers = $aValues['totalusers'];
            $this->m_iTotalActiveUsers = $aValues['activeusers'];
            $this->m_iGamesStarted = $aValues['gamesstarted'];
            $this->m_iGamesCompleted = $aValues['gamescompleted'];
            $this->m_iGamesInProgress = $aValues['gamesinprogress'];
        }
    }
    
    public function TotalUsers ($userCount = null){
        if (isset($userCount)) $this->m_iTotalUsers = $userCount;
        return $this->m_iTotalUsers;
    }
    
    public function TotalActiveUsers ($activeCount = null){
        if (isset($activeCount)) $this->m_iTotalActiveUsers = $activeCount;
        return $this->m_iTotalActiveUsers;
    }
    
    public function GamesStarted ($gamesStarted = null){
        if (isset($gamesStarted)) $this->m_iGamesStarted = $gamesStarted;
        return $this->m_iGamesStarted;
    }
    
    public function GamesCompleted ($gamesCompleted = null){
        if (isset($gamesCompleted)) $this->m_iGamesCompleted = $gamesCompleted;
        return $this->m_iGamesCompleted;
    }
    
    public function GamesInProgress ($gamesInProgress = null){
        if (isset($gamesInProgress)) $this->m_iGamesInProgress = $gamesInProgress;
        return $this->m_iGamesInProgress;
    }
}

?>