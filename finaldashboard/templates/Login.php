<?php
$text = "b055inGH4rd!";
if(!empty($_POST)){
	//TODO: Check to see if these are set, else return an error to submission form
	if(isset($_POST["username"]))
	{
		$inputUsername = $_POST["username"];
		$usersReturn = json_decode(file_get_contents("http://cjcornell.com/bluegame/REST/users"), true);
        $users = $usersReturn['body'];
		foreach($users as $user)
		{
			if($user["m_strUsername"] === $inputUsername && isset($_POST["password"]))
			{
				$strPassword = $_POST["password"];
				if($user["m_strPassword"] === $strPassword)
				{
					
				}
			}
		}
	}
	
	$intService = $_POST["service"];      
	 
    $result = "";
    
        if(!strcmp($json['Username'],$name)) {
            $usrErr = true;
            $result = $result . "Username already exists ";
        }
        if(!strcmp($json['Email'],$email)) {
            if($usrErr){
                $result = $result . "and Email is already registered";
            } else {
                $result = $result . "Email already registered";
            }
        }
        echo $result;
        return NULL;
    

    $sql = "INSERT INTO Users (Username, Email, Password, Admin) VALUES ('$name', '$email', AES_ENCRYPT('$text', '$password'), '0')";
    if (mysqli_query($con,$sql))
    {
        echo "Success";
    }
    else
    {
        echo "Error adding to table: " . mysqli_error($con);
    }
} else {
    $sql = "SELECT * FROM Users WHERE Username='$name' AND Password=AES_ENCRYPT('$text', '$password')";
    if ($user = mysqli_query($con,$sql))
    {
        session_start();
        $result = mysqli_fetch_array($user);
        $_SESSION['userID'] = $result['PID'];
        $_SESSION['userName'] = $name;
        echo "Successful";
    }
    else
    {
        echo "Error adding to table: " . mysqli_error($con);
    }
}

?>