<?php
    /*
    *class to login
    *
    *Steps are encaptulted into Functions
    *Sanitize, Validate, Check With Database,
    *Create Cookie, Session Creation
    *
    *@author Roghaari Team
    *
    */
	class LoginStud{
        public $schID;
        protected $ATP;
        protected $cATP;
        protected $conn;
        /*
        *Variable To Find Type Of Error
        *
        *errorF remains 0 if there is no error
        *errorF turns to '1' if any error is found
        *
        */
        public $errorF=0;
        /*
        *Function to Validate Form
        *
        *Uses filter_has_var
        *if The input is not found then the
        *error gets registered in the Error Array
        *
        *@param POST Superglobal Variable
        *@return 
        */
        public function validForm(&$LIerror){
            
            if(!filter_has_var(INPUT_POST,"schID")||$_POST['schID']==NULL){
                $LIerror['schID']="Enter Scholar I.D.";
                $this->errorF=1;
            }
            
            if(!filter_has_var(INPUT_POST,"satps")||$_POST['satps']==NULL){
                $LIerror['ATP']="Enter ATP";
                $this->errorF=1;
            }
        }
        /*
        *Function to Sanitize Form
        *
        *Uses real_escape_string, htmlentities
        *It Sanitizes The User Input Data
        *Insert Sanitized Data in the Variables
        *
        *@param POST Superglobal Variable
        *
        */
        public function sanitizeForm(){
            $this->connToDB();
            
            $this->schID=htmlentities(($this->conn)->real_escape_string($_POST['schID']));
            $this->ATP=htmlentities(($this->conn)->real_escape_string($_POST['satps']));
            ($this->conn)->close();
        }
        
        /*
        *Starts Connection With Database
        *
        *Stores the connection in $conn variable
        *
        *@return ERR_500 if connection fails
        *
        */
        protected function connToDB(){
        $this->conn=new mysqli("localhost","root","SQLroot","Dispensary");
            if(($this->conn)->connect_error){
                http_response_code(500);
            }
        }
        
        /*
        *Checks if Login Info Is Correct Or Wrong
        *
        *Connects With Database To Validate Inputs
        *
        *@returns 0 if Wrong info
        *@returns 200 if Correct Info
        *
        */
        public function SynchEntries(&$LIerror){
            $this->connToDB();
            //used prepared statements
            $query="SELECT stud_ATP FROM StudInfo WHERE scholar_id=?";
            $stmt=($this->conn)->prepare($query);
            $stmt->bind_param('s',$this->schID);
            $stmt->execute();
            $stmt->store_result();
                                
            if($stmt->num_rows){
                $stmt->bind_result($this->cATP);
                $stmt->fetch();
                if(password_verify($this->ATP,$this->cATP)){
                    //correct Scholar ID And ATP
                    $stmt->close();
                    ($this->conn)->close();
                    
                    session_start();
                    $_SESSION['StudLogIN']=200;
                    
                    $session_create=$this->CreateSession();
                    if($session_create!=200){
                        //Session Creation Failed
                        $_SESSION['StudLogIN']=0;
                        session_destroy();
                        
                        $LIerror['logInfo']="Some Technical Error Were Found.";
                        return 0;
                    }
                    else{
                        //Logged And Session Successfuly Created
                        return 200;
                    }
                    
                }//End Of Successfull Login
                else{
                    //correct Scholar ID But Wrong ATP
                    $LIerror['logInfo']="Wrong Scholar ID And ATP Combination.";
                    $stmt->close();
                    ($this->conn)->close();
                    return 0;
                }
            }
            else{
                //Wrong Scholar ID
                $LIerror['logInfo']="Wrong Scholar ID And ATP Combination.";
                $stmt->close();
                ($this->conn)->close();
                return 0;
            }
        }
                            
        /*
        *Function To Create Session
        *
        *Connects To DB to access all student's
        *Info and stores in session variables
        *
        */
        protected function CreateSession(){
            
            if($_SESSION['StudLogIN']!=200){     //Checking For Authorized Access
                $_SESSION['StudLogIN']=0;
                session_destroy();
                return 0;
                //Un Authorized Access
            }
            $this->connToDB();
            //prepared statements
            $query="SELECT stud_name, stud_height, stud_weight, 
                    stud_BMI, stud_bloodgrp, stud_hostel, 
                    stud_roomNum, stud_DOB, stud_branch, 
                    stud_batch, stud_email 
                    FROM StudHealth WHERE scholar_id=?";
            $stmt=($this->conn)->prepare($query);
            $stmt->bind_param('s',$this->schID);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows){

                $stmt->bind_result($name,$height,$weight,
                                   $BMI,$BGroup,$hostel,$RNum,$DOB,$branch,$batch,$email);
                $stmt->fetch();
                $stmt->close();
                ($this->conn)->close();
                $_SESSION['name']=htmlentities($name);
                $_SESSION['height']=htmlentities($height);
                $_SESSION['weight']=htmlentities($weight);
                $_SESSION['BMI']=htmlentities($BMI);
                $_SESSION['BGroup']=htmlentities($BGroup);
                $hostelArr=array("Hostel Number 1","Hostel Number 2","Hostel Number 3","Hostel Number 4","Hostel Number 5","Hostel Number 6","Hostel Number 7","Hostel Number 8","P.G. Hostel","Girls Hostel 1","Girl Hostel 2");
                $_SESSION['hostel']=htmlentities($hostelArr[$hostel-1]);
                $_SESSION['RNum']=htmlentities($RNum);
                $_SESSION['DOB']=htmlentities($DOB);
                $_SESSION['branch']=htmlentities($branch);
                $_SESSION['batch']=htmlentities($batch);
                $_SESSION['email']=htmlentities($email);
                $_SESSION['schID']=$this->schID;
                return 200;
            }                                
            else{
                $stmt->close();
                ($this->conn)->close();
                return 0;
            }
        }
        
        /*
        *Function To Check Availability Of Cookie
        *
        *If Cookie Was Found, Then We Will Continue To Validation
        *If Validation Is Found To Be Successful,
        *LogIn Would be Confirmed
        *Session Might Be Created
        *
        *@return '200' If Cookie Was Found In Correct Condition
        *@return '0' OtherWise
        */
        public function CheckCookie(){
            if(isset($_COOKIE['user'])){            //Checks Whether Cookie Exists
                
                $this->connToDB();
                
                $CookData=htmlentities(($this->conn)->real_escape_string($_COOKIE['user']));
                
                $query="SELECT scholar_id FROM StudInfo WHERE st_session_key=?";
                $stmt=($this->conn)->prepare($query);
                $stmt->bind_param('s',$CookData);
                $stmt->execute();
                
                $stmt->store_result();
                if($stmt->num_rows){
                    $stmt->bind_result($sID);
                    $stmt->fetch();
                    
                    $this->schID=htmlentities(($this->conn)->real_escape_string($sID));

                    $stmt->close();
                    ($this->conn)->close();
                    
                    //session_id Found
                    session_start();
                    $_SESSION['StudLogIN']=200;
                    
                    $session_create=$this->CreateSession();
                    if($session_create!=200){
                        //Failed To Create Session
                        $_SESSION['StudLogIN']=0;
                        session_destroy;
                        return 0;
                    }
                    else{
                        //Session Created
                        return 200;
                    }
                }
                else{
                    //No Such ID matched
                    $stmt->close();
                    ($this->conn)->close();
                    return 0;
                }                    
            }//end of isset($_COOKIE)
            else{
                //Cookie Not Found
                return 0;
            }
        }
        
        /*
        *Function To Creation Cookie
        *
        *We Will Create Cookie 
        *So that it can be used again
        *
        *@return '200' If Cookie Was Created
        *@return '0' OtherWise
        */
        public function CreateCook(&$LIerror){
            if(isset($_SESSION['StudLogIN'])){
                if($_SESSION['StudLogIN']===200){
                    //LogIn Found
                    $cookData=hash('ripemd128',bin2hex(random_bytes(8)));
                    $cookRep=setcookie('user',$cookData,(time()+(60*60*24*7)),'/',null,null,true);
                    
                    if($cookRep){
                        //Cookie Was Created
                        //Insert Session Key
                        $this->connToDB();
                        $query="UPDATE StudInfo SET
                            st_session_key=? WHERE scholar_id=?";
                        $stmt=($this->conn)->prepare($query);
                        $stmt->bind_param('ss',$cookData, $this->schID);
                        $stmt->execute();
                        
                        if($stmt->affected_rows){
                            $stmt->close();
                            ($this->conn)->close();
                            return 200;
                        }
                        else{
                            $stmt->close();
                            ($this->conn)->close();
                            return 0;
                        }
                    }
                }
                else{
                    $LIerror['logInfo']="You Need To LogIn Again";
                    session_destroy();
                    return 0;
                }
            }
            else{
                session_destroy();
                $LIerror['logInfo']="You Need To LogIn Again";
                return 0;
            }
        }
    }
?>