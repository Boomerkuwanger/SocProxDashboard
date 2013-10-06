<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/ChallengeInstance.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class GetChallengeInstances {
    
    private static $m_aChallengeInstances;
    
    // RETURN CODES:
    // 0  = success
    // -1 = no user
    
    public static function Execute ($macAddress, $aStatuses){
        // Get the user for the challenge instances
        $user = DB_Controller::GetUserByMac($macAddress);
        if (!isset($user)) return -1;
        
        // Get the challenge instances
        self::$m_aChallengeInstances = DB_Controller::GetChallengeInstances($user, $aStatuses);
        
        DB_Controller::Log($macAddress, "Get Challenge Instances");
        
        return 0;
    }
    
    public static function ChallengeInstances(){
        return self::$m_aChallengeInstances;
    }
    
}

?>