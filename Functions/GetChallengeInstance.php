<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/ChallengeInstance.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class GetChallengeInstance {
    
    private static $m_oChallengeInstance;
    
    // RETURN CODES:
    // 0  = success
    // -1 = no user
    
    public static function Execute ($macAddress, $instanceID){
        // Get the user for the challenge instance
        $user = DB_Controller::GetUserByMac($macAddress);
        if (!isset($user)) return -1;
        
        // Get the challenge instance
        self::$m_oChallengeInstance = DB_Controller::GetChallengeInstance($user, $instanceID);
        
        DB_Controller::Log($macAddress, "Get Challenge Instances");
        
        return 0;
    }
    
    public static function ChallengeInstance(){
        return self::$m_oChallengeInstance;
    }
    
}

?>