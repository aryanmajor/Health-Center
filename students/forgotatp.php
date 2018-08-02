<!DOCTYPE html>
<html>
<title>Health Center | Doctor</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href='css/w3.css'>
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {
    font-family: "Roboto", sans-serif;
    }
    body{
        background: url('pics/loginbackground5.png');
        background-size: cover;
        background-position: center;
    }
    .main_item{
        line-height: 40px;
    }
    .noDisp{
        display: none;
    }
    .option{
        cursor: pointer;
    }
    .largeContainer{
        position:absolute;
        left:20%;
        top:10%;
    }
    .smallContainer{
        height: 100%;
        padding-left: 3%;
    }
    input[type="text"],
    input[type="password"],
    input[type="date"] {
        display: block;
        box-sizing: border-box;
        margin-top: 5%;
        margin-bottom: 5%;
        margin-left: 12%;
        padding: 4px;
        width: 70%;
        height: 15%;
        border: none;
        border-bottom: 1px solid #AAA;
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        font-size: 15px;
        transition: 0.2s ease;
        border-bottom: 2px solid #0c587a;
        color: #0c587a;
    }
    .letUs{
          display: block;
          margin-bottom: 40px;
          font-size: 28px;
          color: #FFF;
          text-align: center;
        font-weight: 300;
    }
    input[type="text"]:focus,
    input[type="password"]:focus,
    input[type="date"]:focus {
        outline: none;
      border-bottom: 2px solid #0c587a;
      color: #0c587a;
      transition: 0.2s ease;
    }
    header{
        font-family: Raleway;
        font-size:25px;
        font-weight: 600;
        letter-spacing: calc(1.5px);
        margin-bottom: 10%;
    }
    label{
        font-size: 14px;
    }
    a{
        text-decoration: none;
        
    }
    .alertion{
        color:#AAA;
        font-size:14px;
        margin:7px 4px;
    }
</style>
<body class="w3-light-grey">
        <?php
            ini_set('display_errors',1);
            ini_set('display_startup_errors',1);
            error_reporting(E_ALL);
            /*
            *Variable Declaration
            *
            *$error Contains Any Error Found in submitted form
            *$provVal Contains Provided Info
            *
            */
            $error=array("schID"=>"","emailID"=>"");
            $provVal=array();
            if($_SERVER['REQUEST_METHOD']=="GET"){
                include 'php/DispReATP.php';
                exit();
            }
            elseif($_SERVER['REQUEST_METHOD']=='POST'){
                class ForgotATP{
                    public $schID;
                    public $emailID;
                    public $name;
                    protected $conn;
                    protected $NATP;
                    public $errorF=0;
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
                    
                    public function VerifyDet(&$error){
                        if(!filter_has_var(INPUT_POST,"schID")||$_POST['schID']==NULL){
                            $error['schID']="Enter Scholar I.D.";
                            $this->errorF=1;
                        }
            
                        if(!filter_has_var(INPUT_POST,"emailID")||$_POST['emailID']==NULL){
                            $error['emailID']="Enter Email ID";
                            $this->errorF=1;
                        }
                        elseif(!filter_input(INPUT_POST,"emailID",FILTER_VALIDATE_EMAIL)){
                            $error['emailID']="Enter Correct Email ID";
                            $this->errorF=1;
                        }
                    }//End Of VerifyDet Function
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
                    public function ProvidedVal(&$provVal){
                        $this->connToDB();
                        $provVal['schID']=htmlentities(($this->conn)->real_escape_string($_POST['schID']));
                        $provVal['emailID']=htmlentities(($this->conn)->real_escape_string($_POST['emailID']));
                    }
                    
                    /*
                    *Function To Insert Provided Value Into Class Variables
                    *
                    *This Function Also Sanitizes Input On the way
                    *The Stored value will be used for further processing
                    *
                    *THIS FUNCTION WILL COME IN USE IF AND ONLY IF THERE WAS NO ERROR FOUND IN VALIDATION
                    *
                    *@param An Array SUprovVal
                    *
                    */
                    public function AssignVal(){
                        $this->connToDB();
                        $this->schID=htmlentities(($this->conn)->real_escape_string($_POST['schID']));
                        $this->emailID=htmlentities(($this->conn)->real_escape_string($_POST['emailID']));
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
                    *Function To Check Existence Of Data
                    *
                    *Before Regenerating ATP We need to check if the
                    *User Is Registered Or Not
                    *
                    *@return 200 if exist
                    *@return 0 if does not exist
                    */
                    
                    public function CheckExist(){
                        $this->connToDB();
                        $query="SELECT stud_ATP FROM StudInfo WHERE scholar_id=?";
                        $stmt=($this->conn)->prepare($query);
                        $stmt->bind_param('s',$this->schID);
                        $stmt->execute();
                        $stmt->store_result();
                        if($stmt->num_rows){
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
                    *Function To SyncEnries
                    *
                    *First Verifies That Email ID Matches With Scholar ID
                    *Then Calls Function To Update New ATP
                    *Then If Updation Is Done Then Calls Mailing Function
                    *
                    *@return '0' if Email Did Not Match With Scholar ID
                    *@return '0' if Scholar ID Was Wrong
                    *@return '500' if ATP Could Not Be Updated
                    *@return '200' if Updation Was Done
                    */
                    public function SyncEntries(){
                        $this->connToDB();
                        $query="SELECT stud_email,stud_name FROM StudHealth WHERE scholar_id=?";
                        $stmt=($this->conn)->prepare($query);
                        $stmt->bind_param('s',$this->schID);
                        $stmt->execute();
                        $stmt->store_result();
                        if(!$stmt->num_rows){    //Scholar ID Did Not Match
                            $stmt->close();
                            ($this->conn)->close();
                            return 0;
                        }
                        else{                   //Scholar ID Matched
                            $stmt->bind_result($rEmailID,$this->name);
                            $stmt->fetch();
                            $stmt->close();
                            ($this->conn)->close();
                            if(!strcmp($rEmailID,$this->emailID)){
                                //Email ID Matched
                                $res=$this->updateATP();
                                if($res==200){
                                    //ATP Was Updated                                    
                                    return 200;
                                }
                                else{
                                    //ATP was Not Updated
                                    return 500;
                                }
                            }
                            else{
                                //Mail Did Not Match
                                return 0;
                            }
                        }
                    }
                    protected function updateATP(){
                        $this->connToDB();
                        $query="UPDATE StudInfo SET stud_ATP=? WHERE scholar_id=?";
                        $stmt=($this->conn)->prepare($query);
                        $stmt->bind_param('ss',$hashATP,$this->schID);
                        $this->NATP=mt_rand(1000,9999);
                        $hashATP=password_hash($this->NATP,PASSWORD_BCRYPT);
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
                    *@return '200' if Mail Was Sent
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
                        $mail->addAddress($this->emailID,'');
                        if($mail->send()){
                            return 200;
                        }
                        else{
                            return 0;
                        }
                    }
                    
                    protected function setBody(){
                        $Mbody="Hi There Mr. ".$this->name.",<br><br>
                        We are happy to tell you have successfully regenrated your<br>
                        ATP for Health Center, N.I.T. Silchar.
                        <br><br><br>
                        Now you can access our services using the following login credentials: <br>
                        <ul style='list-style-type: none;'>
                        <li>User ID:- ".$this->schID."</li>
                        <li>Password:- ".$this->NATP."</li>
                        </ul>
                        <br><br>
                        We will be happier to help at feedback@roghaari.com<br>
                        regarding anything you might need.
                        <br><br>
                        <h4 style='color:#af1700;'>Please do not reply back as this is a Computer Generated E-Mail.</h4>";
                        return $Mbody;
                    }
                    
                }//End Of Class
                
                $test=new ForgotATP;
                $test->VerifyDet($error);
                if($test->errorF){
                    $test->ProvidedVal($provVal);
                    //ReShow the Form With User Error
                    include 'php/DispReATP.php';
                    unset($test);
                    exit();
                }
                else{
                    $test->AssignVal();
                    //Check Whether The User Was Registered Or Not
                    $CheckReply=$test->CheckExist();
                    if($CheckReply!=200){
                        //Redirect To Registration
                        echo '<div class="w3-card-4 w3-third w3-padding-24 w3-red" style="position: absolute;left:33%;top:20%; padding-left: 25px;"> 
                        <i class="fa fa-exclamation-circle fa-fw w3-margin-right w3-xxlarge"></i><strong> You Have Not Registered Yourself!</strong>
                        </div>';
                        unset($test);
                        exit();
                    }
                    else{
                        $SyncReply=$test->SyncEntries();
                        if($SyncReply==200){
                            //ATP Was Updated
                            //Mail Can Be Sent Now
                            $MailReply=$test->MailATP();
                            if($MailReply==200){
                                //Mail Successfully Sent
                                echo '<div class="w3-card-4 w3-third w3-padding-24 w3-teal" style="position: absolute;left:33%;top:20%; padding-left: 25px;"> 
                        <i class="fa fa-thumbs-up fa-fw w3-margin-right w3-xxlarge"></i><strong> Check Your Mail To Find Details</strong>
                        </div>';
                            }
                            else{
                                //Technical Error
                                echo '<div class="w3-card-4 w3-third w3-padding-24 w3-red" style="position: absolute;left:33%;top:20%; padding-left: 25px;"> 
                        <i class="fa fa-exclamation-circle fa-fw w3-margin-right w3-xxlarge"></i><strong> ERR:- Mail Could Not Be Sent </strong>
                        </div>';
                                unset($test);
                                exit();
                            }
                        }
                        elseif($SyncReply==500){
                            //Technical Error
                            //Contact feedback@roghaari.com
                            echo '<div class="w3-card-4 w3-third w3-padding-24 w3-red" style="position: absolute;left:33%;top:20%; padding-left: 25px;"> 
                        <i class="fa fa-exclamation-circle fa-fw w3-margin-right w3-xxxlarge"></i><strong> ERR:- Technical Error</strong>
                        </div>';
                            unset($test);
                            exit();
                        }
                        else{
                            //Wrong Combination
                            echo '<div class="w3-card-4 w3-third w3-padding-24 w3-red" style="position: absolute;left:33%;top:20%; padding-left: 25px;"> 
                        <i class="fa fa-exclamation-triangle fa-fw w3-margin-right w3-xxlarge"></i><strong> Wrong Combination</strong>
                        </div>';
                            unset($test);
                            exit();
                        }
                    }
                }
            }
       ?>
    </body>
</html>