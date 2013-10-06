<?php

class ChallengeAcceptance {
    
	public $m_iID;
    public $m_iChallengeInstanceID;
    public $m_iUserID;
    public $m_strAccepts;
    public $m_oInstance;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iID = $aValues['challengeacceptanceid'];
            $this->m_iChallengeInstanceID = $aValues['challengeinstanceid'];
            $this->m_iUserID = $aValues['userid'];
            $this->m_strAccepts = $aValues['accepts'];
        }
    }
    
    public function ID ($input = null){
        if (isset($input)) $this->m_iID = $input;
        return $this->m_iID;
    }
    
    public function Instance ($input = null){
        if (isset($input)) $this->m_oInstance = $input;
        return $this->m_oInstance;
    } 
    
    public function ChallengeInstanceID ($input = null){
        if (isset($input)) $this->m_iChallengeInstanceID = $input;
        return $this->m_iChallengeInstanceID;
    }
    
    public function UserID ($input = null){
        if (isset($input)) $this->m_iUserID = $input;
        return $this->m_iUserID;
    }

    public function Accepts ($input = null){
        if (isset($input)) $this->m_strAccepts = $input;
        return $this->m_strAccepts;
    }
}

?>