<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class Login {
    
    private static $m_oUser;
    
    // RETURN CODES:
    //  0 = success
    // -1 = no user
    // -2 = no social media connection
    // -3 = no password given
    // -4 = password does not match
    // -5 = internal error (the userid in the social media table doesn't exist in the user table somehow!)
    
    public static function Execute ($macAddress, $website, $site_username, $password = null){
        if ($website == "socprox") {
            // If the user is a socprox user, we must use the password they supplied
            if (!isset($password)) return -3;
            self::$m_oUser = DB_Controller::GetUserByUsername($site_username);
            if (!isset(self::$m_oUser)) return -1;
            // User must have entered the correct password!
            if ($password != self::$m_oUser->Password()) return -4;
        } else {
            // We are getting the user from their social media alias
            $userid = DB_Controller::GetUserIdFromSocialMedia($site_username, $website);
            if (!isset($userid)) return -2;
            self::$m_oUser = DB_Controller::GetUserByID($userid);
            if (!isset(self::$m_oUser)) return -5;
        }
        // We need the mac address of the user. If the user is logging in from a different phone, then we need
        //  to update the mac address from that phone so that the rest of the game functionality will work
        if ($macAddress != self::$m_oUser->MacAddress()) {
            self::$m_oUser->MacAddress($macAddress);
            DB_Controller::UpdateUser(self::$m_oUser);
        }
        // If another user has that mac address saved as their own, we need to unset it
        DB_Controller::UnsetMacAddressForOthers($macAddress, self::$m_oUser->Username());
        DB_Controller::Log(self::$m_oUser->MacAddress(), "Login");
        return 0;
    }
    
    public static function User(){
        return self::$m_oUser;
    }
}

?>