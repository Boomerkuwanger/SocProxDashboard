<?php

class Challenge {
    
    public $m_iID;
    public $m_strIntName;
    public $m_strIntDesc;
    public $m_strName;
    public $m_strInstr;
    public $m_iCatID;
    public $m_iGameID;
    public $m_tsStartDate;
    public $m_tsEndDate;
    public $m_tsStartTime;
    public $m_tsEndTime;
    public $m_iP1ID;
    public $m_iP2ID;
    public $m_iP3ID;
    public $m_iP4ID;
    public $m_iMinPlayers;
    public $m_iMaxPlayers;
    public $m_iVerificationID;
    public $m_strDesc;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iID = $aValues['challengeid'];
            $this->m_strIntName = $aValues['internalname'];
            $this->m_strIntDesc = $aValues['internaldescription'];
            $this->m_strName = $aValues['name'];
            $this->m_strInstr = $aValues['instructions'];
            $this->m_iCatID = $aValues['categoryid'];
            $this->m_iGameID = $aValues['gameid'];
            $this->m_tsStartDate = $aValues['startdate'];
            $this->m_tsEndDate = $aValues['enddate'];
            $this->m_tsStartTime = $aValues['starttime'];
            $this->m_tsEndTime = $aValues['endtime'];
            $this->m_iP1ID = $aValues['p1id'];
            $this->m_iP2ID = $aValues['p2id'];
            $this->m_iP3ID = $aValues['p3id'];
            $this->m_iP4ID = $aValues['p4id'];
            $this->m_iMinPlayers = $aValues['minplayers'];
            $this->m_iMaxPlayers = $aValues['maxplayers'];
            $this->m_iVerificationID = $aValues['verificationid'];
            $this->m_strDesc = $aValues['description'];
            }
    }
    
    public function ID ($input = null){
        if (isset($input)) $this->m_iID = $input;
        return $this->m_iID;
    }
    
    public function IntName ($input = null){
        if (isset($input)) $this->m_strIntName = $input;
        return $this->m_strIntName;
    }
    
    public function IntDescription ($input = null){
        if (isset($input)) $this->m_strIntDesc = $input;
        return $this->m_strIntDesc;
    }
    
    public function Name ($input = null){
        if (isset($input)) $this->m_strName = $input;
        return $this->m_strName;
    }
    
    public function Instructions ($input = null){
        if (isset($input)) $this->m_strInstr = $input;
        return $this->m_strInstr;
    }
    
    public function CategoryID ($input = null){
        if (isset($input)) $this->m_iCatID = $input;
        return $this->m_iCatID;
    }
    
    public function GameID ($input = null){
        if (isset($input)) $this->m_iGameID = $input;
        return $this->m_iGameID;
    }
    
    public function StartDate ($input = null){
        if (isset($input)) $this->m_tsStartDate = $input;
        return $this->m_tsStartDate;
    }
    
    public function EndDate ($input = null){
        if (isset($input)) $this->m_tsEndDate = $input;
        return $this->m_tsEndDate;
    }
    
    public function StartTime ($input = null){
        if (isset($input)) $this->m_tsStartTime = $input;
        return $this->m_tsStartTime;
    }
    
    public function EndTime ($input = null){
        if (isset($input)) $this->m_tsEndTime = $input;
        return $this->m_tsEndTime;
    }
    
    public function P1ID ($input = null){
        if (isset($input)) $this->m_iP1ID = $input;
        return $this->m_iP1ID;
    }
    
    public function P2ID ($input = null){
        if (isset($input)) $this->m_iP2ID = $input;
        return $this->m_iP2ID;
    }  
    
    public function P3ID ($input = null){
        if (isset($input)) $this->m_iP3ID = $input;
        return $this->m_iP3ID;
    }  
    
    public function P4ID ($input = null){
        if (isset($input)) $this->m_iP4ID = $input;
        return $this->m_iP4ID;
    }  
    
    public function MinPlayers ($input = null){
        if (isset($input)) $this->m_iMinPlayers = $input;
        return $this->m_iMinPlayers;
    }  
    
    public function MaxPlayers ($input = null){
        if (isset($input)) $this->m_iMaxPlayers = $input;
        return $this->m_iMaxPlayers;
    }  
    
    public function VerificationID ($input = null){
        if (isset($input)) $this->m_iVerificationID = $input;
        return $this->m_iVerificationID;
    }  
    
    public function Description ($input = null){
        if (isset($input)) $this->m_strDesc = $input;
        return $this->m_strDesc;
    }  
}

?>