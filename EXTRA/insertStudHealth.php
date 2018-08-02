<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
    
    class insertToStud{
        public $schID;
        public $height;
        public $weight;
        public $bmi;
        public $bldgrp;
        public $hostel;
        public $rnum;
        public $dob;
        public $atp;
        public $branch;
        public $batch;
        protected $conn;
        protected function connToDB(){
            $this->conn=new mysqli("localhost","root","SQLroot","Dispensary");
            if(($this->conn)->connect_error)
                return 500;
        }
        public function AsignVal(){
            /*
            *Assign Submitted Values to Variables
            *
            *@author Roghaari Team
            *
            *return 500 if error
            *return 200 if correct
            *
            */
            $this->schID=$_SESSION['schID'];
            $this->height=round($_SESSION['height'],2);
            $this->weight=round($_SESSION['weight'],2);
            $this->bmi=($this->weight/($this->height*$this->height))*100*100;
            $this->bldgrp=$_SESSION['bldgrp'];
            $this->hostel=$_SESSION['hostel'];
            $this->rnum=$_SESSION['rnum'];
            $this->dob=$_SESSION['dob'];
            $IDArr=explode("-",$_SESSION['schID']);
            $this->batch=$IDArr[0]+2004;
            $brList=array("Civil Engineering","Mechanical Engineering","Electrical Engineering","Electronics And Communication Engineering","Computer Science And Engineering","Electronics And Instrumentation Engineering");
            $this->branch=$brList[($IDArr[2]-1)];
            $this->atp=$this->GenRandATP();
            if($this->atp){
                echo $this->CommenceIns();
            }
            else{
                echo "mail failed";
            }
        }
        public function CommenceIns(){
             $this->connToDB();
            $query="UPDATE StudHealth SET
            stud_height=?,
            stud_weight=?,
            stud_BMI=?,
            stud_bloodgrp=?,
            stud_hostel=?,
            stud_roomNum=?,
            stud_ATP=?,
            stud_DOB=?,
            stud_branch=?,
            stud_batch=? WHERE scholar_id=?";
            $stmt=($this->conn)->prepare($query);
            $stmt->bind_param('dddssssssss',$this->height,$this->weight,$this->bmi,$this->bldgrp,$this->hostel,$this->rnum,$this->atp,$this->dob,$this->branch,$this->batch,$this->schID);
            $this->atp=password_hash($this->atp,PASSWORD_BCRYPT);
            $stmt->execute();
            if($stmt->affected_rows){
                $stmt->close();
                ($this->conn)->close();
                return 200;
            }
            else{
                return 0;
            }
        }
        protected function GenRandATP(){
            $genATP=mt_rand(10000,99999);
            /*
            *Sending Email Containing The ATP
            *USING PHPMailer
            *Services@roghaari.com
            *
            *@author Roghaari Team
            *
            *returns $genATP if Done
            *returns 0 if Not Done
            */
            require 'PHPMailer/PHPMailerAutoload.php';
            $mail=new PHPMailer();
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
            $mail->Body=$this->setBody($genATP);
            //Set From and Receiver
            $mail->setFrom('services@roghaari.com','Roghaari');
            $mail->addAddress($_SESSION['emailID'],'');
            if($mail->send()){
                return $genATP;
            }
            else{
                return "0";
            }
        }
        protected function setBody($rNum){
            $Mbody="Hi There Mr. ".$_SESSION['name'].",<br><br>
We are happy to tell you have successfully registered yourself<br>
for Health Center, N.I.T. Silchar.
    <br><br><br>
Now you can access our services using the following login credentials: <br>
    <ul style='list-style-type: none;'>
    <li>User ID:- ".$_SESSION['schID']."</li>
    <li>Password:- ".$rNum."</li>
    </ul>
    <br><br>
    We will be happier to help at feedback@roghaari.com<br>
    regarding anything you might need.
    <br><br>
    <h4 style='color:#af1700;'>Please do not reply back as this is a Computer Generated E-Mail.</h4>";
            return $Mbody;
        }
    }
        $test=new insertToStud;
        $test->AsignVal();
        
?>