<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class UpdateProfile {
    
    // RETURN CODES:
    // 0  = success
    // -1 = no user
    // -2 = number of fields and values not equal
    // -3 = cannot update the field given
    
    public static function Execute ($username, $aFields, $aValues){
        // Check to make sure the user inputted the same amount of fields and values
        if (count($aFields) != count($aValues)) return -2;
        
        // Check to make sure the user exists
        $user = DB_Controller::GetUserByUsername($username);
        if (!isset($user)) return -1;
        
        DB_Controller::Log($user->MacAddress(), "Update Profile");
        
        // Cycle through the fields and update the user's information
        $fieldsCount = count($aFields);
        for ($i = 0; $i < $fieldsCount; $i++)
        {
            $field = $aFields[$i];
            $value = $aValues[$i];
            
            if (strcasecmp($field,"MAC_Address") == 0)
            {
                $user->MacAddress($value);
            }
            else if (strcasecmp($field,"Facebook_Email") == 0)
            {
                $user->Facebook($value);
            }
            else if (strcasecmp($field,"Name") == 0)
            {
                $user->Name($value);
            } else {
                return -3;
            }
        }
        DB_Controller::UpdateUser($user);
        
        return 0;
    }
}

?>