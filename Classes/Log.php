<?php

class Log {
    
    public $m_iID;
    public $m_strMacAddress;
    public $m_strFunctionCalled;
    public $m_tsTime;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iID = $aValues['logid'];
            $this->m_strMacAddress = $aValues['macaddress'];
            $this->m_strFunctionCalled = $aValues['functioncalled'];
            $this->m_tsTime = $aValues['time'];
            }
    }
    
    public function ID ($input = null){
        if (isset($input)) $this->m_iID = $input;
        return $this->m_iID;
    }
    
    public function MacAddress ($input = null){
        if (isset($input)) $this->m_strMacAddress = $input;
        return $this->m_strMacAddress;
    }
    
    public function FunctionCalled ($input = null){
        if (isset($input)) $this->m_strFunctionCalled = $input;
        return $this->m_strFunctionCalled;
    }
    
    public function Time ($input = null){
        if (isset($input)) $this->m_tsTime = $input;
        return $this->m_tsTime;
    }
}

?>