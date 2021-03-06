		<?php

    $Continue=0;
    if((!isset($_SESSION['DocLogIN']))||($_SESSION['DocLogIN']!=200)){

        require '../../php/Login.php';
        $test=new LoginDoc;
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
        $_SESSION['DocLogIN']=0;
        session_destroy;
        ob_start();
        header("Location: ../../index.php");
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
                <div class="w3-half w3-animate-left w3-padding-24">
                    <p>
                <?php echo strtoupper($studInformation["name"]); //name of searched student ?>
                </p>
                <div class="NoDisp">
                    Age: <?php
                    $dobY=new DateTime($studInformation["dob"]);
                    $curY=new DateTime('today');
                    $age= $dobY->diff($curY)->y;
                    echo $age.' Years'; ?><br>
                    <p>Gender: <?php echo $studInformation["sex"]; ?><br>
                    BMI: <?php echo $studInformation["BMI"]; ?><br>
                    Blood Group: <?php echo strtoupper($studInformation["bldgrp"]); ?><br>
                        </p>
                </div>
                    </div>

                <div class="w3-half w3-animate-right w3-center w3-padding-24">
                <?php
                    $dir='../../students/user/photos/';
                    if(file_exists($dir.$studInformation["scholar_id"].'.jpeg')){
                        ?>
                    <img 
                         src="<?php echo $dir.$studInformation["scholar_id"].'.jpeg'; ?>" 
                         class="w3-round w3-border w3-border-teal" 
                         alt="<?php echo $studInformation["scholar_id"]; ?>" 
                         style="width:60%;height:50%;">
                    <?php
                    }
                    else{
                        ?>
                    <div id="image_icon">
                    <i class="fa fa-user-circle-o fa-fw w3-margin-right w3-jumbo" ></i>
                        </div>
                        <br>
                    <button onclick="setup();" class="w3-button w3-teal" style="margin-top:10px;">Upload New Picture</button>
                    
                    
                    <div class="w3-container">
                    <div id="id01" class="w3-modal">
                    <div class="w3-modal-content w3-card-4  w3-animate-right" style="width:40%;">
                      <header class="w3-container w3-teal"> 
                        <span onclick="closeCam();" 
                        class="w3-button w3-display-topright">&times;</span>
                        <h2>Upload Picture</h2>
                      </header>

                      <div class="w3-container" id="my_camera" style="padding-left:20%;">
                      </div>
                        <div class="w3-container" id="my_image" style="padding-left:20%;display: none;">
                        </div>
                        <footer class="w3-container w3-teal w3-center">
                        <p><button class="img_but" onclick="take_snapshot();">Click Picture</button>
                            <button class="img_but" style="display: none;" onclick="send_data();">Submit</button></p>
                      </footer>
                    </div>
                  </div>
                </div>
                    
                    
                    <?php
                    }
                ?>
                </div>
            </div>
    <hr>
		<div id="insertTable">
           
                <form method="post" name="VisitInfo" action="" class="w3-container">
                    <label class="w3-text-teal"><b>  Chief Complain:</b></label>
				<select name="problem">
                    
					<option value="0">Common Cold</option>
					<option value="1">Fever</option>
					<option value="2">Skin Infection</option>
					<option value="3">Muscle Pain</option>
					<option value="4">Cuts And Wounds</option>
					<option value="5">Dental Problem</option>
					<option value="6">Breathing Problem</option>
					<option value="7">Stomach Ache</option>
					<option value="8">Hair Related</option>
					<option value="9">Others</option>
				</select>
                    
				<br>
                <br>
                    <label class="w3-text-teal"><b>  Signs &amp; Symptoms:</b></label> <input type="text" name="symptoms" placeholder="Symptoms ex: anxious, warm body etc." class="w3-input w3-border">
                    <br>
                    <br>
                    
                    <label class="w3-text-teal"><b>  Provisional Diagnosis:</b></label> <input type="text" name="provDiag" placeholder="Symptoms ex: Viral Fever, Typhoid etc." class="w3-input w3-border">
                    <br>
                    <br>
                    
                    <label class="w3-text-teal"><b>  Medicine:</b></label><br>
				<table>
                <thead>
                    <tr class="w3-teal w3-text-white w3-padding-24">
                        <th>Medicine Name</th>
                        <th>Medicine Dose</th>
                        <th>Dose Days</th>
                    </tr>
                </thead>
                <tbody id="tBody">

                    <tr>
                    <td>
                        <input type="text" name="medicine[]" placeholder="Medicine Name" class="w3-input w3-border medName" >
                        <input type="hidden" name="code[]"  class="medCode">
                    </td>
                    <td>
                        <input type="text" name="dose[]" placeholder="Medicine Dose" class="w3-input w3-border ">
                    </td>
                    <td>
                        <input type="text" name="days[]" placeholder="No. Of Days" class="w3-input w3-border">
                    </td>
                    </tr>

                    <tr>
                    <td>
                        <input type="text" name="medicine[]" placeholder="Medicine Name" class="w3-input w3-border medName" >
                        <input type="hidden" name="code[]"  class="medCode">
                    </td>
                    <td>
                        <input type="text" name="dose[]" placeholder="Medicine Dose" class="w3-input w3-border ">
                    </td>
                    <td>
                        <input type="text" name="days[]" placeholder="No. Of Days" class="w3-input w3-border">
                    </td>
                    </tr>

                    <tr>
                    <td>
                        <input type="text" name="medicine[]" placeholder="Medicine Name" class="w3-input w3-border medName" >
                        <input type="hidden" name="code[]"  class="medCode">
                    </td>
                    <td>
                        <input type="text" name="dose[]" placeholder="Medicine Dose" class="w3-input w3-border ">
                    </td>
                    <td>
                        <input type="text" name="days[]" placeholder="No. Of Days" class="w3-input w3-border">
                    </td>
                    </tr>

                    <tr>
                    <td>
                        <input type="text" name="medicine[]" placeholder="Medicine Name" class="w3-input w3-border medName">
                        <input type="hidden" name="code[]"  class="medCode">
                    </td>
                    <td>
                        <input type="text" name="dose[]" placeholder="Medicine Dose" class="w3-input w3-border">
                    </td>
                    <td>
                        <input type="text" name="days[]" placeholder="No. Of Days" class="w3-input w3-border">
                    </td>
                    <td onclick="addRec();" class="addHide">
                    <i class="fa fa-plus-circle fa-fw w3-margin-right w3-xlarge w3-text-teal" style="cursor: pointer;"></i>
                    </td>
                    </tr>

                </tbody>
				</table>
                <br>
                    
                    <label class="w3-text-teal"><b>Advice Or Further Remarks:</b></label><br>
                <textarea rows=4 cols=40 maxlength="100" name="remarks" placeholder="Click To Enter Any Advice Or Remark" class="w3-input w3-border"></textarea>
                    <br>
					<input type="hidden" name="options" value="1">
                    <input type="hidden" 
                   <?php
                        $Formnm='session_val';
                        $bytes=random_bytes(8);
                        $Formval=bin2hex($bytes);
                        $_SESSION['form_session_key']=$Formval;
                        $Formval=hash('ripemd128',$Formval);
                        echo "name='".$Formnm."' value='".$Formval."'";
                    ?>>
                    <p><button class="w3-button w3-round-xlarge w3-block w3-white w3-border w3-border-teal w3-hover-teal w3-text-teal">
                        <i class="fa fa-cloud-upload fa-fw w3-margin-right w3-xlarge"></i>  Submit And Add Record
                        </button></p>
                    
                    </form>
            
            </div>                   

		<?php
			}
			elseif($_SERVER['REQUEST_METHOD']=='POST'){
                
                class InsToDB{
                    
                    public $problem;
                    public $symptoms;
                    public $remarks;
                    public $provDiag;
                    public $medicine=array();
                    protected $session_val;
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
            
                        if(!filter_has_var(INPUT_POST,"symptoms")){
                            $INSerror['insertion']="Enter At Least One Symptoms.";
                            $this->errorF=1;

                        }
                        if(!filter_has_var(INPUT_POST,"problem")){
                            $INSerror['insertion']="Choose At Least One Problem.";
                            $this->errorF=1;
                        }
                        if(!filter_has_var(INPUT_POST,"medicine")){
                            $INSerror['insertion']="Enter At Least One Medicine.";
                            $this->errorF=1;
                        }
                        if(!filter_has_var(INPUT_POST,"dose")){
                            $INSerror['insertion']="Enter Dose.";
                            $this->errorF=1;
                        }
                        if(!filter_has_var(INPUT_POST,"days")){
                            $INSerror['insertion']="Enter Days.";
                            $this->errorF=1;
                        }
                        if(!filter_has_var(INPUT_POST,"code")){
                            $INSerror['insertion']="Stay There";
                            $this->errorF=1;
                        }
                        if(!filter_has_var(INPUT_POST,"remarks")){
                            $INSerror['insertion']="Enter Some Remark.";
                            $this->errorF=1;
                        }
                        if(!filter_has_var(INPUT_POST,"provDiag")){
                            $INSerror['insertion']="Enter Some Provisional Diagnosis.";
                            $this->errorF=1;
                        }
                        if(!filter_has_var(INPUT_POST,"options")){
                            $INSerror['insertion']="Stay There.";
                            $this->errorF=1;
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

                        $this->problem=htmlentities(trim(($this->conn)->real_escape_string($_POST['problem'])));
                        $this->symptoms=htmlentities(trim(($this->conn)->real_escape_string($_POST['symptoms'])));
                        $this->remarks=htmlentities(trim(($this->conn)->real_escape_string($_POST['remarks'])));
                        $this->provDiag=htmlentities(trim(($this->conn)->real_escape_string($_POST['provDiag'])));
                        $this->session_val=htmlentities(trim(($this->conn)->real_escape_string($_POST['session_val'])));

                        $count=0;
                        foreach($_POST['medicine'] as $med){
                            if($_POST['medicine'][$count]===""){
                                continue;
                            }
                            if($_POST['code'][$count]===""){
                                $this->medicine[$count]['medName']=htmlentities(strtolower(trim(($this->conn)->real_escape_string($_POST['medicine'][$count]))));    
                            }
                            else{
                                $this->medicine[$count]['medName']=htmlentities(trim(($this->conn)->real_escape_string($_POST['code'][$count])));
                            }
                            
                            $this->medicine[$count]['medDose']=htmlentities(trim(($this->conn)->real_escape_string($_POST['dose'][$count])));
                            $this->medicine[$count]['medDays']=htmlentities(trim(($this->conn)->real_escape_string($_POST['days'][$count])));
                            
                            $count++;
                        }

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
                    public function InsToVInfo($studInformation){
                        if(!isset($_SESSION['DocLogIN'])||$_SESSION['DocLogIN']!=200){
                            //Malicious Activity
                            return 0;
                        }
                        if(strcmp($this->session_val,(hash('ripemd128',$_SESSION['form_session_key'])))!=0){
                            //Malicious Activity
                            return 0;
                        }
                        $this->connToDB();
                        $query="INSERT INTO VisitInfo VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
                        $stmt=($this->conn)->prepare($query);
                        $stmt->bind_param('siisssssisss',$studInformation['scholar_id'],
                                         $visitID,$this->problem,$this->symptoms,
                                         $InsMed,$RecMed,$studInformation['batch'],
                                         $studInformation['branch'],$TOV,$this->remarks,
                                         $DocRegNo,$this->provDiag);
                        $visitID=NULL;
                        $medArr=array();
                        foreach($this->medicine as $mArr){
                            $medArr[]=implode(',',$mArr);
                        }
                        $InsMed=implode('|',$medArr);
                        
                        $RecMed="";
                        $TOV=time();
                        $DocRegNo=$_SESSION['RegNo'];

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
                
                $InsRep=$test->InsToVInfo($studInformation);
                if($InsRep!=200){
                    //Insertion Failed
                    $INSerror['insertion']="And Try Again.";
                    unset($test);
                    echo '<br><hr><h2 class="w3-text-grey w3-padding-16 w3-center"><i class="fa fa-exclamation-triangle fa-fw w3-margin-right w3-xlarge w3-text-teal"></i>  Go Back '.$INSerror["insertion"].'</h2><hr><br>';
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