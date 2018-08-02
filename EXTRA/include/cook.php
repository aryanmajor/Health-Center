<?php
	/**
	*Sets cookie for login confirmation
	*
	*It is helpful to redirect to
	*doctor's page after checking
	*if doctor logged in
	*
	*@param Doctor Name
	*@param Doctor User ID
	*
	*@author Roghaari Team
	*/
	class settingCookie{
		public $DocName;
		public $DocUserID;
		public function cook_doc(){
			$message;
			$salt1="we2020will2020rock";
			$salt2="plz20dont21hack";
			$message=hash('ripemd128',"$salt1$this->DocUserID$salt2");
			$message=$this->DocName.";".$message.";".$this->DocUserID;
			setcookie('username',$message,time()+(30*24*60*60));
		}
	}
	
	/**
	*Check if cookie is available for login confirmation
	*
	*It is helpful to redirect to
	*doctor's page after checking
	*if doctor logged in
	*
	*returns Array containing Doctor Name and Doctor UserID
	*
	*@author Roghaari Team
	*/
	class checkingCookie{
		public function check_doc(){
			if(!isset($_COOKIE['username'])){
				return 0;
			}
			else{
				$cookieVal=$_COOKIE['username'];
				$cookieArr=explode(";",$cookieVal);
				$salt1="we2020will2020rock";
				$salt2="plz20dont21hack";
				$corrVal=hash('ripemd128',"$salt1$cookieArr[2]$salt2");
				if(strcmp($corrVal,$cookieArr[1])!=0){
					return 0;
				}
				else{
					$ans=array($cookieArr[0],$cookieArr[2]);
					return $ans;
				}
			}
		}
	}
	
?>