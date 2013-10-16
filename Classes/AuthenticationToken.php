<?php
class Authentication {
	private $m_iId;
	private $m_iUserId;
    private $m_strSalt;
    private $m_strToken;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->$m_iId = $aValues['authenticationId'];
            $this->$m_iUserId = $aValues['userId'];
            $this->$m_strSalt = $aValues['salt'];
            $this->$m_strToken = $aValues['token'];
        }
    }
    
    public function SetId ($input = null){
        if (isset($input)) $this->$m_iId = $input;
        return $this->$m_iId;
    }
    
    public function SetUserId ($input = null){
        if (isset($input)) $this->$m_iUserId = $input;
        return $this->$m_iUserId;
    }
    
    public function SetSalt ($input = null){
        if (isset($input)) $this->$m_strSalt = $input;
        return $this->$m_strSalt;
    }
    
    public function SetToken ($input = null){
        if (isset($input)) $this->$m_strToken = $input;
        return $this->$m_strToken;
    }
}
?>