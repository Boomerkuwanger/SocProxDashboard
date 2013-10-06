<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class GetUsers {
	
	private static $m_aUsers;
	
	// RETURN CODES:
	// 0  = success
	// -1 = no user
	
	public static function Execute (){
		$users = DB_Controller::GetUsers();
		if (!isset($users)) return -1;
		self::$m_aUsers = $users;
        
        DB_Controller::Log("", "Get All Users");
        return 0;
	}
	
	public static function Users(){
		return self::$m_aUsers;
	}
}

?>