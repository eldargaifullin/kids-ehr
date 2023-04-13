<?php
class Database
{

	private static $cont  = null;

	public function __construct() {
    	die('Init function is not allowed');
	}

	public static function connect()
	{
        
       // Create connection
        $conn = new mysqli('localhost', 'j977592l_ehr', 'Newj977592l_ehr', 'j977592l_ehr');
        
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
//        echo "Connected successfully";
        return $conn;

	}
}
?>
