<?php
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/IDB_Functions.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Activity.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Challenge.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/ChallengeAcceptance.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/ChallengeInstance.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Game.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Payoff.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/User.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Verification.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Log.php';
require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Classes/Point.php';

class DB_Controller {
	private static $m_oController;
	
	private static function getDB(){
		if (!isset(self::$m_oController)){
			require_once '/home/content/c/j/c/cjcornell3/html/bluegame/Database/Spreadsheet_Functions.php';
			self::$m_oController = new Spreadsheet_Functions();
		}
		return self::$m_oController;
	}
	
	public static function RecordUsers(){
		$aUsers = self::getDB()->GetAllUsers();
		if (!count($aUsers))
		{
			echo "null";
			return NULL;
		}
		$aResult = array();
		foreach ($aUsers as $user){
			$user = new User($user);
			$aResult[] = $user;
			$sql = "INSERT INTO User (UserID, Username, MAC_Address, Password, SSID, Facebook_Email, Name, Picture_Location, Playing_Status, Total_Points, Last_Location, Device_Type, Games_Finished) VALUES ('".mysql_real_escape_string($user->ID())."', '".mysql_real_escape_string($user->Username())."', '".mysql_real_escape_string($user->MacAddress())."', '".mysql_real_escape_string($user->Password())."', '".mysql_real_escape_string($user->SSID())."', '".mysql_real_escape_string($user->Facebook())."', '".mysql_real_escape_string($user->Name())."', '".mysql_real_escape_string($user->PicLocation())."', '".mysql_real_escape_string($user->Status())."', '".mysql_real_escape_string($user->TotalPoints())."', '".mysql_real_escape_string($user->LastLocation())."', '".mysql_real_escape_string($user->Device())."', '".mysql_real_escape_string($user->GamesFinished())."')";
			print $sql."<br>";
			$result = mysql_query($sql);
			if ($result)
			{
				print "result true";
			}
			else
			{
				print "result false";
			}
		}
		return $aResult;
	}
	
	public static function RecordChallenges(){
		$aUsers = self::getDB()->GetAllChallenges();
		if (!count($aUsers))
		{
			echo "null";
			return NULL;
		}
		$aResult = array();
		foreach ($aUsers as $user){
			$user = new Challenge($user);
			$aResult[] = $user;
			$sql = "INSERT INTO Challenge (ChallengeID, Internal_Name, Internal_Description, Name, Instructions, Category_ID, Game_ID, Start_Date, End_Date, Start_Time, End_Time, P1_ID, P2_ID, P3_ID, P4_ID, Min_Players, Max_Players, VerificationID, Description) VALUES ('".mysql_real_escape_string($user->ID())."', '".mysql_real_escape_string($user->IntName())."', '".mysql_real_escape_string($user->IntDescription())."', '".mysql_real_escape_string($user->Name())."', '".mysql_real_escape_string($user->Instructions())."', '".mysql_real_escape_string($user->CategoryID())."', '".mysql_real_escape_string($user->GameID())."', '".mysql_real_escape_string($user->StartDate())."', '".mysql_real_escape_string($user->EndDate())."', '".mysql_real_escape_string($user->StartTime())."', '".mysql_real_escape_string($user->EndTime())."', '".mysql_real_escape_string($user->P1ID())."', '".mysql_real_escape_string($user->P2ID())."', '".mysql_real_escape_string($user->P3ID())."', '".mysql_real_escape_string($user->P4ID())."', '".mysql_real_escape_string($user->MinPlayers())."', '".mysql_real_escape_string($user->MaxPlayers())."', '".mysql_real_escape_string($user->VerificationID())."', '".mysql_real_escape_string($user->Description())."')";
			print $sql."<br>";
			$result = mysql_query($sql);
			if ($result)
			{
				print "result true";
			}
			else
			{
				print "result false";
			}
		}
		return $aResult;
	}
	
	public static function RecordLogs(){
		$aUsers = self::getDB()->GetAllLog();
		if (!count($aUsers))
		{
			echo "null";
			return NULL;
		}
		$aResult = array();
		foreach ($aUsers as $user){
			$user = new Log($user);
			$aResult[] = $user;
			$datetime = new DateTime($user->Time());
			$sql = "INSERT INTO Log (LogID, MAC_Address, Function_Called, Time) VALUES ('".mysql_real_escape_string($user->ID())."', '".mysql_real_escape_string($user->MacAddress())."', '".mysql_real_escape_string($user->FunctionCalled())."', '"./*mysql_real_escape_string($user->Time())*/$datetime->format('Y-m-d H:i:s')."')";
			print $sql."<br>";
			$result = mysql_query($sql);
			if ($result)
			{
				print "result true";
			}
			else
			{
				print "result false";
			}
		}
		return $aResult;
	}
	
	public static function RecordActivities(){
		$aUsers = self::getDB()->GetAllActivity();
		if (!count($aUsers))
		{
			echo "null";
			return NULL;
		}
		$aResult = array();
		foreach ($aUsers as $user){
			$user = new Activity($user);
			$aResult[] = $user;
			$datetime = new DateTime($user->Time());
			$sql = "INSERT INTO Activity (ActivityID, UserID, GameID, ChallengeInstID, Time, Points, PayoffID, VerifiedBy, VerifiedID, Result) VALUES ('".mysql_real_escape_string($user->ID())."', '".mysql_real_escape_string($user->UserID())."', '".mysql_real_escape_string($user->GameID())."', '".mysql_real_escape_string($user->ChallengeInstID())."', '".$datetime->format('Y-m-d H:i:s')."', '".mysql_real_escape_string($user->Points())."', '".mysql_real_escape_string($user->PayoffID())."', '".mysql_real_escape_string($user->VerifiedBy())."', '".mysql_real_escape_string($user->VerifiedID())."', '".mysql_real_escape_string($user->Result())."')";
			print $sql."<br>";
			$result = mysql_query($sql);
			if ($result)
			{
				print "result true";
			}
			else
			{
				print "result false";
			}
		}
		return $aResult;
	}
	
	public static function RecordChallengeInstances(){
		$aUsers = self::getDB()->GetAllChallengeInstance();
		if (!count($aUsers))
		{
			echo "null";
			return NULL;
		}
		$aResult = array();
		foreach ($aUsers as $user){
			$user = new ChallengeInstance($user);
			$aResult[] = $user;
			$sql = "INSERT INTO ChallengeInstance (ChallengeInstanceID, ChallengeID, UserIDs, Status, Accepts) VALUES ('".mysql_real_escape_string($user->ID())."', '".mysql_real_escape_string($user->ChallengeID())."', '".mysql_real_escape_string($user->UserIDs())."', '".mysql_real_escape_string($user->Status())."', '".mysql_real_escape_string($user->Accepts())."')";
			print $sql."<br>";
			$result = mysql_query($sql);
			if ($result)
			{
				print "result true";
			}
			else
			{
				print "result false";
			}
		}
		return $aResult;
	}
	
	public static function RecordChallengeAcceptances(){
		$aUsers = self::getDB()->GetAllChallengeAcceptance();
		if (!count($aUsers))
		{
			echo "null";
			return NULL;
		}
		$aResult = array();
		foreach ($aUsers as $user){
			$user = new ChallengeAcceptance($user);
			$aResult[] = $user;
			$sql = "INSERT INTO ChallengeAcceptance (ChallengeAcceptanceID, ChallengeInstanceID, UserID, Accepts) VALUES ('".mysql_real_escape_string($user->ID())."', '".mysql_real_escape_string($user->ChallengeInstanceID())."', '".mysql_real_escape_string($user->UserID())."', '".mysql_real_escape_string($user->Accepts())."')";
			print $sql."<br>";
			$result = mysql_query($sql);
			if ($result)
			{
				print "result true";
			}
			else
			{
				print "result false";
			}
		}
		return $aResult;
	}
	
	public static function RecordGames(){
		$aUsers = self::getDB()->GetAllGame();
		if (!count($aUsers))
		{
			echo "null";
			return NULL;
		}
		$aResult = array();
		foreach ($aUsers as $user){
			$user = new Game($user);
			$aResult[] = $user;
			$sql = "INSERT INTO Game (GameID, Name, Description, Criteria_to_Play, Start_Date, End_Date, Duration, Winning_Points, Number_of_Iterations) VALUES ('".mysql_real_escape_string($user->ID())."', '".mysql_real_escape_string($user->Name())."', '".mysql_real_escape_string($user->Description())."', '".mysql_real_escape_string($user->Criteria())."', '".mysql_real_escape_string($user->StartDate())."', '".mysql_real_escape_string($user->EndDate())."', '".mysql_real_escape_string($user->Duartion())."', '".mysql_real_escape_string($user->WinningPoints())."', '".mysql_real_escape_string($user->NumIterations())."')";
			print $sql."<br>";
			$result = mysql_query($sql);
			if ($result)
			{
				print "result true";
			}
			else
			{
				print "result false";
			}
		}
		return $aResult;
	}
	
	public static function RecordPayoffs(){
		$aUsers = self::getDB()->GetAllPayoffs();
		if (!count($aUsers))
		{
			echo "null";
			return NULL;
		}
		$aResult = array();
		foreach ($aUsers as $user){
			$user = new Payoff($user);
			$aResult[] = $user;
			$sql = "INSERT INTO Payoffs (PayoffID, Name, Description, Is_Reward, Value) VALUES ('".mysql_real_escape_string($user->ID())."', '".mysql_real_escape_string($user->Name())."', '".mysql_real_escape_string($user->Description())."', '".mysql_real_escape_string($user->IsReward())."', '".mysql_real_escape_string($user->Value())."')";
			print $sql."<br>";
			$result = mysql_query($sql);
			if ($result)
			{
				print "result true";
			}
			else
			{
				print "result false";
			}
		}
		return $aResult;
	}
	
	public static function RecordVerifications(){
		$aUsers = self::getDB()->GetAllVerification();
		if (!count($aUsers))
		{
			echo "null";
			return NULL;
		}
		$aResult = array();
		foreach ($aUsers as $user){
			$user = new Verification($user);
			$aResult[] = $user;
			$sql = "INSERT INTO Verification (VerificationID, Name, Description, Type) VALUES ('".mysql_real_escape_string($user->ID())."', '".mysql_real_escape_string($user->Name())."', '".mysql_real_escape_string($user->Description())."', '".mysql_real_escape_string($user->Type())."')";
			print $sql."<br>";
			$result = mysql_query($sql);
			if ($result)
			{
				print "result true";
			}
			else
			{
				print "result false";
			}
		}
		return $aResult;
	}
	
	public static function RecordPoints(){
		$aUsers = self::getDB()->GetAllPoints();
		if (!count($aUsers))
		{
			echo "null";
			return NULL;
		}
		$aResult = array();
		foreach ($aUsers as $user){
			$user = new Point($user);
			$aResult[] = $user;
			$sql = "INSERT INTO Points (GameID, UserID, Points, Is_Active) VALUES ('".mysql_real_escape_string($user->GameID())."', '".mysql_real_escape_string($user->UserID())."', '".mysql_real_escape_string($user->Points())."', '".mysql_real_escape_string($user->IsActive())."')";
			print $sql."<br>";
			$result = mysql_query($sql);
			if ($result)
			{
				print "result true";
			}
			else
			{
				print "result false";
			}
		}
		return $aResult;
	}
	
}

$con = mysql_connect("swirlclinic.com","capstone","asucapstone");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

// Create tables
mysql_select_db("capstonedb", $con);

$sql = "DROP TABLE IF EXISTS User";
mysql_query($sql,$con);

$sql = "CREATE TABLE User
(UserID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Username varchar(255),
MAC_Address varchar(255),
Password varchar(255),
SSID varchar(255),
Facebook_Email varchar(255),
Name varchar(255),
Picture_Location varchar(255),
Playing_Status varchar(255),
Total_Points int,
Last_Location varchar(255),
Device_Type varchar(255),
Games_Finished int)";
$result = mysql_query($sql,$con);
if ($result)
{
	print "Yay\n";
}
else
{
	print "Nay\n";
}

$sql = "DROP TABLE IF EXISTS Challenge";
mysql_query($sql,$con);

$sql = "CREATE TABLE Challenge
(ChallengeID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Internal_Name varchar(255),
Internal_Description varchar(255),
Name varchar(255),
Instructions varchar(255),
Category_ID int,
Game_ID int,
Start_Date varchar(255),
End_Date varchar(255),
Start_Time varchar(255),
End_Time varchar(255),
P1_ID int,
P2_ID int,
P3_ID int,
P4_ID int,
Min_Players int,
Max_Players int,
VerificationID int,
Description varchar(255))";
$result = mysql_query($sql,$con);
if ($result)
{
	print "Yay\n";
}
else
{
	print "Nay\n";
}

$sql = "DROP TABLE IF EXISTS Log";
mysql_query($sql,$con);

$sql = "CREATE TABLE Log
(LogID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
MAC_Address varchar(255),
Function_Called varchar(255),
Time datetime)";
$result = mysql_query($sql,$con);
if ($result)
{
	print "Yay\n";
}
else
{
	print "Nay\n";
}

$sql = "DROP TABLE IF EXISTS Activity";
mysql_query($sql,$con);

$sql = "CREATE TABLE Activity
(ActivityID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
UserID int,
GameID int,
ChallengeInstID int,
Time datetime,
Points int,
PayoffID int,
VerifiedBy int,
VerifiedID int,
Result varchar(255))";
$result = mysql_query($sql,$con);
if ($result)
{
	print "Yay\n";
}
else
{
	print "Nay\n";
}

$sql = "DROP TABLE IF EXISTS ChallengeInstance";
mysql_query($sql,$con);

$sql = "CREATE TABLE ChallengeInstance
(ChallengeInstanceID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
ChallengeID int,
UserIDs varchar(255),
Status varchar(255),
Accepts varchar(255))";
$result = mysql_query($sql,$con);
if ($result)
{
	print "Yay\n";
}
else
{
	print "Nay\n";
}

$sql = "DROP TABLE IF EXISTS ChallengeAcceptance";
mysql_query($sql,$con);

$sql = "CREATE TABLE ChallengeAcceptance
(ChallengeAcceptanceID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
ChallengeInstanceID int,
UserID int,
Accepts varchar(255))";
$result = mysql_query($sql,$con);
if ($result)
{
	print "Yay\n";
}
else
{
	print "Nay\n";
}

$sql = "DROP TABLE IF EXISTS Game";
mysql_query($sql,$con);

$sql = "CREATE TABLE Game
(GameID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Name varchar(255),
Description varchar(255),
Criteria_to_Play varchar(255),
Start_Date varchar(255),
End_Date varchar(255),
Duration int,
Winning_Points int,
Number_of_Iterations int)";
$result = mysql_query($sql,$con);
if ($result)
{
	print "Yay\n";
}
else
{
	print "Nay\n";
}

$sql = "DROP TABLE IF EXISTS Payoffs";
mysql_query($sql,$con);

$sql = "CREATE TABLE Payoffs
(PayoffID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Name varchar(255),
Description varchar(255),
Is_Reward varchar(255),
Value int)";
$result = mysql_query($sql,$con);
if ($result)
{
	print "Yay\n";
}
else
{
	print "Nay\n";
}

$sql = "DROP TABLE IF EXISTS Verification";
mysql_query($sql,$con);

$sql = "CREATE TABLE Verification
(VerificationID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
Name varchar(255),
Description varchar(255),
Type varchar(255))";
$result = mysql_query($sql,$con);
if ($result)
{
	print "Yay\n";
}
else
{
	print "Nay\n";
}

$sql = "DROP TABLE IF EXISTS Points";
mysql_query($sql,$con);

$sql = "CREATE TABLE Points
(GameID int,
UserID int,
Points int,
Is_Active int)";
$result = mysql_query($sql,$con);
if ($result)
{
	print "Yay\n";
}
else
{
	print "Nay\n";
}

$dbController = new DB_Controller();
$dbController->RecordUsers();
$dbController->RecordChallenges();
$dbController->RecordLogs();
$dbController->RecordActivities();
$dbController->RecordChallengeInstances();
$dbController->RecordChallengeAcceptances();
$dbController->RecordGames();
$dbController->RecordPayoffs();
$dbController->RecordVerifications();
$dbController->RecordPoints();

mysql_close($con);
print "closed";
?>