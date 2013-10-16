<?php
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/IDB_Functions.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Activity.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Challenge.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/ChallengeInstance.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Game.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/GlobalStats.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Log.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Payoff.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/SocialMedia.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Verification.php';

class DB_Controller implements IDB_Functions {
	private static $m_oController;
    
    // NOTES:
    // GET functions - just about every function that returns information 1) gets the information  from the DB controller, then 2) creates a new object 
    //      based on the information to return to the caller
    // ACTION functions - calls the DB_Controller action functions to perform actions on the database
	
    // function that gets the correct database controller based on what the user has specified (aka, either a Google Spreadsheet or a MySQL database)
	private static function getDB(){
		if (!isset(self::$m_oController)){
			// require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/Spreadsheet_Functions.php';
			// self::$m_oController = new Spreadsheet_Functions();
			require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/MySQL_Function.php';
            		self::$m_oController = new MySQL_Functions();
		}
		return self::$m_oController;
	}
	
	public static function AddActivity($activity){
		self::getDB()->AddActivity($activity);
	}
	
	public static function AddGame($game){
		self::getDB()->AddGame($game);
	}
	
	public static function AddChallenge($challenge){
		self::getDB()->AddChallenge($challenge);
	}
		
	public static function AddUser($user){
		self::getDB()->AddUser($user);
	}
	
	public static function AddChallengeInstance($challengeInstance)
	{
		$lastID = self::getDB()->AddChallengeInstance($challengeInstance);
		return $lastID;
	}
	
	public static function AddChallengeAcceptance($challengeAcceptance)
	{
		self::getDB()->AddChallengeAcceptance($challengeAcceptance);
	}
    
    public static function AddPoints($points, $userId, $gameId){
        self::getDB()->AddPoints($points, $userId, $gameId);   
    }
	
    public static function DeleteUser($user){
		self::getDB()->DeleteUser($user);
	}
	
    public static function DeleteChallenge($challengeInstance){
		self::getDB()->DeleteChallenge($challengeInstance);
	}
	
	public static function DeleteChallengeInstance($challenge){
		self::getDB()->DeleteChallengeInstance($challenge);
	}
	 
	public static function DeleteGame($game){
		self::getDB()->DeleteGame($game);
	}
	
	public static function GetActivities($user){
		$aActivities = self::getDB()->GetActivities($user);
		if (!count($aActivities))	return NULL;
		$aResult = array();
		foreach ($aActivities as $activity){
			$aResult[] = new Activity($activity);
		}
		return $aResult;
	}
    
    public static function GetAllGame(){
        $aGames = self::getDB()->GetAllGame();
        if (!count($aGames)) return NULL;
        $aResult = array();
        foreach ($aGames as $game) {
            $aResult[] = new Game($game);
        }
        return $aResult;
    }
	
	public static function GetChallenges($user){
		$aChallenges = self::getDB()->GetChallenges($user);
		if (!count($aChallenges)){
			return NULL;
		}
		$aResult = array();
		foreach ($aChallenges as $challenges){
			foreach ($challenges as $challenge) {
				$aResult[] = new Challenge($challenge);
			}
		}
		return $aResult;
	}
    
    public static function GetChallengeInstances($user, $aStatuses) {
        // Get the actual instance data
        $aInstances = self::getDB()->GetChallengeInstances($user,  $aStatuses);
        if (!count($aInstances)) return NULL;
        
        // Get the information about the opponents involved in the challenge
        $aOpponentsDB = self::getDB()->GetOpponents($user);
        
        // Put the information into a more comparable array form
        $aOpponentsUsable = array();
        foreach ($aOpponentsDB as $opponent) {
            $aOpponentsUsable[$opponent['userid']] = $opponent['username'];
        }
        
        // Compile all information into the challengeInstance objects
        $aResult = array();
        foreach ($aInstances as $instance) {
            $aOppIDs = explode(";", $instance['userids']);
            $instanceObj = new ChallengeInstance($instance);
            $challenge = new Challenge($instance);
            $instanceObj->Challenge($challenge);
            $instanceObj->GameName($instance['gamename']);
            $instanceObj->Accepted($instance['useracceptance']);
            $aInstOpps = array();
            foreach ($aOppIDs as $id) {
                if ($id != $user->ID()) $aInstOpps[] = $aOpponentsUsable[$id];
            }
            $instanceObj->Opponents($aInstOpps);
            $aResult[] = $instanceObj;
        }
        
        return $aResult;
    }

    public static function GetChallengeInstance($user, $instanceID) {
        // Get the actual instance data
        $aInstances = self::getDB()->GetChallengeInstance($user, $instanceID);
        if (!count($aInstances)) return NULL;
        
        // Get the information about the opponents involved in the challenge
        $aOpponentsDB = self::getDB()->GetOpponents($user);
        
        // Put the information into a more comparable array form
        $aOpponentsUsable = array();
        foreach ($aOpponentsDB as $opponent) {
            $aOpponentsUsable[$opponent['userid']] = $opponent['username'];
        }
        
        // Compile all information into the challengeInstance objects
        $instance = $aInstances[0];
        $aOppIDs = explode(";", $instance['userids']);
        $instanceObj = new ChallengeInstance($instance);
        $challenge = new Challenge($instance);
        $instanceObj->Challenge($challenge);
        $instanceObj->GameName($instance['gamename']);
        $instanceObj->Accepted($instance['useracceptance']);
        $aInstOpps = array();
        foreach ($aOppIDs as $id) {
            if ($id != $user->ID()) $aInstOpps[] = $aOpponentsUsable[$id];
        }
        $instanceObj->Opponents($aInstOpps);
        
        return $instanceObj;  
    }
    
    public static function GetGame($gameName) {
        $aGame = self::getDB()->GetGame($gameName);
        if (!count($aGame)) return NULL;
        $result = new Game($aGame[0]);
        return $result;
    }
	
    public static function GetChallenge($challengeName) {
        $aGame = self::getDB()->GetGame($gameName);
        if (!count($aGame)) return NULL;
        $result = new Game($aGame[0]);
        return $result;
    }
    
    public static function GetGlobalStats() {
        $aGlobalStats = self::getDB()->GetGlobalStats();
        if (!count($aGlobalStats)) return NULL;
        $result = new GlobalStats($aGlobalStats[0]);
        return $result;
    }
    
    public static function GetLogs($iLimit, $strFunction, $strMAC) {
        $aLogs = self::getDB()->GetLogs($iLimit, $strFunction, $strMAC);
        if (!count($aLogs)) {
            return NULL;
        }    
        $aResult = array();
        foreach ($aLogs as $log) {
            $aResult[] = new Log($log);
        }
        return $aResult;
    }
    
    public static function GetPointsForUser($user) {
        $aPoints = self::getDB()->GetPointsForUser($user);
        if (!count($aPoints)) return NULL;
        $aResult = array();
        foreach ($aPoints as $point) {
            $aResult[] = new Point($point);
        }        
        return $aResult;
    }
    
    public static function GetStandings($limit, $gameID) {
        $aStandings = self::getDB()->GetStandings($limit, $gameID);
        if (!count($aStandings)) {
            return NULL;
        }
        $result = new Game();
        $result->Name($aStandings[0]['name']);
        $aRanks = array();
        foreach ($aStandings as $row) {
            $aRow = array();
            $aRow['username'] = $row['username'];
            $aRow['points'] = $row['points'];
            $aRanks[] = $aRow;
        }
        $result->Standings($aRanks);
        return $result;
    }
	
	public static function GetUsers(){
		$aUsers = self::getDB()->GetUsers();
		if (!count($aUsers))
		{
			echo "null";
			return NULL;
		}
		$aResult = array();
		foreach ($aUsers as $user){
			$aResult[] = new User($user);
		}
		return $aResult;
	}
    
    public static function GetUserStats($user) {
        $aGameStats = self::getDB()->GetUserGameStats($user);
        $aStatsResult = array();
        foreach ($aGameStats as $game) {
            $aStatsResult[] = new UserGameStats($game);
        }
        $result = new Stats();
        $result->User($user);
        $result->UserGameStats($aStatsResult);
        $aChallenges = self::getDB()->GetUserChallengesCompleted($user);
        if (count($aChallenges)) {
            $result->ChallengesCompleted($aChallenges[0]['count']);
        }
        return $result;
    }
	
	public static function GetChallengeByID($challengeID){
		$aUsers = self::getDB()->GetChallengeByID($challengeID);
		if (count($aUsers) > 0) return new Challenge($aUsers[0]);
		else return NULL;
	}
	
	public static function GetChallengeInstByID($challengeInstID){
		$aUsers = self::getDB()->GetChallengeInstByID($challengeInstID);
		if (count($aUsers) > 0) return new ChallengeInstance($aUsers[0]);
		else return NULL;
	}
	
	public static function GetPayoffByID($payoffID){
		$aUsers = self::getDB()->GetPayoffByID($payoffID);
		if (count($aUsers) > 0) return new Payoff($aUsers[0]);
		else return NULL;
	}
    
    public static function GetSocialMediaBySiteAndName($website, $webUsername) {
        $aSocialMedia = self::getDB()->GetSocialMediaBySiteAndName($website, $webUsername);
        if (count($aSocialMedia) >0) {
            $aResult = array();
            foreach ($aSocialMedia as $entry) {
                $aResult[] = new SocialMedia($entry);
            }
            return $aResult;
        }
        return NULL;
    }
	
	public static function GetUserByEmail($email){
		$aUsers = self::getDB()->GetUserByEmail($email);
		if (count($aUsers) > 0) return new User($aUsers[0]);
		else return NULL;
	}
	
	public static function GetUserByID($userID){
		$aUsers = self::getDB()->GetUserByID($userID);
		if (count($aUsers) > 0) return new User($aUsers[0]);
		else return NULL;
	}
	
	public static function GetUserByMac($MACAddress){
		$aUsers = self::getDB()->GetUserByMac($MACAddress);
		if (count($aUsers) > 0) return new User($aUsers[0]);
		else return NULL;
	}
    
    public static function GetUserByUsername($username){
        $aUsers = self::getDB()->GetUserByUsername($username);
        if (count($aUsers) > 0) return new User($aUsers[0]);
        else return NULL;
    }
    
    public static function GetUserIdFromSocialMedia($socialMediaUsername, $service){
        $aUserIds = self::getDB()->GetUserIdFromSocialMedia($socialMediaUsername, $service);
        if (count($aUserIds) > 0) return $aUserIds[0]['userid'];
        else return NULL;
    }
	
	public static function GetVerification($verifyID){
		$aVerification = self::getDB()->GetVerification($verifyID);
		if (!count($aVerification))	return NULL;
		$aResult = array();
		foreach ($aVerification as $verified){
			$aResult[] = new Verification($verified[0]);
		}
		return $aResult;
	}
	
	public static function GetChallengeInstanceAcceptances($challengeInstanceID){
		$aAcceptances = self::getDB()->GetChallengeInstanceAcceptances($challengeInstanceID);
		if (!count($aAcceptances)) return NULL;
		$aResult = array();
		foreach ($aAcceptances as $acceptance){
		    $acceptanceObj = new ChallengeAcceptance($acceptance);
            $instance = new ChallengeInstance($acceptance);
            $acceptanceObj->Instance($instance);
			$aResult[] = $acceptanceObj;
		}
		return $aResult;
	}
	
	public static function GetChallengeInstanceAcceptance($challengeInstanceID, $userID){
		$aAcceptances = self::getDB()->GetChallengeInstanceAcceptance($challengeInstanceID, $userID);
		if (!count($aAcceptances)) return NULL;
		foreach ($aAcceptances as $acceptances){
			$result = new ChallengeAcceptance($acceptances);
		}
		return $result;
	}
    
    public static function LinkUser($website, $webUsername, $userid){
        self::getDB()->LinkUser($website, $webUsername, $userid);
    }
    
    public static function Log($MACAddress, $functionName){
        self::getDB()->Log($MACAddress, $functionName);
    }
    
    public static function UnsetMacAddressForOthers($macAddress, $username){
        self::getDB()->UnsetMacAddressForOthers($macAddress, $username);   
    }
	
	public static function UpdateUser($existingUser){
		self::getDB()->UpdateUser($existingUser);
	}
	
	public static function UpdateChallengeInstance($existingChallengeInstance){
		self::getDB()->UpdateChallengeInstance($existingChallengeInstance);
	}
	
	public static function UpdateChallengeAcceptance($existingChallengeAcceptance){
		self::getDB()->UpdateChallengeAcceptance($existingChallengeAcceptance);
	}
	
	public static function PrintEverything(){
		self::getDB()->PrintEverything();
	}
	
}

?>