<!DOCTYPE html>
<html>
<title>Health Center | Doctor</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/studentsscr.js"></script>
<style>
html,body,h1,h2,h3,h4,h5,h6 {
    font-family: "Roboto", sans-serif;
    margin:0;
    }
    body{
        background: url(pics/loginbackground5.png);
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
        left:10%;
        top:10%;
        height:70%;
        width:80%;
    }
    .smallContainer{
        height: 100%;
        padding-left: 2%;
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
        letter-spacing: 3px;
        margin-bottom: 10%;
    }
    label{
        font-size: 16px;
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
		<?php
    /*
            ini_set('display_errors',1);
            ini_set('display_startup_errors',1);
            error_reporting(E_ALL);
      */
      /*
            *Global Variable Declaration
            *
            * $SUerror==> error while registering
            * $proValue==> value entered while registering
            * $LIerror==> error while logging in
            * $LIproValue==> value provided while logging in
            *
            */
            $SUerror=array("schID"=>"","name"=>"","height"=>"","weight"=>"",
                                     "hostel"=>"","rnum"=>"",
                                     "bldgrp"=>"","emailID"=>"","dob"=>"");
            $SUprovVal=array();
            $LIerror=array("schID"=>"","ATP"=>"","logInfo"=>"");
            
    
            /*
            *If POST method is found
            *User Has Submitted The Form
            *
            *If GET method is found
            *User Has Requested The Page
            *
            */
			if($_SERVER['REQUEST_METHOD']=='POST'){
                
                //Used Just To Stop Malicious Activity
				if(filter_has_var(INPUT_POST,'const')){
                    //If Login Button Is Pressed
					if($_POST['const']=='1'){
                        
                        $LIproValue=array(htmlentities($_POST['schID']));//Stores Scholar ID That Was Provided
                        require 'php/Login.php';
                        $test=new LoginStud;
                        $test->validForm($LIerror);
                        if($test->errorF){
                            //Errors Were Found In Submitted Information
                            //Redirection To Display Form
                            unset($test);
                            include 'php/DispForm.php';
                            exit();
                            
                        }
                        else{
                            //No Error Was Found In Submitted Information
                            //Continue To Sanitization Of Form
                            $test->sanitizeForm();
                            $SyncRep=$test->SynchEntries($LIerror);
                            if($SyncRep!=200){
                                //Login Failed
                                //Wrong Combinations
                                unset($test);
                                include 'php/DispForm.php';
                                exit();                                
                            }
                            else{
                                //User ID And ATP Matched
                                //Login Confirmed
                                //Cookie Creation
                                $test->CreateCook($LIerror);
                                unset($test);
                                ob_start();
                                header("Location: user/index.php");
                                exit();
                            }
                        }
					}
                    
                    //If Student Presses Signup Button
					else if($_POST['const']=='2'){
						
                        include 'php/Registration.php';
                        $test=new RegisterStud; //Instance Of The Class
                        $test->VerifyDet($SUerror); //Verification Of Provided Value
                        if($test->errorF){
                            //Error Was Found
                            //Redirection To Student Form
                            $test->ProvidedVal($SUprovVal);//Used To Re-Display User Input
                            unset($test);//Destroy The Object
                            include 'php/DispForm.php';
                            exit();
                        }
                        else{
                            $test->AssignVal();//Values Are Sanitized And Inserted Into Class Variables
                            $Result=$test->CommenceIns();
                            if($Result==200){
                                unset($test);//Destroy The Object
                                //mail is sent and insertion is done
                                //Student Will Be Redirected To Login
                                echo '<div class="w3-card-4 w3-third w3-padding-24 w3-teal" style="position: absolute;left:33%;top:20%; padding-left: 25px;"> 
                                <i class="fa fa-thumbs-up fa-fw w3-margin-right w3-large"></i><strong> Please Check Your Mail For LogIn Details</strong></div>';
                            }
                            elseif($Result==100){
                                unset($test);//Destroy The Object
                                //Insertion Done
                                //Mail Could Not Be Sent
                                echo '<div class="w3-card-4 w3-third w3-padding-24 w3-teal" style="position: absolute;left:33%;top:20%; padding-left: 25px;"> 
                                <i class="fa fa-exclamation-triangle fa-fw w3-margin-right w3-xxxlarge"></i><strong> Mail Could Not Be Sent
                                <br> Contact <u>feedback@roghaari.com</u> for the Same</strong></div>';
                            }
                            else{
                                unset($test);//Destroy The Object
                                //Insertion Could Not Be Done
                                //Hence, Mail Was Not Done
                                echo '<div class="w3-card-4 w3-third w3-padding-24 w3-teal" style="position: absolute;left:33%;top:20%; padding-left: 25px;"> 
                                <i class="fa fa-exclamation-triangle fa-fw w3-margin-right w3-xxxlarge"></i><strong> Technical Error</strong></div>';
                            }
                        }
                    
                    }//End Of Registration Section
                    
				else{
                    //Malicious Activity
				    http_response_code(403);
				    }
                }//End Of FILTER_INPUT const Section
                else{
                    //FILTER_INPUT const Was False
                    //Malicious Activity
                    http_response_code(403);
                }
            }//End Of POST Section
			else if($_SERVER['REQUEST_METHOD']=='GET'){
				include 'php/DispForm.php';
                exit();
			}
		?>
      
</html>