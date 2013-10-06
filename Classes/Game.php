<?php

class Game {
        
    public $m_aStandings;
    public $m_iID;
    public $m_strName;
    public $m_strDesc;
    public $m_strCriteria;
    public $m_tsStartDate;
    public $m_tsEndDate;
    public $m_iDuration;
    public $m_iWinningPoints;
    public $m_iNumOfIterations;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iID = $aValues['gameid'];
            $this->m_strName = $aValues['name'];
            $this->m_strDesc = $aValues['description'];
            $this->m_strCriteria = $aValues['criteriatoplay'];
            $this->m_tsStartDate = $aValues['startdate'];
            $this->m_tsEndDate = $aValues['enddate'];
            $this->m_iDuration = $aValues['duration'];
            $this->m_iWinningPoints = $aValues['winningpoints'];
            $this->m_iNumOfIterations = $aValues['numberofiterations'];
        }
    }
    
    public function ID ($input = null){
        if (isset($input)) $this->m_iID = $input;
        return $this->m_iID;
    }
    
    public function Name ($input = null){
        if (isset($input)) $this->m_strName = $input;
        return $this->m_strName;
    }
    
    public function Description ($input = null){
        if (isset($input)) $this->m_strDesc = $input;
        return $this->m_strDesc;
    }
    
    public function Criteria ($input = null){
        if (isset($input)) $this->m_strCriteria = $input;
        return $this->m_strCriteriac;
    }
    
    public function StartDate ($input = null){
        if (isset($input)) $this->m_tsStartDate = $input;
        return $this->m_tsStartDate;
    }
    
    public function EndDate ($input = null){
        if (isset($input)) $this->m_tsEndDate = $input;
        return $this->m_tsEndDate;
    }
    
    public function Duartion ($input = null){
        if (isset($input)) $this->m_iDuration = $input;
        return $this->m_iDuration;
    }
    
    public function WinningPoints ($input = null){
        if (isset($input)) $this->m_iWinningPoints = $input;
        return $this->m_iWinningPoints;
    }
    
    public function NumIterations ($input = null){
        if (isset($input)) $this->m_iNumOfIterations = $input;
        return $this->m_iNumOfIterations;
    }
    
    public function Standings ($input = null){
        if (isset($input)) $this->m_aStandings = $input;
        return $this->m_aStandings;
    }
    
    
}

?>