<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class LinkUser {
    
    private static $m_oUser;
    
    // RETURN CODES:
    // 0  = success
    // -1 = no user
    // -2 = username already registered for that site
    
    public static function Execute ($website, $webUsername, $socUsername){
        // Check to make sure the user exists in the DB
        $user = DB_Controller::GetUserByUsername($socUsername);
        if (!isset($user)) return -1;
        
        // Check to make sure no other usernames are registered for that site already
        $aSocialMedia = DB_Controller::GetSocialMediaBySiteAndName($website, $webUsername);
        if (count($aSocialMedia) > 0) {
            return -2;
        }
        
        // Everything is good to go - link the user with that social media website
        DB_Controller::LinkUser($website, $webUsername, $user->ID());
        
        DB_Controller::Log($user->MacAddress(), "Link User");
        return 0;        
    }
    
}

?>