<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/GlobalStats.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class GetGlobalStats {
    
    private static $m_oStats;
    
    // RETURN CODES:
    // 0  = success
    // -1 = internal error
    
    public static function Execute (){
        // Get the global statistics
        self::$m_oStats = DB_Controller::GetGlobalStats();
        if (!isset(self::$m_oStats)) return -1;
        
        DB_Controller::Log("", "Get Global Stats");
        return 0;
    }
    
    public static function Stats(){
        return self::$m_oStats;
    }
}

?>