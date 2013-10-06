<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class AddUser {
	private static $m_oUser;
    
    // RETURN CODES:
    // 1  = success, updated existing user
    // 0  = success
    // -1 = no user
	
	public static function Execute ($macaddress, $username, $password){
	    // First, see if the username already exists in the table
		$existingUsername = DB_Controller::GetUserByUsername($username);
		if (isset($existingUsername)){
		    // The user already exists - now check to see if it already has that mac address
			if ($existingUsername->MacAddress() != $macaddress){
			    // Nope - it doesn't have the mac address already. Let's see if someone else has that mac address
				$existingUserMac = DB_Controller::GetUserByMac($macaddress); // find out if the mac address belongs to another user
				if (isset($existingUserMac)) {
				    // Someone else has that mac address, so let's erase the MAC address from their account
					self::prepareExistingUser($existingUserMac, '', $existingUserMac->Username(), $existingUserMac->Password());
					DB_Controller::UpdateUser($existingUserMac); // erase the MAC address for the other user
				}
			}
            // Let's update the user based on the information given
			self::prepareExistingUser($existingUsername, $macaddress, $username, $password);
			DB_Controller::UpdateUser($existingUsername);
			self::$m_oUser = $existingUsername;
			DB_Controller::Log($macaddress, "register");
			return 1;
		}
        // See if the mac address belongs to another user, and if so erase it from them
		$existingUserMac = DB_Controller::GetUserByMac($macaddress); // find out if the mac address belongs to another user
		if (isset($existingUserMac)) {
			self::prepareExistingUser($existingUserMac, '', $existingUserMac->Username(), $existingUserMac->Password());
			DB_Controller::UpdateUser($existingUserMac); // erase the MAC address for the other user
		}
        // Create the new user and add them to the user DB table
		$user = self::prepareNewUser($macaddress, $username, $password);
		DB_Controller::AddUser($user);
		self::$m_oUser = DB_Controller::GetUserByMac($macaddress);
        if (!isset(self::$m_oUser)) {
            return -1;
        }
        DB_Controller::Log($macaddress, "register");
        return 0;
	}
	
	public static function User(){
		return self::$m_oUser;
	}
	
	private static function prepareExistingUser($existingUser, $macaddress, $username, $password){
		$existingUser->MacAddress($macaddress);
		$existingUser->Username($username);
		$existingUser->Password($password);
	}
	
	private static function prepareNewUser($macaddress, $username, $password){
		$user = new User();
		$user->MacAddress($macaddress);
		$user->Username($username);
		$user->Password($password);
		return $user;
	}
	
}

?>