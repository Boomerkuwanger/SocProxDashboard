<?php
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/Spreadsheet_Controller.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/IDB_Functions.php';

class Spreadsheet_Functions implements IDB_Functions {
    
     // NOTE: The function of this class is to package the information given by the DB_Controller and make a spreadsheet query for it, which 
    //      can be called by the spreadsheet controller.
	
	private static $m_oController;
	
	private static function getDB(){
		if (!isset(self::$m_oController)) self::$m_oController = new Spreadsheet_Controller();
		return self::$m_oController;
	}
	
	public static function AddActivity($activity){
		$aToInsert = array();
		$aToInsert['activityid'] = self::getDB()->GetLastID('Activity');
        $aToInsert['userid'] = $activity->UserID();
        $aToInsert['gameid'] = $activity->GameID();
        $aToInsert['challengeinstid'] = $activity->ChallengeInstID();
        $aToInsert['time'] = $activity->Time();
        $aToInsert['points'] = $activity->Points();
        $aToInsert['payoffid'] = $activity->PayoffID();
        $aToInsert['verifiedby'] = $activity->VerifiedBy();
        $aToInsert['verifiedid'] = $activity->VerifiedID();
        $aToInsert['result'] = $activity->Result();
		self::getDB()->AddRow('Activity', $aToInsert);
	}
	public static function AddGame($game){
		$aToInsert = array();
		$aToInsert['gameid'] = self::getDB()->GetLastID('Game');
        $aToInsert['name'] = $game->Name();
        $aToInsert['description'] = $game->Description();
        $aToInsert['criteriatoplay'] = $game->CriteriaToPlay();
        $aToInsert['startdate'] = $game->StartDate();
        $aToInsert['enddate'] = $game->EndDate();
        $aToInsert['duration'] = $game->Duration();
        $aToInsert['winningpoints'] = $game->WinningPoints();
        $aToInsert['iterations'] = $game->NumIterations();
		self::getDB()->AddRow('Game', $aToInsert);
	}
	public static function AddChallenge($challenge){
		$aToInsert = array();
		$aToInsert['challengeid'] = self::getDB()->GetLastID('Challenge');
        $aToInsert['name'] = $challenge->Name();
        $aToInsert['instructions'] = $challenge->Instructions();
        $aToInsert['gameid'] = $challenge->GameID();
        $aToInsert['startdate'] = $challenge->StartDate();
        $aToInsert['enddate'] = $challenge->EndDate();
        $aToInsert['minplayers'] = $challenge->MinPlayers();
        $aToInsert['maxplayers'] = $challenge->MaxPlayers();
        $aToInsert['verificationid'] = $challenge->VerificationID();
		self::getDB()->AddRow('Challenge', $aToInsert);
	}
	public static function AddUser($user){
		$aToInsert = array();
		$aToInsert['macaddress'] = $user->MacAddress();
		$aToInsert['userid'] = self::getDB()->GetLastID('User');
		$aToInsert['facebookemail'] = $user->Facebook();
		$aToInsert['name'] = $user->Name();
		self::getDB()->AddRow('User', $aToInsert);
	}
    
    public static function AddPoints($points, $userId, $gameId){
        // TODO: Implement if going to use spreadsheet   
    }
	
	public static function AddChallengeInstance($challengeInstance)
	{
		$aToInsert = array();
		$lastID = self::getDB()->GetLastID('ChallengeInstance');
		$aToInsert['challengeinstanceid'] = $lastID;
		$aToInsert['challengeid'] = $challengeInstance->ChallengeID();
		$aToInsert['userids'] = $challengeInstance->UserIDs();
		$aToInsert['status'] = 'pending';
		self::getDB()->AddRow('ChallengeInstance', $aToInsert);
		return $lastID;
	}
	
	public static function AddChallengeAcceptance($challengeAcceptance)
	{
		$aToInsert = array();
		$aToInsert['challengeacceptanceid'] = self::getDB()->GetLastID('ChallengeAcceptance');
		$aToInsert['challengeinstanceid'] = $challengeAcceptance->ChallengeInstanceID();
		$aToInsert['userid'] = $challengeAcceptance->UserID();
		$aToInsert['accepts'] = $challengeAcceptance->Accepts();
		self::getDB()->AddRow('ChallengeAcceptance', $aToInsert);
	}

	public static function GetActivities($user){
		$aActivities = self::getDB()->GetRows('Activity', 'userid', $user->ID());
		return $aActivities;
	}
    
	public static function GetChallenges($user){
		$aPoints = self::getDB()->GetRows('Points', 'userid', $user->ID());
		if (!count($aPoints)) return NULL;
		$aChallenges = array();
		foreach ($aPoints as $point){
			$aChallenges[] = self::getDB()->GetRows('Challenge', 'gameid', $point['gameid']);
		}
		return $aChallenges;
	}
    
    public static function GetChallengeInstances($user, $aStatuses) {
        // TODO: implement if using the spreadsheet in the future
    }
    
    public static function GetChallengeInstance($user, $instanceID) {
        // TODO: implement if using the spreadsheet in the future
    }
    
    public static function GetOpponents($user) {
        // TODO: implement if using the spreadsheet in the future
    }
	
	public static function GetUsers(){
		$aUsers = self::getDB()->GetRowsNoPredicate('User');
		return $aUsers;
	}
	
	public static function GetAllUsers(){
		$aUsers = self::getDB()->GetRowsNoPredicate('User');
		return $aUsers;
	}
	
	public static function GetAllChallenges(){
		$aUsers = self::getDB()->GetRowsNoPredicate('Challenge');
		return $aUsers;
	}
	
	public static function GetAllLog(){
		$aUsers = self::getDB()->GetRowsNoPredicate('Log');
		return $aUsers;
	}
	
	public static function GetAllActivity(){
		$aUsers = self::getDB()->GetRowsNoPredicate('Activity');
		return $aUsers;
	}
	
	public static function GetAllChallengeInstance(){
		$aUsers = self::getDB()->GetRowsNoPredicate('ChallengeInstance');
		return $aUsers;
	}
	
	public static function GetAllChallengeAcceptance(){
		$aUsers = self::getDB()->GetRowsNoPredicate('ChallengeAcceptance');
		return $aUsers;
	}
	
	public static function GetAllGame(){
		$aUsers = self::getDB()->GetRowsNoPredicate('Game');
		return $aUsers;
	}
	
	public static function GetAllPayoffs(){
		$aUsers = self::getDB()->GetRowsNoPredicate('Payoffs');
		return $aUsers;
	}
	
	public static function GetAllVerification(){
		$aUsers = self::getDB()->GetRowsNoPredicate('Verification');
		return $aUsers;
	}
	
	public static function GetAllParameters(){
		$aUsers = self::getDB()->GetRowsNoPredicate('Parameters');
		return $aUsers;
	}
	
	public static function GetAllPoints(){
		$aUsers = self::getDB()->GetRowsNoPredicate('Points');
		return $aUsers;
	}
    
    public static function GetChallengeInstanceAcceptances($challengeInstanceID) {
        // TODO: implement if using the spreadsheet in the future
    }
    
    public static function GetLogs($iLimit, $strFunction, $strMAC) {
        // TODO: implement if using the spreadsheet in the future
    }
    
    public static function GetStandings($limit, $gameID) {
        // TODO: implement if using the spreadsheet in the future   
    }
	
	public static function GetPayoffByID($payoffID){
		$aUsers = self::getDB()->GetRows('Payoffs', 'payoffid', $payoffID);
		return $aUsers;
	}
	
	public static function GetChallengeByID($challengeID){
		$aUsers = self::getDB()->GetRows('Challenge', 'challengeid', $challengeID);
		return $aUsers;
	}
	
	public static function GetChallengeInstByID($challengeInstID){
		$aUsers = self::getDB()->GetRows('ChallengeInstance', 'challengeinstanceid', $challengeInstID);
		return $aUsers;
	}
    
    public static function GetGame($gameName) {
        // TODO: implement if using the spreadsheet in the future 
    }
    
    public static function GetGlobalStats() {
        // Implement if spreadsheet used
    }
    
    public static function GetPointsForUser($user) {
        // TODO: implement if using the spreadsheet in the future 
    }
	
	public static function GetUserByEmail($email){
		$aUsers = self::getDB()->GetRows('User', 'facebookemail', $email);
		return $aUsers;
	}
	
	public static function GetUserByID($userID){
		$aUsers = self::getDB()->GetRows('User', 'userid', $userID);
		return $aUsers;
	}
	
	public static function GetUserByMac($MACAddress){
		$aUsers = self::getDB()->GetRows('User', 'macaddress', $MACAddress);
		return $aUsers;
	}
    
    public static function GetUserByUsername($username){
        $aUsers = self::getDB()->GetRows('User', 'username', $username);
        return $aUsers;
    }
    
    public static function GetUserIdFromSocialMedia($socialMediaUsername, $service){}
	
	public static function GetVerification($verifyID){
		$aVerification = self::getDB()->GetRows('Verification', 'verificationid', $verifyID);
		return $aVerification;
	}
	
	public static function GetChallengeInstanceAcceptances($challengeInstanceID){
		$aAcceptances[] = self::getDB()->GetRows('ChallengeAcceptance', 'challengeinstanceid', $challengeInstanceID);
		return $aAcceptances;
	}
	
	public static function GetChallengeInstanceAcceptance($challengeInstanceID, $userID){
		// echo 'Inputs: '.$challengeInstanceID.', '.$userID.'<br>';
		$aAcceptances[] = self::getDB()->GetRows('ChallengeAcceptance', 'challengeinstanceid', $challengeInstanceID);
		$result = array();
		foreach ($aAcceptances as $acceptances)
		{
			foreach ($acceptances as $acceptance)
			{
				// echo 'Acceptance: '.$acceptance['challengeacceptanceid'].', '.$acceptance['challengeinstanceid'].', '.$acceptance['userid'].', '.$acceptance['accepts'].'<br>';
				// echo 'Comparing \''.$acceptances['userid'].'\' with \''.$userID.'\'<br>';
				if (strcmp($acceptance['userid'], $userID) == 0)
				{
					$result[] = $acceptance;
					// echo 'Adding Acceptance: '.$acceptance['challengeacceptanceid'].', '.$acceptance['challengeinstanceid'].', '.$acceptance['userid'].', '.$acceptance['accepts'].'<br>';
				}
			}
		}
		// echo 'Count of $result: '.count($result).'<br>';
		return $result;
	}
    
    public static function GetSocialMediaBySiteAndName($website, $webUsername) {
        // TODO: Implement if going back to spreadsheet
    }

    public static function Log($MACAddress, $functionName){
        $aToInsert = array();
        $aToInsert['logid'] = self::getDB()->GetLastID('Log');
        $aToInsert['macaddress'] = $MACAddress;
        $aToInsert['functioncalled'] = $functionName;
        $aToInsert['time'] = date('Y-m-d H:i:s');
        self::getDB()->AddRow('Log', $aToInsert);
    }

	public static function UpdateUser($existingUser){
		$aToInsert = array();
		$aToInsert['macaddress'] = $existingUser->MacAddress();
		$aToInsert['userid'] = $existingUser->ID();
		$aToInsert['facebookemail'] = $existingUser->Facebook();
		$aToInsert['name'] = $existingUser->Name();
		$aToInsert['username'] = $existingUser->Username();
		self::getDB()->UpdateRow('User', $existingUser->ID() , $aToInsert);
	}

	public static function UpdateChallengeInstance($existingChallengeInstance){
		$aToInsert = array();
		$aToInsert['challengeinstanceid'] = $existingChallengeInstance->ID();
		$aToInsert['challengeid'] = $existingChallengeInstance->ChallengeID();
		$aToInsert['userids'] = $existingChallengeInstance->UserIDs();
		$aToInsert['status'] = $existingChallengeInstance->Status();
		$aToInsert['accepts'] = $existingChallengeInstance->Accepts();
		self::getDB()->UpdateRow('ChallengeInstance', $existingChallengeInstance->ID() , $aToInsert);
	}

	public static function UpdateChallengeAcceptance($existingChallengeAcceptance){
		$aToInsert = array();
		$aToInsert['challengeacceptanceid'] = $existingChallengeAcceptance->ID();
		$aToInsert['challengeinstanceid'] = $existingChallengeAcceptance->ChallengeInstanceID();
		$aToInsert['userid'] = $existingChallengeAcceptance->UserID();
		$aToInsert['accepts'] = $existingChallengeAcceptance->Accepts();
		// echo 'Updating: '.$aToInsert['challengeacceptanceid'].', '.$aToInsert['challengeinstanceid'].', '.$aToInsert['userid'].', '.$aToInsert['accepts'];
		self::getDB()->UpdateRow('ChallengeAcceptance', $existingChallengeAcceptance->ID() , $aToInsert);
	}
	
	public static function PrintEverything(){
		$aPoints = self::getDB()->GetRows('User', 'userid', 'blah');
		$aPoints = self::getDB()->GetRows('Challenge', 'userid', 'blah');
		$aPoints = self::getDB()->GetRows('Activity', 'userid', 'blah');
		$aPoints = self::getDB()->GetRows('Game', 'userid', 'blah');
		$aPoints = self::getDB()->GetRows('Payoffs', 'userid', 'blah');
		$aPoints = self::getDB()->GetRows('Verification', 'userid', 'blah');
		$aPoints = self::getDB()->GetRows('Parameters', 'userid', 'blah');
		$aPoints = self::getDB()->GetRows('Points', 'userid', 'blah');
	}
    
    public static function UnsetMacAddressForOthers($macAddress, $username){
        // TODO: Implement if switching to Google Spreadsheet again   
    }
	
}

?>