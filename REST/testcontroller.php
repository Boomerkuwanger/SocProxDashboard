<?php
require_once 'ChallengeInstanceChallenge.php';
require_once '../Functions/AddUser.php';
require_once '../Functions/AddGame.php';
require_once '../Functions/AddChallenge.php';
require_once '../Functions/GetActiveChallenges.php';
require_once '../Functions/GetGames.php';
require_once '../Functions/GetLogs.php';
require_once '../Functions/VerifyChallenge.php';
require_once '../Functions/AddChallengeInstance.php';
require_once '../Functions/ConfirmChallenge.php';
require_once '../Functions/RefreshChallengeInstance.php';
require_once '../Functions/GetChallengeInstances.php';
require_once '../Functions/GetChallengeInstance.php';
require_once '../Functions/GetGlobalStats.php';
require_once '../Functions/GetStandings.php';
require_once '../Functions/GetUserStats.php';
require_once '../Functions/GetUsers.php';
require_once '../Functions/LinkUser.php';
require_once '../Functions/Login.php';
require_once '../Functions/UpdateProfile.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/DB_Controller.php';

class Error
{
	public $success = false;    
	public $message;
	public $code;
	public $body;

	public function __construct($code = null, $message = null, $body = null)
	{
	    if (isset($code)) $this->code = $code;
        if (isset($message)) $this->message = $message;
        if (isset($body)) $this->body = $body;
	}
}

class Success
{
    public $success = true;    
    public $message = "Success!";
    public $code = 0;
    public $body;

    public function __construct($body = null, $message = null)
    {
        if (isset($message)) $this->message = $message;
        if (isset($body)) $this->body = $body;
    }
}

class TestController
{
    /**
     * Returns a JSON string object to the browser when hitting the root of the domain
     *
     * @url GET /
     */
    public function test()
    {
        return "Hello World";
    }
    
    /**
     * Login user 
     *
     * @url GET /login/:mac/:website/:site_username/
     * @url GET /login/:mac/:website/:site_username/:password
     */
    public function login($mac = null, $website = null, $site_username = null, $password = null)
    {
        if ($website && $site_username)
        {
            if ($website == 'socprox' && !$password)  print 'Usage: /login/:website/:site_username/:password';
            $result = Login::Execute($mac, $website, $site_username, $password);
            if ($result == 0) {
                $user = Login::User();
                return new Success($user);
            } else if ($result == -1) {
				$error = new Error(1, "No such user exists");
				return $error;
			}
            else if ($result == -2) {
				$error = new Error(2, 'No such ' . $website . ' username exists');
				return $error;
			} 
            else if ($result == -4) {
				$error = new Error(4, 'Incorrect password');
				return $error;
			}
            else if ($result == -5) {
				$error = new Error(5, 'Internal error');
				return $error;
			}
        }
        else
        {
            return new Error(100,'Usage: /login/:website/:site_username/');
        }
    }
    
    /**
     * Register an alias
     *
     * @url GET /registerAlias/:website/:site_username/:socprox_username
     * @url GET /registerAlias
     */
    public function registerAlias($website = null, $site_username = null, $socprox_username = null)
    {
        if ($website && $site_username && $socprox_username) 
        {
            $result = LinkUser::Execute($website, $site_username, $socprox_username);
            if ($result == -1) {
                return new Error(5, 'User does not exist');
            }
            else if ($result == -2) {
                return new Error(5, "Username is already registered for that website!"); 
            } else return new Success('Successfully registered!');
        }
        else 
        {
            return new Error(100, 'Usage: /registerAlias/website/site_username/socprox_username/');
        }
    }
    
    /**
     * Register a MAC Address
     *
     * @url GET /register/:macID/:username/:password
	 * @url GET /register
     */
    public function register($macID = null, $username = null, $password = null)
    {
		if ($macID && $username && $password)
		{
			$result = AddUser::Execute($macID, $username, $password);
            if ($result == -1) {
                $error = new Error(1, "Problem retrieving the created user.");
                return $error;
            }
			$user = AddUser::User();
	        return new Success($user);
		}
		else
		{
			return new Error(100, 'Usage: /register/MACAddress');
		}
    }
	/**
     * Adds Game
     *
	 * @url GET /addGame/:name/:description/:criteria/:points
	 * @url GET /addGame/:name/:description/:points
     */
	public function addGame($name = null, $description = null, $criteria = null, $points = null)
	{
		if($name && $description && $points)
		{
			$start = date("m.d.y");
			$end = date("m.d.y");
			$result = AddGame::Execute($name, $description, $criteria, $start, $end, $points);
			if ($result == -1) 
			{
                $error = new Error(1, "Problem retrieving the created game.");
                return $error;
            }
			$game = AddGame::Game();
	        return new Success($game);
		}
		else
		{
			return new Error(100, 'Usage: /addGame/:name/:description/:criteria/:points');
		}
	}
	/**
     * Adds Challenge
     *
	 * @url GET /addChallenge/:name/:instructions/:gameid/:minplayers/:maxplayers/:verificationid
     */
	public function addChallenge($name = null, $instructions = null, $gameid= null, $minplayers= null, $maxplayers = null, $verificationid = null)
	{
		if($name && $instructions && $gameid && $minplayers && $maxplayers && $verificationid)
		{
			$start = date("m.d.y");
			$end = date("m.d.y");
			$result = AddChallenge::Execute($name, $instructions, $gameid, $start, $end, $minplayers, $maxplayers, $verificationid);
			if ($result == -1) 
			{
                $error = new Error(1, "Problem retrieving the created game.");
                return $error;
            }
			$challenge = AddChallenge::Challenge();
	        return new Success($challenge);
		}
		else
		{
			return new Error(100, 'Usage: /addChallenge/:name/:instructions/:gameid/:minplayers/:maxplayers/:verificationid');
		}
	}
	/**
     * Lists challenges
     *
	 * @url GET /listChallenges/:mac1/:mac2
	 * @url GET /listChallenges/:mac1
     * @url GET /listChallenges
     */
    public function listChallenges($mac1 = null, $mac2 = null)
    {
        if ($mac1 && $mac2) {
            // Get the challenges from both users
            $challenges1 = GetActiveChallenges::Execute($mac1);
			$challenges2 = GetActiveChallenges::Execute($mac2);
			if ((count($challenges1) == 0) || (count($challenges2) == 0))
			{
				$error = new Error(1, "No challenges available");
				return $error;
			}
            // For each challenge, see which ones they have in common and add it to an available challenge array
			$availableChallenges = array();
			foreach ($challenges1 as $challenge1){
				foreach ($challenges2 as $challenge2)
				{
					if ($challenge1->ID() == $challenge2->ID())
					{
						$availableChallenges = array_values($availableChallenges);
						$availableChallenges[] = $challenge1;
					}
				}
			}
			$availableChallenges = array_values($availableChallenges);
			return new Success($availableChallenges);
        }
		else if ($mac1) {
			$challenges = GetActiveChallenges::Execute($mac1);
			if (count($challenges) == 0)
			{
				$error = new Error(1, "No challenges available");
				return $error;
			}
			return new Success($challenges);
		}
		else {
			return new Error(100, 'Usage: /listChallenges/mac1/mac2');
		}
    }
    
    /**
     * Gets all games
     *
     * @url GET /getAllGames
     */
    public function getAllGames()
    {
        GetGames::Execute();
        $games = GetGames::Games();
        return new Success($games);
    }
    
    /**
     * Gets the challenge
     *
	 * @url GET /getChallenge/:mac1/:mac2
	 * @url GET /getChallenge/:mac1
     * @url GET /getChallenge
     */
    public function getChallenge($mac1 = null, $mac2 = null)
    {
        if ($mac1 && $mac2) {
            // Get the challenges for both users
            $challenges1 = GetActiveChallenges::Execute($mac1);
			$challenges2 = GetActiveChallenges::Execute($mac2);
			if ((count($challenges1) == 0) || (count($challenges2) == 0))
			{
				$error = new Error(1, "No challenges available");
				return $error;
			}
            // Calculate the available challenges based on the ones the users have in common
			$availableChallenges = array();
			foreach ($challenges1 as $challenge1){
				foreach ($challenges2 as $challenge2)
				{
					if ($challenge1->ID() == $challenge2->ID())
					{
						$availableChallenges = array_values($availableChallenges);
						$availableChallenges[] = $challenge1;
					}
				}
			}
			$availableChallenges = array_values($availableChallenges);
			if (count($availableChallenges) == 0)
			{
				$error = new Error(1, "No challenges available");
				return $error;
			}
			$randNum = rand(0, count($availableChallenges) - 1);
			$chosenChallenge = $availableChallenges[$randNum];
			
			// Do some business about creating an instance
			$user1 = DB_Controller::GetUserByMac($mac1);
			$user2 = DB_Controller::GetUserByMac($mac2);
			$users = array();
			$users[] = $user1;
			$users[] = $user2;
			// OLD$userIDs = $user1->ID().";".$user2->ID();
			AddChallengeInstance::Execute($chosenChallenge->ID(), $users);
			$challengeInstance = AddChallengeInstance::ChallengeInstance();
			
			$challengeInstanceChallenge = new ChallengeInstanceChallenge();
			$challengeInstanceChallenge->ConvertFrom($chosenChallenge, $challengeInstance);
         	   	$challengeInstanceChallenge->Username1($user1->Username());
          		$challengeInstanceChallenge->Username2($user2->Username());
			return new Success($challengeInstanceChallenge);
        }
		else if ($mac1) {
			$challenges = GetActiveChallenges::Execute($mac1);
			
			if (count($challenges) == 0)
			{
				$error = new Error(1, "No challenges available");
				return $error;
			}

			$randNum = rand(0, count($challenges) - 1);
			$chosenChallenge = $challenges[$randNum];
			
			// Do some business about creating an instance
			$user1 = DB_Controller::GetUserByMac($mac1);
			$users = array();
			$users[] = $user1;
			AddChallengeInstance::Execute($chosenChallenge->ID(), $users);
			$challengeInstance = AddChallengeInstance::ChallengeInstance();
			
			$challengeInstanceChallenge = new ChallengeInstanceChallenge();
			$challengeInstanceChallenge->ConvertFrom($chosenChallenge, $challengeInstance);
			return new Success($challengeInstanceChallenge);
		}
		else {
			return new Error(100, 'Usage: /getChallenge/mac1/mac2');
		}
    }
	
	/**
     * Gets the challenge
     *
	 * @url GET /pushChallenge/:mac1/:mac2
	 * @url GET /pushChallenge/:mac1
     * @url GET /pushChallenge
     */
    public function pushChallenge($mac1 = null, $mac2 = null)
    {
        if ($mac1 && $mac2) {
            $challenges1 = GetActiveChallenges::Execute($mac1);
			$challenges2 = GetActiveChallenges::Execute($mac2);
			if ((count($challenges1) == 0) || (count($challenges2) == 0))
			{
				$error = new Error(1, "No challenges available");
				return $error;
			}
			$availableChallenges = array();
			foreach ($challenges1 as $challenge1){
				foreach ($challenges2 as $challenge2)
				{
					if ($challenge1->ID() == $challenge2->ID())
					{
						$availableChallenges = array_values($availableChallenges);
						$availableChallenges[] = $challenge1;
					}
				}
			}
			$availableChallenges = array_values($availableChallenges);
			if (count($availableChallenges) == 0)
			{
				$error = new Error(1, "No challenges available");
				return $error;
			}
			$randNum = rand(0, count($availableChallenges) - 1);
			$chosenChallenge = $availableChallenges[$randNum];
			
			// Do some business about creating an instance
			$user1 = DB_Controller::GetUserByMac($mac1);
			$user2 = DB_Controller::GetUserByMac($mac2);
			$users = array();
			$users[] = $user1;
			$users[] = $user2;
			// OLD$userIDs = $user1->ID().";".$user2->ID();
			AddChallengeInstance::Execute($chosenChallenge->ID(), $users);
			$challengeInstance = AddChallengeInstance::ChallengeInstance();
			
			$challengeInstanceChallenge = new ChallengeInstanceChallenge();
			$challengeInstanceChallenge->ConvertFrom($chosenChallenge, $challengeInstance);
            $challengeInstanceChallenge->Username1($user1->Username());
            $challengeInstanceChallenge->Username2($user2->Username());
			
			// Push notification to both devices about challenge
			$messageToPush = json_encode($challengeInstanceChallenge);
			$challengeInstanceID = $challengeInstanceChallenge->ID();
			$user1ID = $user1->ID();
			$user2ID = $user2->ID();
			$pushNotification = file_get_contents("http://www.cjcornell.com/bluegame/GCM/send_message_sp.php?socproxID={$user1ID},{$user2ID}&message=challengeInstanceID={$challengeInstanceID}");
			
			return new Success($challengeInstanceChallenge);
        }
		else if ($mac1) {
			$challenges = getActiveChallenges::Execute($mac1);
			if (count($challenges) == 0)
			{
				$error = new Error(1, "No challenges available");
				return $error;
			}
			$randNum = rand(0, count($challenges) - 1);
			$chosenChallenge = $challenges[$randNum];
			
			// Do some business about creating an instance
			$user1 = DB_Controller::GetUserByMac($mac1);
			$users = array();
			$users[] = $user1;
			AddChallengeInstance::Execute($chosenChallenge->ID(), $users);
			$challengeInstance = AddChallengeInstance::ChallengeInstance();
			
			$challengeInstanceChallenge = new ChallengeInstanceChallenge();
			$challengeInstanceChallenge->ConvertFrom($chosenChallenge, $challengeInstance);
			
			// Push notification to both devices about challenge
			$messageToPush = json_encode($challengeInstanceChallenge);
			$challengeInstanceID = $challengeInstanceChallenge->ID();
			$user1ID = $user1->ID();
			$pushNotification = file_get_contents("http://www.cjcornell.com/bluegame/GCM/send_message_sp.php?socproxID={$user1ID}&message=challengeInstanceID={$challengeInstanceID}");
			
			return new Success($challengeInstanceChallenge);
		}
		else {
			return new Error(100, 'Usage: /getChallenge/mac1/mac2');
		}
    }

    /**
     * Gets a specific challenge instance
     *
     * @url GET /getChallengeInstance/:mac/:instanceID
     */
    public function getChallengeInstance($mac = null, $instanceID = null)
    {
        if (!$mac || !$instanceID) {
            return new Error(100, "Please specify a mac address and instance ID.");
        }
        $result = GetChallengeInstance::Execute($mac, $instanceID);
        if ($result == -1) return new Error(1, "The MAC Address given is not tied to a user.");
        $challengeInstance = GetChallengeInstance::ChallengeInstance();
        if (isset($challengeInstance)) {    
            return new Success($challengeInstance);
        } else {
            return new Error(1, "No challenge instance associated with that ID.");
        }
    }

    /**
     * Gets all active challenges
     *
     * @url GET /getChallengeInstances/:mac/:statuses
     * @url GET /getChallengeInstances/:mac
     */
    public function getChallengeInstances($mac = null, $statuses = null)
    {
        if (!$mac) return new Error(1, "Please specify a user");
        $aStatuses;
        if ($statuses) {
            // The user specified statuses that they want the challenges to be limited to
            $aStatuses = explode(',', $statuses);
        } else {
            // The user specified no statuses, so use all
            $aStatuses = array('pending', 'active', 'completed');
        }
        $result = GetChallengeInstances::Execute($mac, $aStatuses);
        if ($result == -1) return new Error(1, "The MAC Address given is not tied to a user.");
        $aChallengeInstances = GetChallengeInstances::ChallengeInstances();
        
        if (isset($aChallengeInstances)) {    
            // Format the challenge instance based on the game
            $aGames = array();
            foreach ($aChallengeInstances as $instance) {
                if (!isset($aGames[$instance->GameName()])) {
                    $aGames[$instance->GameName()] = array();
                    $aGames[$instance->GameName()]['challenges'] = array();
                    $aGames[$instance->GameName()]['name'] = $instance->GameName();
                }
                $aGames[$instance->GameName()]['challenges'][] = $instance;
            }
            $aReturn = array();
            foreach ($aGames as $value) {
                $aReturn[] = $value;
            }
            return new Success(array("Games"=>$aReturn));
        } else {
            return new Error(1, "No challenge instances associated with user.");
        }
    }

    /**
     * Does a users
     *
     * @url GET /getLogs/:type1/:value1/:type2/:value2/:type3/:value3
     * @url GET /getLogs/:type1/:value1/:type2/:value2
     * @url GET /getLogs/:type1/:value1
     * @url GET /getLogs
     */
    public function getLogs($type1 = null, $value1 = null, $type2 = null, $value2 = null, $type3 = null, $value3 = null)
    {
        if(    (isset($type1) && !isset($value1))
            || (isset($type2) && !isset($value2))
            || (isset($type3) && !isset($value3))) 
            {
                $error = new Error(1, "Incorrect usage of getLogs. Please provide a value for each type entered.");
                return $error;
            }
        if(isset($type1)) {
            if($type1 == 'mac') GetLogs::Mac($value1);
            else if($type1 == 'limit') GetLogs::Limit($value1);
            else if($type1 == 'function') GetLogs::FunctionCalled($value1);
            else {
                $error = new Error(1, "Please input a correct type at parameter #1, either mac, limit, or function");
                return $error;
            }
        }
        if(isset($type2)) {
            if($type2 == 'mac') GetLogs::Mac($value2);
            else if($type2 == 'limit') GetLogs::Limit($value2);
            else if($type2 == 'function') GetLogs::FunctionCalled($value2);
            else {
                $error = new Error(1, "Please input a correct type at parameter #2, either mac, limit, or function");
                return $error;
            }
        }
        if(isset($type3)) {
            if($type3 == 'mac') GetLogs::Mac($value3);
            else if($type3 == 'limit') GetLogs::Limit($value3);
            else if($type3 == 'function') GetLogs::FunctionCalled($value3);
            else {
                $error = new Error(1, "Please input a correct type at parameter #3, either mac, limit, or function");
                return $error;
            }
        }
        GetLogs::Execute();
        $logs = GetLogs::Logs();
        return new Success($logs);
    }

    /**
     * Gets the standings
     *
     * @url GET /getStandings/:type1/:value1/:type2/:value2/:type3/:value3
     * @url GET /getStandings/:type1/:value1/:type2/:value2
     * @url GET /getStandings/:type1/:value1
     * @url GET /getStandings
     */
    public function getStandings($type1 = null, $value1 = null, $type2 = null, $value2 = null, $type3 = null, $value3 = null)
    {
        if(    (isset($type1) && !isset($value1))
            || (isset($type2) && !isset($value2))
            || (isset($type3) && !isset($value3))) 
            {
                $error = new Error(1, "Incorrect usage of getStandings. Please provide a value for each type entered.");
                return $error;
            }
        if(isset($type1)) {
            if($type1 == 'mac') GetStandings::Mac($value1);
            else if($type1 == 'limit') GetStandings::Limit($value1);
            else if($type1 == 'gamename') GetStandings::GameName($value1);
            else {
                $error = new Error(1, "Please input a correct type at parameter #1, either mac, limit, or gamename");
                return $error;
            }
        }
        if(isset($type2)) {
            if($type2 == 'mac') GetStandings::Mac($value2);
            else if($type2 == 'limit') GetStandings::Limit($value2);
            else if($type2 == 'gamename') GetStandings::GameName($value2);
            else {
                $error = new Error(1, "Please input a correct type at parameter #2, either mac, limit, or gamename");
                return $error;
            }
        }
        if(isset($type3)) {
            if($type3 == 'mac') GetStandings::Mac($value3);
            else if($type3 == 'limit') GetStandings::Limit($value3);
            else if($type3 == 'gamename') GetStandings::GameName($value3);
            else {
                $error = new Error(1, "Please input a correct type at parameter #3, either mac, limit, or gamename");
                return $error;
            }
        }
        $result = GetStandings::Execute();
        if ($result == -1) {
            $error = new Error(1, "The game name supplied does not exist.");
            return $error;
        } else if ($result == -2) {
            $error = new Error(1, "No user exists with the supplied MAC Address.");
            return $error;
        } else if ($result == -3) {
            $error = new Error(1, "The user supplied is not involved in any games.");
            return $error;
        }
        $games = GetStandings::Games();
        return new Success($games);
    }

    /**
     * Gets the global stats
     *
     * @url GET /globalStats
     */
    public function globalStats()
    {
        $result = GetGlobalStats::Execute();
        if ($result == -1) {
            $error = new Error(1, "There was an internal error.");
            return $error;
        }
        return new Success(GetGlobalStats::Stats());
    }
	
	/**
     * Does a challengeStatus
     *
     * @url GET /challengeStatus/:mac1/:iID
	 * @url GET /challengeStatus/:mac1
	 * @url GET /challengeStatus
     */
    public function challengeStatus($mac1 = null, $iID = null)
    {
		if ($mac1 && $iID)
		{
			RefreshChallengeInstance::Execute($mac1, $iID);
			$challengeInstance = RefreshChallengeInstance::ChallengeInstance();
			return new Success($challengeInstance);
		}
		else
		{
			return new Error(100, 'Usage: /challengeStatus/userMAC/instanceID');
		}
	}

    /**
     * Does an updateChallenge
     *
     * @url GET /updateChallenge/:macID/:iID/:input
     * @url GET /updateChallenge/:macID/:iID
     * @url GET /updateChallenge/:macID
	 * @url GET /updateChallenge
     */
    public function updateChallenge($macID = null, $iID = null, $input = null)
    {
		if ($macID && $iID && $input)
		{
			$success = (strcmp($input, 'success') == 0);
			$fail = (strcmp($input, 'fail') == 0);
			$accept = (strcmp($input, 'accepted') == 0);
			$deny = (strcmp($input, 'denied') == 0);
			if ($success || $fail)
			{
				$result = VerifyChallenge::Execute($iID, $macID, $input);
                if ($result == -1) {
                    return new Error(1, "There is no user associated with that MAC Address.");
                } else if ($result == -2) {
                    return new Error(1, "There is no challenge instance with that ID.");
                } else if ($result == -3) {
                    return new Error(1, "There are no users associated with the challenge.");
                }
                return new Success("Successfully verified challenge!");
			}
			else if ($accept || $deny)
			{
				$result = ConfirmChallenge::Execute($macID, $iID, $input);
                if ($result == -1) {
                    return new Error(1, "There is no user associated with that MAC Address.");
                } else if ($result == -2) {
                    return new Error(1, "There is no challenge instance with that ID.");
                } 
                return new Success("Successfully confirmed challenge!");
			}
            else return new Error(2, "Please enter the status as either success, fail, accept, or deny.");
		}
		else
		{
			return new Error(100, 'Usage: /updateChallenge/MACAddress/InstanceID/acceptdenysuccessfail');
		}
    }

	/**
     * Does a users
     *
	 * @url GET /users
     */
    public function users()
    {
		GetUsers::Execute();
		$users = GetUsers::Users();
		return new Success($users);
	}
	
	/**
     * Does a userStats
     *
     * @url GET /userStats/:mac1
	 * @url GET /userStats
     */
    public function userStats($mac1 = null)
    {
		if ($mac1)
		{
			$result = GetUserStats::Execute($mac1);
			if ($result == -1) {
			    $error = new Error(1, "No user exists with supplied MAC Address.");
                return $error;
			}
			$stats = GetUserStats::Stats();
			return new Success($stats);
		}
		else
		{
			return new Error(100, 'Usage: /userStats/userMAC');
		}
	}
	
	/**
     * Update user profile
     *
     * @url GET /updateProfile/:userName/:fieldsStr/:valuesStr
	 * @url GET /updateProfile
     */
    public function updateProfile($userName = null, $fieldsStr = null, $valuesStr = null)
    {
		if (isset($userName) && isset($fieldsStr) && isset($valuesStr))
		{
			$user = DB_Controller::GetUserByUsername($userName);
			$fields = explode(',', $fieldsStr);
			$values = explode(',', $valuesStr);
            $result = UpdateProfile::Execute($userName, $fields, $values);
            
			if ($result == -1) {
                $error = new Error(1, "No user exists with supplied username.");
                return $error;
            } else if ($result == -2) {
                $error = new Error(1, "Please supply an equal amount of fields and values.");
                return $error;
            } else if ($result == -3) {
                $error = new Error(1, "One of the fields you entered is not supported. We support mac address, name, and email changes.");
                return $error;
            } else {
    			$success = new Success("Update successful.");
    			return $success;
            }
		} 
		else
		{
			return new Error(100, 'Usage: /updateProfile/userID/field1,field2,.../value1,value2,...');
		}
	}

 	/**
     * Simulate a challenge
     *
	 * @url GET /simChallenge/:mac1/:mac2/:cID
	 * @url GET /getChallenge/:mac1:/cID
     * @url GET /getChallenge
     */
    public function simChallenge($mac1 = null, $mac2 = null, $cID)
    {
        if ($mac1 && $mac2 && $cID) {
            // Get the challenges for both users
            $challenges1 = GetActiveChallenges::Execute($mac1);
            // Calculate the available challenges based on the ones the users have in common
			$availableChallenges = array();
			foreach ($challenges1 as $challenge1){
				if ($challenge1->ID() == $cID)
				{
					$availableChallenges = array_values($availableChallenges);
					$availableChallenges[] = $challenge1;
				}
			}
			$chosenChallenge = $availableChallenges[0];
			
			// Do some business about creating an instance
			$user1 = DB_Controller::GetUserByMac($mac1);
			$user2 = DB_Controller::GetUserByMac($mac2);
			$users = array();
			$users[] = $user1;
			$users[] = $user2;
			// OLD$userIDs = $user1->ID().";".$user2->ID();
			AddChallengeInstance::Execute($chosenChallenge->ID(), $users);
			$challengeInstance = AddChallengeInstance::ChallengeInstance();
			
			$challengeInstanceChallenge = new ChallengeInstanceChallenge();
			$challengeInstanceChallenge->ConvertFrom($chosenChallenge, $challengeInstance);
         	$challengeInstanceChallenge->Username1($user1->Username());
          	$challengeInstanceChallenge->Username2($user2->Username());
			return $challengeInstanceChallenge->ID().'/'.$user1->Username().'/'.$user2->Username();
        }
		else if ($mac1 && $cID) {
			$challenges = GetActiveChallenges::Execute($mac1);
			$availableChallenges = array();
			foreach ($challenges as $challenge){
				if ($challenge->ID() == $cID)
				{
					$availableChallenges = array_values($availableChallenges);
					$availableChallenges[] = $challenge;
				}
			}
			$chosenChallenge = $availableChallenges[0];
			
			// Do some business about creating an instance
			$user1 = DB_Controller::GetUserByMac($mac1);
			$users = array();
			$users[] = $user1;
			AddChallengeInstance::Execute($chosenChallenge->ID(), $users);
			$challengeInstance = AddChallengeInstance::ChallengeInstance();
			
			$challengeInstanceChallenge = new ChallengeInstanceChallenge();
			$challengeInstanceChallenge->ConvertFrom($chosenChallenge, $challengeInstance);
			return $challengeInstanceChallenge->ID().'+'.$user1->Username();
		}
    }
}
?>