<?php

class Point {
    
	public $m_iGameID;
    public $m_iUserID;
    public $m_iPoints;
    public $m_strIsActive;
    
    public function __construct($aValues = null){
        if (isset($aValues)){
            $this->m_iGameID = $aValues['gameid'];
            $this->m_iUserID = $aValues['userid'];
            $this->m_iPoints = $aValues['points'];
            $this->m_strIsActive = $aValues['isactive'];
        }
    }
    
    public function GameID ($input = null){
        if (isset($input)) $this->m_iGameID = $input;
        return $this->m_iGameID;
    }
    
    public function UserID ($input = null){
        if (isset($input)) $this->m_iUserID = $input;
        return $this->m_iUserID;
    }
    
    public function Points ($input = null){
        if (isset($input)) $this->m_iPoints = $input;
        return $this->m_iPoints;
    }

    public function IsActive ($input = null){
        if (isset($input)) $this->m_strIsActive = $input;
        return $this->m_strIsActive;
    }
}

?>