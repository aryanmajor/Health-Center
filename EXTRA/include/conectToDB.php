<?php
	/**
	*program to connect to database
	*
	*help in connecting after extending
	*or inheriting it
	*
	*@author Roghaari Team
	*
	*@param table name
	*
	*@returns 0 when error
	*@returns 1 when job is done
	*/
	require_once "database.php";
	class mySQLconn{
		public $conn;
		public function connToDB(){
			$this->conn=new mysqli($hn,'root','SQLroot','Dispensary');
			if(($this->conn)->connect_error){
				return 0;
			}
			else{
				return 1;
			}
		}
	}
?>