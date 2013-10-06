<?php

class ChallengeInstance {
    
    public $m_iID;
    public $m_iChallengeID;
    public $m_strUserAcceptance;
    public $m_strGameName;
    public $m_strUserIDs;
    public $m_strStatus;
    public $m_strAccepts;
    public $m_oChallenge;
    public $m_aOpponents;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iID = $aValues['challengeinstanceid'];
            $this->m_iChallengeID = $aValues['challengeid'];
            $this->m_strUserIDs = $aValues['userids'];
            $this->m_strStatus = $aValues['status'];
            $this->m_strAccepts = $aValues['accepts'];
        }
    }
    
    public function Accepted ($input = null) {
        if (isset($input)) $this->m_strUserAcceptance = $input;
        return $this->m_strUserAcceptance;
    }
    
    public function ID ($input = null){
        if (isset($input)) $this->m_iID = $input;
        return $this->m_iID;
    }
    
    public function Challenge ($input = null){
        if (isset($input)) $this->m_oChallenge = $input;
        return $this->m_oChallenge;
    }
    
    public function ChallengeID ($input = null){
        if (isset($input)) $this->m_iChallengeID = $input;
        return $this->m_iChallengeID;
    }
    
    public function GameName ($input = null){
        if (isset($input)) $this->m_strGameName = $input;
        return $this->m_strGameName;
    }
    
    public function Opponents ($input = null){
        if (isset($input)) $this->m_aOpponents = $input;
        return $this->m_aOpponents;
    }
    
    public function UserIDs ($input = null){
        if (isset($input)) $this->m_strUserIDs = $input;
        return $this->m_strUserIDs;
    }
    
    public function Status ($input = null){
        if (isset($input)) $this->m_strStatus = $input;
        return $this->m_strStatus;
    }
    
    public function Accepts ($input = null){
        if (isset($input)) $this->m_strAccepts = $input;
        return $this->m_strAccepts;
    }
}

?>