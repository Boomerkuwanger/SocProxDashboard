<?php

class SocialMedia {
    
    public $m_iID;
    public $m_iUserId;
    public $m_strUsername;
    public $m_strService;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iID = $aValues['id'];
            $this->m_iUserId = $aValues['userid'];
            $this->m_strUsername = $aValues['username'];
            $this->m_strService = $aValues['service'];
        }
    }
    
    public function ID ($input = null){
        if (isset($input)) $this->m_iID = $input;
        return $this->m_iID;
    }
    
    public function UserId ($input = null){
        if (isset($input)) $this->m_iUserId = $input;
        return $this->m_iUserId;
    }
    
    public function Username ($input = null){
        if (isset($input)) $this->m_strUsername = $input;
        return $this->m_strUsername;
    }
    
    public function Service ($input = null){
        if (isset($input)) $this->m_strService = $input;
        return $this->m_strService;
    }
    
}

?>