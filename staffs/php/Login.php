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
	class LoginStaff{
        public $userID;
        protected $pass;
        protected $cPASS;
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
            
            if(!filter_has_var(INPUT_POST,"userID")||$_POST['userID']==NULL){
                $LIerror['userID']="Enter User I.D.";
                $this->errorF=1;
            }
            elseif(!filter_input(INPUT_POST,"userID",FILTER_VALIDATE_EMAIL)){
                $LIerror['userID']="Enter Correct User I.D.";
                $this->errorF=1;
            }
            
            if(!filter_has_var(INPUT_POST,"pass")||$_POST['pass']==NULL){
                $LIerror['pass']="Enter Password";
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
            
            $this->userID=htmlentities(($this->conn)->real_escape_string($_POST['userID']));
            $this->pass=htmlentities(($this->conn)->real_escape_string($_POST['pass']));
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
            $query="SELECT staff_password FROM StaffInfo WHERE staff_email=?";
            $stmt=($this->conn)->prepare($query);
            $stmt->bind_param('s',$this->userID);
            $stmt->execute();
            $stmt->store_result();
                                
            if($stmt->num_rows){
                $stmt->bind_result($this->cPASS);
                $stmt->fetch();
                if(password_verify($this->pass,$this->cPASS)){
                    //correct User ID And Pass
                    $stmt->close();
                    ($this->conn)->close();
                    session_start();
                    $_SESSION['StaffLogIN']=200;
                    
                    //Create Session
                    $session_create=$this->CreateSession();
                    if($session_create!=200){
                        //Session Creation Failed
                        $_SESSION['StaffLogIN']=0;
                        session_destroy();
                        
                        $LIerror['logInfo']="Some Technical Error Were Found.";
                        return 0;
                    }
                    else{
                        //Logged And Session Successfuly Created
                        return 200;
                    }
                }
                else{
                    //correct User ID But Wrong Password
                    $LIerror['logInfo']="Wrong User ID And Password Combination.";
                    $stmt->close();
                    ($this->conn)->close();
                    return 0;
                }
            }
            else{
                //Wrong User ID
                $LIerror['logInfo']="Wrong User ID And Password Combination.";
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
        *@return '200' If Session Is Created
        *@return '0' If UnAuthorized Access Is Found
        */
        protected function CreateSession(){
            if($_SESSION['StaffLogIN']!=200){
                $_SESSION['StaffLogIN']=0;
                session_destroy();
                return 0;
                //Un Authorized Access
            }
            $this->connToDB();
            //prepared statements
            $query="SELECT staff_name,staff_ID 
                    FROM StaffInfo WHERE staff_email=?";
            $stmt=($this->conn)->prepare($query);
            $stmt->bind_param('s',$this->userID);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows){
                $stmt->bind_result($name,$ID);
                $stmt->fetch();
                
                $_SESSION['name']=htmlentities($name);
                $_SESSION['ID']=htmlentities($ID);
                $_SESSION['email']=$this->userID;

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
                $query="SELECT staff_email FROM StaffInfo WHERE staff_session=?";
                $stmt=($this->conn)->prepare($query);
                $stmt->bind_param('s',$CookData);
                $stmt->execute();
                
                $stmt->store_result();
                if($stmt->num_rows){

                    $stmt->bind_result($eMail);
                    $stmt->fetch();
                    $this->userID=htmlentities(($this->conn)->real_escape_string($eMail));
                    $stmt->close();
                    ($this->conn)->close();
                    
                    //session_id Found
                    $_SESSION['StaffLogIN']=200;
                    
                    $session_create=$this->CreateSession();
                    if($session_create!=200){
                        //Failed To Create Session
                        $_SESSION['StaffLogIN']=0;
                        session_destroy;
                        return 0;
                    }
                    else{
                        //Session Created
                        return 200;
                    }
                }
                else{
                    //Login Required
                    $stmt->close();
                    ($this->conn)->close();
                    return 0;
                }
            }
            else{
                //Cookie Not Found
                //Login Not Allowed
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
            if(isset($_SESSION['StaffLogIN'])){
                if($_SESSION['StaffLogIN']===200){
                    //LogIn Found
                    $cookData=hash('ripemd128',bin2hex(random_bytes(8)));
                    $cookRep=setcookie('user',$cookData,(time()+(60*60*24*7)),'/',null,null,true);
                    
                    if($cookRep){
                        //Cookie Was Created
                        //Insert Session Key
                        $this->connToDB();
                        $query="UPDATE StaffInfo SET
                            staff_session=? WHERE staff_email=?";
                        $stmt=($this->conn)->prepare($query);
                        $stmt->bind_param('ss',$cookData, $this->userID);
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