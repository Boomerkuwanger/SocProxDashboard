<?php

class Activity {
	
	private $m_iID;
    private $m_iUserID;
    private $m_iGameID;
    private $m_iChallengeInstID;
    private $m_tsTime;
    private $m_iPoints;
    private $m_iPayoffID;
    private $m_iVerifiedUser;
    private $m_iVerifiedID;
    private $m_strResult;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iID = $aValues['activityid'];
            $this->m_iUserID = $aValues['userid'];
            $this->m_iGameID = $aValues['gameid'];
            $this->m_iChallengeInstID = $aValues['challengeinstid'];
            $this->m_tsTime = $aValues['time'];
            $this->m_iPoints = $aValues['points'];
            $this->m_iPayoffID = $aValues['payoffid'];
            $this->m_iVerifiedUser = $aValues['verifiedby'];
            $this->m_iVerifiedID = $aValues['verifiedid'];
            $this->m_strResult = $aValues['result'];
        }
    }
    
    public function ID ($input = null){
        if (isset($input)) $this->m_iID = $input;
        return $this->m_iID;
    }
    
    public function UserID ($input = null){
        if (isset($input)) $this->m_iUserID = $input;
        return $this->m_iUserID;
    }
    
    public function GameID ($input = null){
        if (isset($input)) $this->m_iGameID = $input;
        return $this->m_iGameID;
    }
    
    public function ChallengeInstID ($input = null){
        if (isset($input)) $this->m_iChallengeInstID = $input;
        return $this->m_iChallengeInstID;
    }
    
    public function Time ($input = null){
        if (isset($input)) $this->m_tsTime = $input;
        return $this->m_tsTime;
    }
    
    public function Points ($input = null){
        if (isset($input)) $this->m_iPoints = $input;
        return $this->m_iPoints;
    }
    
    public function PayoffID ($input = null){
        if (isset($input)) $this->m_iPayoffID = $input;
        return $this->m_iPayoffID;
    }
    
    public function VerifiedBy ($input = null){
        if (isset($input)) $this->m_iVerifiedUser = $input;
        return $this->m_iVerifiedUser;
    }
    
    public function VerifiedID ($input = null){
        if (isset($input)) $this->m_iVerifiedID = $input;
        return $this->m_iVerifiedID;
    }
    
    public function Result ($input = null){
        if (isset($input)) $this->m_strResult = $input;
        return $this->m_strResult;
    }
    
	
}

?>