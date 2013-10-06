<?php

class Verification {
    
    private $m_iID;
    private $m_strName;
    private $m_strDesc;
    private $m_strType;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iID = $aValues['verificationid'];
            $this->m_strName = $aValues['name'];
            $this->m_strDesc = $aValues['description'];
            $this->m_strType = $aValues['type'];
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
    
    public function Type ($input = null){
        if (isset($input)) $this->m_strType = $input;
        return $this->m_strType;
    }
    
    
}

?>