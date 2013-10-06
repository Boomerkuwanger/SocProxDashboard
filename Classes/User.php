<?php

class User {
    
    public $m_iID;
    public $m_strUsername;
    public $m_strMac;
    public $m_strPassword;
    public $m_strSSID;
    public $m_strFacebook;
    public $m_strName;
    public $m_strPicLoc;
    public $m_strStatus;
    public $m_iTotalPoints;
    public $m_strLastLoc;
    public $m_strDevice;
    public $m_iGamesFin;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iID = $aValues['userid'];
            $this->m_strUsername = $aValues['username'];
            $this->m_strMac = $aValues['macaddress'];
            $this->m_strPassword = $aValues['password'];
            $this->m_strSSID = $aValues['ssid'];
            $this->m_strFacebook = $aValues['facebookemail'];
            $this->m_strName = $aValues['name'];
            $this->m_strPicLoc = $aValues['picturelocation'];
            $this->m_strStatus = $aValues['playingstatus'];
            $this->m_iTotalPoints = $aValues['totalpoints'];
            $this->m_strLastLoc = $aValues['lastlocation'];
            $this->m_strDevice = $aValues['devicetype'];
            $this->m_iGamesFin = $aValues['gamesfinished'];
        }
    }
    
    public function ID ($input = null){
        if (isset($input)) $this->m_iID = $input;
        return $this->m_iID;
    }
    
    public function Username ($input = null){
        if (isset($input)) $this->m_strUsername = $input;
        return $this->m_strUsername;
    }
    
    public function MacAddress ($input = null){
        if (isset($input)) $this->m_strMac = $input;
        return $this->m_strMac;
    }
    
    public function Password ($input = null){
        if (isset($input)) $this->m_strPassword = $input;
        return $this->m_strPassword;
    }
    
    public function SSID ($input = null){
        if (isset($input)) $this->m_strSSID = $input;
        return $this->m_strSSID;
    }
    
    public function Facebook ($input = null){
        if (isset($input)) $this->m_strFacebook = $input;
        return $this->m_strFacebook;
    }
    
    public function Name ($input = null){
        if (isset($input)) $this->m_strName = $input;
        return $this->m_strName;
    }
    
    public function PicLocation ($input = null){
        if (isset($input)) $this->m_strPicLoc = $input;
        return $this->m_strPicLoc;
    }
    
    public function Status ($input = null){
        if (isset($input)) $this->m_strStatus = $input;
        return $this->m_strStatus;
    }
    
    public function TotalPoints ($input = null){
        if (isset($input)) $this->m_iTotalPoints = $input;
        return $this->m_iTotalPoints;
    }
    
    public function LastLocation ($input = null){
        if (isset($input)) $this->m_strLastLoc = $input;
        return $this->m_strLastLoc;
    }
    
    public function Device ($input = null){
        if (isset($input)) $this->m_strDevice = $input;
        return $this->m_strDevice;
    }
    
    public function GamesFinished ($input = null){
        if (isset($input)) $this->m_iGamesFin = $input;
        return $this->m_iGamesFin;
    }  
    
    
}

?>