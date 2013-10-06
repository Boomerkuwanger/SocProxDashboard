<?php

require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/ChallengeAcceptance.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class ConfirmChallenge {
	
	private static $m_aChallengeAcceptances;
    
    // RETURN NUMBERS:
    //  0 = good!
    // -1 = there is no user associated with that MAC address
    // -2 = there is no challenge instance
	
	public static function Execute ($macID, $iID, $input){
	    // Get the user
		$user = DB_Controller::GetUserByMac($macID);
        if (!isset($user)) return -1;
		
        // Get the challenge acceptance for the challenge instance
		$aChallengeAcceptances = DB_Controller::GetChallengeInstanceAcceptances($iID);
        if (!isset($aChallengeAcceptances)) return -2;
        $strStatus = "active";
        $strInstAccept = "";
        foreach ($aChallengeAcceptances as $challengeAcceptance) {
            if ($challengeAcceptance->UserID() == $user->ID()) {
                // This challenge is associated with the user, so update the response in the database
                $challengeAcceptance->Accepts($input);
            
                // Update the acceptance of the challenge
                DB_Controller::UpdateChallengeAcceptance($challengeAcceptance);
            }
            
            if ($challengeAcceptance->Accepts() == "denied") {
                $strStatus = "denied";
            } else if ($challengeAcceptance->Accepts() == "pending") {
                $strStatus = "pending";
            }
            
            // Add on to the challenge instance acceptance string
            if ($strInstAccept == "") {
                $strInstAccept .= $challengeAcceptance->UserID() . ":" . $challengeAcceptance->Accepts();
            } else {
                $strInstAccept .= ", " . $challengeAcceptance->UserID() . ":" . $challengeAcceptance->Accepts();
            }
        }
        
        // Set the new status of the challenge instance
        $aChallengeAcceptances[0]->Instance()->Status($strStatus);
        $aChallengeAcceptances[0]->Instance()->Accepts($strInstAccept);
		
		self::$m_aChallengeAcceptances = $aChallengeAcceptance;
		
        // Update the challenge instance to reflect the new status
        DB_Controller::UpdateChallengeInstance($aChallengeAcceptances[0]->Instance());
        
        DB_Controller::Log($iID.' '.$macID.' '.$input, "update challenge acceptance");
        return 0;
	}
	
	public static function ChallengeAcceptances(){
		return self::$m_aChallengeAcceptances;
	}
}

?>