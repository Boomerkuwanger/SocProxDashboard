<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/ChallengeInstance.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class RefreshChallengeInstance {
	
	private static $m_oChallengeInstance;
	
	public static function Execute ($macID, $iID){
		self::$m_oChallengeInstance = DB_Controller::GetChallengeInstByID($iID);
		$challengeInstance = self::$m_oChallengeInstance;
		// $challengeInstance = ChallengeInstance();
		$user = DB_Controller::GetUserByMac($macID);
		// OLD$accepts = $challengeInstance->Accepts();
		$status = $challengeInstance->Status();
		
		if ((strcmp($status, 'complete') == 0) || (strcmp($status, 'deleted') == 0))
		{
			DB_Controller::Log($iID.' '.$macID.' '.$status, "challenge status, no update");
			return 0;
		}
		
		// Parse the accepts and denies
		$parsedUserConfirms = DB_Controller::GetChallengeInstanceAcceptances($iID);
		
		// If there are any denies, change challenge's status accordingly + return
		foreach ($parsedUserConfirms as $parsedUserConfirm)
		{
			if (strcmp($parsedUserConfirm->Accepts(), 'deny') == 0)
			{
				$newStatus = 'denied';
				$challengeInstance->Status($newStatus);
				DB_Controller::UpdateChallengeInstance($challengeInstance);
				DB_Controller::Log($iID.' '.$macID.' '.$newStatus, "challenge status");
				return 0;
			}
		}
		
		// Compare users that accepted with users that are part of challenge
		// If all users accepted, then compare challenge
		$usersInChallengeStr = $challengeInstance->UserIDs();
		$usersInChallenge = explode(';', $usersInChallengeStr);
		foreach ($usersInChallenge as $userID)
		{
			$found = False;
			foreach ($parsedUserConfirms as $parsedUserConfirm)
			{
				if (strcmp($parsedUserConfirm->Accepts(), 'accept') == 0)
				{
					if (strcmp($parsedUserConfirm->UserID(), $userID) == 0)
					{
						$found = True;
					}
				}
			}
			if (!$found)
			{
				$newStatus = 'pending';
				$challengeInstance->Status($newStatus);
				DB_Controller::UpdateChallengeInstance($challengeInstance);
				DB_Controller::Log($iID.' '.$macID.' '.$newStatus, "challenge status");
				return 0;
			}
		}
		
		$newStatus = 'active';
		$challengeInstance->Status($newStatus);
		DB_Controller::UpdateChallengeInstance($challengeInstance);
        DB_Controller::Log($iID.' '.$macID.' '.$newStatus, "challenge status");
        return 0;
	}
	
	public static function ChallengeInstance(){
		return self::$m_oChallengeInstance;
	}
}

?>