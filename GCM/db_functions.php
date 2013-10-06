<?php
 
class DB_Functions {
 
    private $db;
 
    //put your code here
    // constructor
    function __construct() {
        include_once './db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }
 
    // destructor
    function __destruct() {
 
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $gcm_regid, $socproxID) {
        // insert user into database
        $result = mysql_query("INSERT INTO gcm_users(name, email, gcm_regid, socproxID, created_at) VALUES('$name', '$email', '$gcm_regid', '$socproxID', NOW())");
        // check for successful store
        if ($result) {
            // get user details
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM gcm_users WHERE id = $id") or die(mysql_error());
            // return user details
            if (mysql_num_rows($result) > 0) {
                return mysql_fetch_array($result);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
 
    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM gcm_users");
        return $result;
    }
 
    /**
     * Getting all users
     */
    public function getSocproxID($socproxUser) {
        $result = mysql_query("SELECT UserID FROM User WHERE Username='{$socproxUser}'");
        return $result;
    }
 
    /**
     * Getting all users
     */
    public function getRegID($socproxID) {
        $result = mysql_query("SELECT * FROM gcm_users WHERE socproxID='{$socproxID}'");
        return $result;
    }
 
}

?>