<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Log.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class GetLogs {
    
    private static $m_aLogs;
    private static $m_iLimit = 50;
    private static $m_strFunction = "";
    private static $m_strMAC = "";
    
    // RETURN CODES:
    // 0  = success
    
    public static function Execute (){
        // Get most recent logs from the database and return them
        self::$m_aLogs = DB_Controller::GetLogs(self::$m_iLimit, self::$m_strFunction, self::$m_strMAC);
        
        DB_Controller::Log("", "Get All Logs");
        return 0;
    }
    
    public static function FunctionCalled($m_strFunction = null) {
        if(isset($m_strFunction)) self::$m_strFunction = $m_strFunction;
        return self::$m_strFunction;
    }
    
    public static function Limit($m_iLimit = null) {
        if(isset($m_iLimit) && is_numeric($m_iLimit)) {
            self::$m_iLimit = $m_iLimit;
        }
        return self::$m_iLimit;
    }
    
    public static function Logs(){
        return self::$m_aLogs;
    }
    
    public static function Mac($m_strMAC = null) {
        if(isset($m_strMAC)) self::$m_strMAC = $m_strMAC;
        return self::$m_strMAC;
    }
}

?>