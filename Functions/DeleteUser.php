<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class DeleteUser {
	
	private static $m_oUser;
    public static function Execute ($userId)
    {	
		self::$m_oUser = self::prepareDeletedUser($userId);
		// Call database function
		//print_r(self::$m_oUser . "\n" . $m_oUser);
		DB_Controller::DeleteUser(self::$m_oUser);
        DB_Controller::Log("User", "Deleted User with Id = $m_oUser->ID()");
        return 0;
	}
//TODO: AFAM have all database functions use their private object variable instead of a random var
//TODO: AFAM Make sure that nothing is statically calling this and all other accessor methods
	public static function User(){
		return self::$m_oUser;
	}
	
	private function setUser($user){
		self::$m_oUser = $user;
	}
	//TODO: AFAM all Tables (Classes) will need a constructor that can copy another of its type
	//		this way, we can remove this mild helper function
	private static function prepareDeletedUser($Id){
		$user = new User();
		$user->ID($Id);
		return $user;
	}
}