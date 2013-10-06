<?php
// Class that makes the direct calls to the MySQL database backend
class MySQL_Controller {
    
    private $dsn;
    private $user;
    private $password;
    private $handler;
    
    // Takes the dsn, user, and password, and creates a PDO (object that works with the SQL database)
    public function __construct(){
        // $this->dsn = "mysql:dbname=socprox;host=socprox.db.4163804.hostedresource.com";
        // $this->user = "socprox";
        // $this->password = "Bluetooth1234#";
        $this->dsn = "mysql:dbname=socprox;host=socprox.db.4163804.hostedresource.com";
        $this->user = "socprox";
        $this->password = "Bluetooth1234#";
        $this->handler = new PDO($this->dsn, $this->user, $this->password);   
    }
    
    // function that executes actions (DELETE, INSERT, etc.) on a table. 
    // NOTE: the SQL call passed in should have question marks in place of each parameter, and an array of parameters in order that they
    //      would appear in the call, passed in as the second parameter
    // EXAMPLE: say you want to call INSERT INTO table VALUES("val1", "val2"),
    // You would call: executeAction("INSERT INTO table VALUES(?,?)", $array("val1", "val2"))
    // This prevents SQL injection from occurring! Parameters passed in by users will be treated as strings, not as potential SQL calls
    public function executeAction($sql, $aParams=null) {
        $query = $this->handler->prepare($sql);
        if(isset($aParams)) {
            foreach($aParams as $key => &$value) {
                // keys start at 1, not 0, for the PDO handler
                // values have to be passed in by reference, not value, hence the pointer
                $query->bindParam($key + 1, $value);
            }
        }
        $query->execute();
        // echo "SQL : " . $sql . " Count of params: " . count($aParams) . "<br>";
    }
    
    // function that executes queries (GET) on a table
    public function executeQuery($sql, $aParams=null) {
        //echo "QUERY: " . $sql . "<br>";
        $query = $this->handler->prepare($sql);
        if(isset($aParams)) {
            foreach($aParams as $key => &$value) {
                $query->bindParam($key + 1, $value);
                //echo $value;
            }
        }
        $query->execute();
        // echo $this->handler->errorCode();
        $aResult = $this->convertKeys($query->fetchAll());
        //echo "SQL : " . $sql . " Count of params: " . count($aParams) . "<br>";
        return $aResult;
    }
    
    // For ease of reading, the MySQL columns have been named with "_" separating words, and have uppercase values.
    // Objects, when constructed, require that the array values are all lowercase and have no delimiters between words. Thus,
    //      this function strips all underscores and lowercases all keys to make it consistent with the object class design
    private function convertKeys($aResult) {
        $aFinalResult = array();
        foreach($aResult as $rows) {
            $finalResult = array();
           //  echo print_r($rows) . "<br>";
            foreach($rows as $key => $value) {
                // echo "Key: " . $key . " Value: " . $value;
                $newKey = str_replace("_", "", $key);
                $newKey = strtolower($newKey);
                // echo " New key: " . $newKey . "<br>";
                $finalResult[$newKey] = $value;
            }
            $aFinalResult[] = $finalResult;
        }
         //echo "<br>Final Result:<br>" . print_r($aFinalResult);
        return $aFinalResult;
    }
    
}

?>