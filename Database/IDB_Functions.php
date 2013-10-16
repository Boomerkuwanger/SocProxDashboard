<?php
// The interface that all database function classes must extend in order to perform actions and queries on the backend database
interface IDB_Functions {
	public static function AddActivity($activity);
	public static function AddGame($game);
	public static function AddChallenge($challenge);
	public static function AddChallengeInstance($challengeInstance);
    public static function AddPoints($points, $userId, $gameId);
	public static function AddUser($user);
	public static function DeleteChallenge($challengeId);
	public static function DeleteChallengeInstance($challenge);
	public static function DeleteChallengeAcceptance($challenge);
	public static function DeleteUser($user);
	public static function DeleteGame($game);
	public static function GetActivities($user);
    public static function GetAllGame();
    public static function GetChallengeInstanceAcceptances($challengeInstanceID);
	public static function GetChallenges($user);
	public static function GetChallengeByID($challengeID);
    public static function GetChallengeInstances($user, $aStatuses);
    public static function GetChallengeInstance($user, $instanceID);
	public static function GetChallengeInstByID($challengeInstance);
    public static function GetGame($gameName);
    public static function GetGlobalStats();
    public static function GetLogs($iLimit, $strFunction, $strMAC);
	public static function GetPayoffByID($payoffID);
    public static function GetPointsForUser($user);
    public static function GetSocialMediaBySiteAndName($website, $webUsername);
    public static function GetStandings($limit, $gameID);
	public static function GetUserByEmail($email);
	public static function GetUserByID($userID);	
	public static function GetUserByMac($MACAddress);
    public static function GetUserByUsername($username);
    public static function GetUserIdFromSocialMedia($socialMediaUsername, $service);
	public static function GetUsers();
	public static function GetVerification($verifyID);
    public static function LinkUser($website, $webUsername, $userid);
    public static function Log($MACAddress, $functionName);
    public static function UnsetMacAddressForOthers($macAddress, $username);
	public static function UpdateChallengeInstance($existingChallengeInstance);
	public static function UpdateUser($existingUser);
}

?>