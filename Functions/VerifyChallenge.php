<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Activity.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/ChallengeInstance.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Payoff.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class VerifyChallenge {
	
	private static $m_oVerifierUser;
	private static $m_oChallengeInstance;
	private static $m_aVerifiedUsers;
	private static $m_oChallenge;
	private static $m_oPayoff;
	private static $m_aActivities;
	
	// RETURN NUMBERS:
	//  0 = good!
	// -1 = there is no user that is verifying the action (theoretically should never happen)
	// -2 = there is no challenge instance
	// -3 = there are no users associated with the challenge
	
	public static function Execute ($challengeInstance, $macAddress, $input){
		self::$m_oVerifierUser = DB_Controller::GetUserByMac($macAddress);
		if (!isset(self::$m_oVerifierUser)) return -1;
		self::$m_oChallengeInstance = DB_Controller::GetChallengeInstByID($challengeInstance); 
		if (!isset(self::$m_oChallengeInstance)) return -2;
		$userIDs = self::$m_oChallengeInstance->UserIDs();
		if (!isset($userIDs)) return -3;
		self::setVerifiedUsers($userIDs);
		self::$m_oChallenge = DB_Controller::GetChallengeByID(self::$m_oChallengeInstance->ChallengeID());
		
		$ifSuccess = (strcmp($input, 'success') == 0);
		$ifFail = (strcmp($input, 'fail') == 0);
		// If success, use P1ID
		if ($ifSuccess)
		{
			self::$m_oPayoff = DB_Controller::GetPayoffByID(self::$m_oChallenge->P1ID());
		}
		
		// If fail, use P2ID
		if ($ifFail)
		{
			self::$m_oPayoff = DB_Controller::GetPayoffByID(self::$m_oChallenge->P2ID());
		}
		
		// Add the activities to the activity log
		self::prepareActivities();
		foreach (self::$m_aActivities as $activity){
			DB_Controller::AddActivity($activity);
            
            // Add points to the user's total
            DB_Controller::AddPoints(self::$m_oPayoff->Value(), $activity->UserID(), $activity->GameID());
        }
        
        // Set the result of the challenge to completed
        self::$m_oChallengeInstance->Status("completed");
        DB_Controller::UpdateChallengeInstance(self::$m_oChallengeInstance);
        
        DB_Controller::Log($macAddress, "Verify");
		return 0;
	}
	
	public static function User(){
		return self::$m_oUser;
	}
	
	private static function prepareActivities(){
		$i = 0;
		foreach (self::$m_aVerifiedUsers as $user){
			self::$m_aActivities[$i] = new Activity();
			self::$m_aActivities[$i]->UserID($user->ID());
			self::$m_aActivities[$i]->GameID(self::$m_oChallenge->GameID());
			self::$m_aActivities[$i]->ChallengeInstID(self::$m_oChallengeInstance->ID());
			self::$m_aActivities[$i]->Time(date('Y-m-d'));
			self::$m_aActivities[$i]->Points(self::$m_oPayoff->Value());
			self::$m_aActivities[$i]->PayoffID(self::$m_oPayoff->ID());
			self::$m_aActivities[$i]->VerifiedBy(self::$m_oVerifierUser->ID());
			self::$m_aActivities[$i]->VerifiedID(1);
			self::$m_aActivities[$i]->Result("");
			$i++;
		}
	}
	
	private static function setVerifiedUsers($userIDs){
		$aUserIDs = explode(";", $userIDs);
		foreach ($aUserIDs as $userID){
			self::$m_aVerifiedUsers[] = DB_Controller::GetUserByID($userID);
		}
	}
	
}

?>