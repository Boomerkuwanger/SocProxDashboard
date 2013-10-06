<?php

class Payoff {
    
    private $m_iID;
    private $m_strName;
    private $m_strDesc;
    private $m_iReward;
    private $m_iValue;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iID = $aValues['payoffid'];
            $this->m_strName = $aValues['name'];
            $this->m_strDesc = $aValues['description'];
            $this->m_iReward = $aValues['isreward'];
            $this->m_iValue = $aValues['value'];
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
    
    public function IsReward ($input = null){
        if (isset($input)) $this->m_iReward = $input;
        return $this->m_iReward;
    }
    
    public function Value ($input = null){
        if (isset($input)) $this->m_iValue = $input;
        return $this->m_iValue;
    }
    
    
}

?>