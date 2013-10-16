<?php
include "../Database/ctrlHead.php";
//Retrieve the name and password
$name = $_GET["e"];
$password = $_GET["p"];
$text = "socProx!";
if(isset($_GET["e"])){
    //Retrieve the email
    $email = $_GET["e"];
    $sql = "SELECT * FROM Users WHERE Username='$name' OR Email='$email'";
    $users = mysqli_query($con,$sql);
    $result = "";
    while($json = mysqli_fetch_array($users))
    {
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
    }

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

include "../Database/ctrlTail.php";
?>