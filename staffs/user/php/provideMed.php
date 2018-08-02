<?php

    $Continue=0;
    if((!isset($_SESSION['StaffLogIN']))||($_SESSION['StaffLogIN']!=200)){

        require '../Login.php';
        $test=new LoginStaff;
        $Rep=$test->CheckCookie();  //Checks Cookie
        if($Rep!=200){
            //Auto-Login Failed
            $Continue=0;
        }
        else{
            $Continue=201;
        }
        unset($test);                
    }
    else{
        $Continue=201;
    }

    if($Continue!=201){
        $_SESSION['StaffLogIN']=0;
        session_destroy;
        ob_start();
        header("Location: ../index.php");
        exit();
    }
            
        //Login Confirmed
        /*
        *Variable Declaration
        *
        *$INSerror -> Error While Validating Form
        */
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(E_ALL);
        $INSerror=array("insertion"=>"");

        if($_SERVER['REQUEST_METHOD']=='GET'){
        ?>
            <div class="w3-row-padding">
                <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-purple"></i> Provide Medicine</b></p>
                <hr>
            <div class="w3-padding-24">
            <form method="post" action="" class="w3-container">
            <label class="w3-text-purple"><b>  Scholar ID:</b></label><br><br>
                <div class="w3-half">
                    <input type="text" name="schID" placeholder="ex: 1615100" class="w3-input w3-border" required id="schID">
                </div>
                
                <div class="w3-half">
                    <button class="w3-button w3-round-large w3-block w3-white w3-border w3-border-purple w3-hover-purple w3-text-purple" onclick="findRegMed();" type="button">Fetch Info</button>
                </div>
            <br>
            <br>
                
            <div class="w3-padding-24" style="display:none;">
                <input type="hidden" 
               <?php
                    $Formnm='session_val';
                    $bytes=random_bytes(8);
                    $Formval=bin2hex($bytes);
                    $_SESSION['form_session_key']=$Formval;
                    $Formval=hash('ripemd128',$Formval);
                    echo "name='".$Formnm."' value='".$Formval."'";
                ?>>
                <p><button class="w3-button w3-round-xlarge w3-block w3-white w3-border w3-border-purple w3-hover-purple w3-text-purple">
                    <i class="fa fa-cloud-upload fa-fw w3-margin-right w3-xlarge"></i>  Submit And Add Record
                    </button></p>
            </div>
            </form>
                               
            </div>
    </div>
<!-- SCRIPT TIME -->
<script src="../scripts/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    function findRegMed(){
        var schID=$("#schID").val();
        var xhttp=new XMLHttpRequest();
        xhttp.onreadystatechange=function(){
            if(xhttp.readyState==4 && xhttp.status==200){
                alert(this.responseText);
                return false;
            }
            else{
                alert(xhttp.readyState+"  "+ xhttp.status);
            }
        };
        xhttp.open("POST","php/getMedName.php",true);
        xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded")
        xhttp.send("schID="+schID);
    }
</script>
		<?php
			}

        elseif($_SERVER['REQUEST_METHOD']=='POST'){
                
				/*
				*Class To insert into VisitInfo
				*
                *The Required Operations Are Encaptulated Into Functions
                *Involving connection, validation, sanitization
                *insertion
                *
				*@author Roghaari Team
				*
				*@param input from the submitted form
				*
				*/
                
				class InsToDB{
                    
                    public $medName;
                    public $medQ;
                    public $medS;
                    public $medType;
                    
                    public $session_val;
                    public $errorF=0;  //'0' by default Turns To '1' On Error
                    protected $conn;
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
                    
                    public function validForm(&$INSerror){
            
                        if(!filter_has_var(INPUT_POST,"medName")||$_POST['medName']==NULL){
                            $INSerror['insertion']="Enter Name.";
                            $this->errorF=1;

                        }
                        if(!filter_has_var(INPUT_POST,"medS")||$_POST['medS']==NULL){
                            $INSerror['insertion']="Enter Number Of Sets.";
                            $this->errorF=1;
                        }
                        if(!filter_input(INPUT_POST,"medS",FILTER_VALIDATE_INT)){
                            $INSerror['insertion']="Enter Correct Number Of Sets.";
                            $this->errorF=1;
                        }
                        
                        if(!filter_has_var(INPUT_POST,"medType")){
                            $INSerror['insertion']="Stay There.";
                            $this->errorF=1;
                        }
                        else{
                            if($_POST==='1'){
                                if(!filter_has_var(INPUT_POST,"medQ")||$_POST['medQ']==NULL){
                                    $INSerror['insertion']="Enter Number Of Quantity.";
                                    $this->errorF=1;
                                }
                                if(!filter_input(INPUT_POST,"medS",FILTER_VALIDATE,INT)){
                                    $INSerror['insertion']="Enter Correct Number Of Tablet.";
                                    $this->errorF=1;
                                }
                            }
                        }
                        if(!filter_has_var(INPUT_POST,"session_val")){
                            $INSerror['insertion']="Stay There.";
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
 
                $this->medName=htmlentities(($this->conn)->real_escape_string($_POST['medName']));
                $this->medS=htmlentities(($this->conn)->real_escape_string($_POST['medS']));
                $this->medType=htmlentities(($this->conn)->real_escape_string($_POST['medType']));
                if($this->medType==='1'){
                    $this->medQ=htmlentities(($this->conn)->real_escape_string($_POST['medQ']));
                }
                $this->session_val=htmlentities(($this->conn)->real_escape_string($_POST['session_val']));
        
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
                *Function to Sanitize Form
                *
                *Uses real_escape_string, htmlentities
                *It Sanitizes The User Input Data
                *Insert Sanitized Data in the Variables
                *
                *@param POST Superglobal Variable
                *
                *@return '200' If Success
                *@return '0' If Failed
                */
                public function InsToMed(){
                    if(!isset($_SESSION['StaffLogIN'])||$_SESSION['StaffLogIN']!=200){
                        //Malicious Activity
                        return 20;
                    }
                    if(strcmp($this->session_val,(hash('ripemd128',$_SESSION['form_session_key'])))!=0){
                        //Malicious Activity
                        return 10;
                    }
                    $this->connToDB();
                    $query="INSERT INTO MedInfo VALUES(?,?,?)";
                    $stmt=($this->conn)->prepare($query);
                    $stmt->bind_param('isi',$ID,$this->medName,$quantity);
                    $ID="";
                    $this->medName=strtolower($this->medName);
                    if($this->medType==='1'){
                        $quantity=$this->medQ*$this->medS;
                    }
                    else{
                        $quantity=$this->medS;
                    }
                        
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
                }//End Of Insertion Function
                
			}//End Of Class
                
            $test=new InsToDB;
            $test->validForm($INSerror);
            if($test->errorF!=0){
                //Error Occurred
                unset($test);
                echo '<br><hr><h2 class="w3-text-grey w3-padding-16 w3-center"><i class="fa fa-calendar-check-o fa-fw w3-margin-right w3-xlarge w3-text-teal"></i>  Go Back '.$INSerror["insertion"].'</h2><hr><br>';
                exit();
            }
            else{
                //No Error Found
                $test->sanitizeForm();
                $InsRep=$test->InsToMed();
                if($InsRep!=200){
                    //Insertion Failed
                    $INSerror['insertion']="And Try Again.";
                    
                    echo '<br><hr><h2 class="w3-text-grey w3-padding-16 w3-center"><i class="fa fa-exclamation-triangle fa-fw w3-margin-right w3-xlarge w3-text-teal"></i>  Go Back '.$INSerror["insertion"].$InsRep.$test->session_val.'++<br>++'.hash('ripemd128',$_SESSION['form_session_key']).'</h2><hr><br>';
                    unset($test);
                    exit();
                }
                else{
                    unset($test);
                    $INSerror['insertion']="Form Was Submitted";
                    echo '<br><hr><h2 class="w3-text-grey w3-padding-16 w3-center"><i class="fa fa-check-square-o fa-fw w3-margin-right w3-xlarge w3-text-teal"></i>  '.$INSerror["insertion"].'</h2><hr><br>';
                }
            }
                
        }//End Of POST Section
			
    ?>