<?php
    ini_set('display_errors',1);
            ini_set('display_startup_errors',1);
            error_reporting(E_ALL);
    /*
    *Class to Register Students Step-Wise
    *
    *The operations to be performed will be
    *encaptulated into methods of this class
    *Namely: Verification, Sanitization, ATP Generation And Insertion
    *
    *@author Roghaari Team
    *@param : All Input
    *
    */
    class RegisterStud{
        public $param=array("schID"=>"","name"=>"","height"=>"","weight"=>"","bmi"=>"",
                           "emailID"=>"","bldgrp"=>"","hostel"=>"","rnum"=>"","dob"=>"",
                           "branch"=>"","batch"=>"");
        public $errorF=0; //turns to 1 if Error is Found
        protected $atp;
        protected $conn;
        /*
        *Function To Verify Whether Input Was Provided Or Not
        *
        *Uses FILTER_HAS_VAR function maily
        *to find whether Correct Input Was Provided
        *or Not
        *
        *@param array Named $SUerror
        *
        */
        public function VerifyDet(&$SUerror){
            if(!filter_has_var(INPUT_POST,"schID")||$_POST["schID"]==NULL){
                $SUerror['schID']="Enter Scholar I.D.";
                $this->errorF=1;
            }
            if(!filter_has_var(INPUT_POST,"name")||$_POST["name"]==NULL){
                $SUerror['name']="Enter Name.";
                $this->errorF=1;
            }
            if(!filter_has_var(INPUT_POST,"weight")||($_POST["weight"]==NULL)){
                $SUerror['weight']="Enter Weight.";
                $this->errorF=1;
            }
            elseif(!filter_input(INPUT_POST,"weight",FILTER_VALIDATE_FLOAT)){
                $SUerror['weight']="Weight Must Be In Decimal or Numeral.";
                $this->errorF=1;
            }
            if(!filter_has_var(INPUT_POST,"height")||($_POST["height"]==NULL)){
                $SUerror['height']="Enter Height.";
                $this->errorF=1;
            }
            elseif(!filter_input(INPUT_POST,"height",FILTER_VALIDATE_FLOAT)){
                $SUerror['height']="Height Must Be In Decimal or Numeral.";
                $this->errorF=1;
            }
            if(!filter_has_var(INPUT_POST,"emailID")||($_POST["emailID"]==NULL)){
                $SUerror['email']="Enter Email ID.";
                $this->errorF=1;
            }
            elseif($_POST['emailID']&&!filter_input(INPUT_POST,"emailID",FILTER_VALIDATE_EMAIL)){
                $SUerror['emailID']="Enter Correct Email I.D.";
                $this->errorF=1;
            }
            $choice=array("A+","B+","A-","B-","O+","O-","AB+","AB-");
            if(!filter_has_var(INPUT_POST,"bldgrp")){
                $SUerror['bldgrp']="Choose A BloodGroup.";
                $this->errorF=1;
            }
            elseif(!in_array($_POST['bldgrp'],$choice)){
                $SUerror['bldgrp']="Choose An Option From Given One.";
                $this->errorF=1;
            }
            if(!filter_has_var(INPUT_POST,"hostel")||($_POST["hostel"]==NULL)){
                $SUerror['hostel']="Enter A Hostel Name.";
                $this->errorF=1;
            }
            if(!filter_has_var(INPUT_POST,"dob")||($_POST["dob"]==NULL)){
                $SUerror['dob']="Enter Your Date Of Birth.";
                $this->errorF=1;
            }
            $datearr=explode("-",$_POST['dob']);
            if(!checkdate($datearr[1],$datearr[2],$datearr[0])){
                $SUerror['dob']="Enter Correct Date Of Birth.";
                $this->errorF=1;
            }
        }
        /*
        *Protected Function To Connect To Database
        *
        */
        protected function connToDB(){
            $this->conn=new mysqli("localhost","root","SQLroot","Dispensary");
            if(($this->conn)->connect_error){
                ($this->conn)->close();
                http_response_code(500);
                exit();
            }
        }
        /*
        *Function To Insert Provided Value Into An Array
        *
        *This Function Also Sanitizes Input On the way
        *The Stored value can be used to re-show the form
        *along with user previous input
        *
        *THIS FUNCTION WILL COME IN USE IF AND ONLY IF THERE IS ANY ERROR FOUND IN VALIDATION
        *
        *@param An Array SUprovVal
        *
        */
        public function ProvidedVal(&$SUprovVal){
            $this->connToDB();
            $SUprovVal['schID']=htmlentities(($this->conn)->real_escape_string($_POST['schID']));
            $SUprovVal['name']=htmlentities(($this->conn)->real_escape_string($_POST['name']));
            $SUprovVal['height']=htmlentities(($this->conn)->real_escape_string($_POST['height']));
            $SUprovVal['weight']=htmlentities(($this->conn)->real_escape_string($_POST['weight']));
            $SUprovVal['bldgrp']=htmlentities(($this->conn)->real_escape_string($_POST['bldgrp']));
            $SUprovVal['emailID']=htmlentities(($this->conn)->real_escape_string($_POST['emailID']));
            $SUprovVal['hostel']=htmlentities(($this->conn)->real_escape_string($_POST['hostel']));
            $SUprovVal['rnum']=htmlentities(($this->conn)->real_escape_string($_POST['rnum']));
            $SUprovVal['dob']=htmlentities(($this->conn)->real_escape_string($_POST['dob']));
                
            ($this->conn)->close();//closes The Connection
        }
        
        /*
        *Function To Insert Provided Value Into The Class Variable Array
        *
        *This Function Also Sanitizes Input On the way
        *The Stored value is Used To Insert The Data Into DB
        *
        *THIS FUNCTION WILL COME IN USE IF AND ONLY IF THERE WAS NO ERROR FOUND IN VALIDATION
        *
        */
        public function AssignVal(){
            $this->connToDB();
            //public $param=array("schID"=>"","height"=>"","weight"=>"","bmi"=>"",
                           //"bldgrp"=>"","hostel"=>"","rnum"=>"","dob"=>"",
                           //"branch"=>"","batch"=>"");
            $this->param['schID']=htmlentities(($this->conn)->real_escape_string($_POST['schID']));
            $this->param['name']=htmlentities(($this->conn)->real_escape_string($_POST['name']));
            $this->param['height']=round(htmlentities(($this->conn)->real_escape_string($_POST['height'])),2);
            $this->param['weight']=round(htmlentities(($this->conn)->real_escape_string($_POST['weight'])),2);
            $this->param['bmi']=($this->param['weight']/($this->param['height']*$this->param['height']))*100*100;
            $this->param['bldgrp']=htmlentities(($this->conn)->real_escape_string($_POST['bldgrp']));
            $this->param['emailID']=htmlentities(($this->conn)->real_escape_string($_POST['emailID']));
            $this->param['hostel']=htmlentities(($this->conn)->real_escape_string($_POST['hostel']));
            $this->param['rnum']=htmlentities(($this->conn)->real_escape_string($_POST['rnum']));
            $this->param['dob']=htmlentities(($this->conn)->real_escape_string($_POST['dob']));
                        
            $this->atp=mt_rand(1000,9999);//Random Number ATP (HIGHLY CONFIDENTIAL)
            
            ($this->conn)->close();//close the DB Connection
            
            $batchP=substr($this->param['schID'],0,2);
            $this->param['batch']=$batchP+2004;
            $branchP=substr($this->param['schID'],2,1);
            $this->param['branch']=$branchP;
        }
        /*
        *Function To Commence Insertion Of Health Related Data Into Table "StudHealth"
        *
        *Basically, We Will Update the data already present in The Table "StudHealth"
        *Find The Record With Matching Scholar ID
        *Update Data Which is Already Sanitized
        *
        *@returns 100 if Data Is Updated But Mail Could Not Be Sent
        *@returns 200 if Data Is Updated And Mail Is Sent
        *@returns 0 Otherwise
        *
        */
        public function CommenceIns(){
            $resI=$this->ConfidentialIns();
            if($resI==0){
                return 0;
            }
            $this->connToDB();
            $query="UPDATE StudHealth SET
            stud_height=?,
            stud_weight=?,
            stud_BMI=?,
            stud_bloodgrp=?,
            stud_hostel=?,
            stud_roomNum=?,
            stud_DOB=?,
            stud_branch=?,
            stud_batch=? WHERE scholar_id=?";
            $stmt=($this->conn)->prepare($query);
            $stmt->bind_param('dddsssssss',$this->param['height'], $this->param['weight'],
                              $this->param['bmi'], $this->param['bldgrp'],
                              $this->param['hostel'], $this->param['rnum'], 
                              $this->param['dob'], $this->param['branch'], 
                              $this->param['batch'], $this->param['schID']);

            $stmt->execute();
            if($stmt->affected_rows){
                if($this->MailATP()){
                    $stmt->close();
                    ($this->conn)->close();
                    return 200;
                }
                else{
                    $stmt->close();
                    ($this->conn)->close();
                    return 100;
                }
            }
            else{
                $stmt->close();
                ($this->conn)->close();
                return 0;
            }
        }
        
        /*
        *Function To Commence Insertion Of Confidential Data Into The  "StudInfo"
        *
        *Basically, We Will Update the data already present in The "StudInfo"
        *Find The Record With Matching Scholar ID
        *Update Data Which is Already Sanitized
        *
        *@returns 200 if Data Was Inserted
        *@returns 0 Otherwise
        *
        */
        protected function ConfidentialIns(){
            $this->connToDB();
            $query='INSERT INTO StudInfo VALUES(?,?,?)';
            $stmt=($this->conn)->prepare($query);
            $stmt->bind_param('sss',$this->param['schID'],$hashATP,$session);
            $hashATP=password_hash($this->atp,PASSWORD_BCRYPT); //The Encryption Of ATP
            $session="";    //We Do Not Need It Anymore
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
        /*
        *Function To Send Mail To The User
        *
        *The Mail Contains The UserID And ATP
        *Of the person
        *
        *@return 1 if Mail Was Sent
        *@return 0 if Mail Was Not Sent
        *
        */
        public function MailATP(){
            require 'PHPMailer/PHPMailerAutoload.php';
            $mail=new PHPMailer();
            //$mail->SMTPDebug=2;
            //Set SMTP Host Name
            $mail->Host="smtp.zoho.com";
            $mail->isSMTP();
            $mail->SMTPAuth=true;
            //Set UserName And Password
            $mail->Username="services@roghaari.com";
            $mail->Password="Services@roghaari";
            //Set Type Of Security
            $mail->SMTPSecure="TLS";
            $mail->Port=587;
            //Set Subject
            $mail->Subject="Authentication And A.T.P.";
            //Set HTML to True
            $mail->isHTML(true);
            //Set Body
            $mail->Body=$this->setBody();
            //Set From and Receiver
            $mail->setFrom('services@roghaari.com','Roghaari');
            $mail->addAddress($this->param['emailID'],'');
            if($mail->send()){
                return 1;
            }
            else{
                return 0;
            }
        }
        /*
        *Function To Generate Body Of The Mail
        *
        *The Mail Contains The UserID And ATP
        *Of the person
        *
        *@return Body Of The Mail
        *
        */
        protected function setBody(){
            $Mbody="Hi There Mr. ".$this->param['name'].",<br><br>
                We are happy to tell you have successfully registered yourself<br>
                for Health Center, N.I.T. Silchar.
                <br><br><br>
                Now you can access our services using the following login credentials: <br>
                <ul style='list-style-type: none;'>
                <li>User ID:- ".$this->param['schID']."</li>
                <li>Password:- ".$this->atp."</li>
                </ul>
                <br><br>
                We will be happier to help at feedback@roghaari.com<br>
                regarding anything you might need.
                <br><br>
                <h4 style='color:#af1700;'>Please do not reply back as this is a Computer Generated E-Mail.</h4>";
            return $Mbody;
        }
    }
?>