<?php


class DatabaseConnection {
	private $host = "localhost";
	private $user = "root";
	private $password = "dhruv";
	private $database = "myDB";
	private $conn;
    
    function __construct(){	
    $this->conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
	
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	}

	function runQuery_prep($query,$date, $location){
	   if ($stmt = $this->conn->prepare($query)){
	   
		/* Bind our params */
		$temp= $stmt->bind_param('ss', $date, $location);

		/* Execute the prepared Statement */
		if(!$stmt->execute()) echo " Query Execution failed";
        
	    /* Close the statement */
		$stmt->close();
		
		return true;
		}
		else {
			/* Error */
		printf("Prepared Statement Error: %s\n", $this->conn->error);
		} 		
	}
	
	function return_result($query){
	  if($result = $this->conn->query($query)){
	       return $result;
	  }
	
	}
}	
?>
