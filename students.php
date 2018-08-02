<!DOCTYPE html>
<html>
<title>Health Center | Doctor</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href='w3.css'>
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="students/scripts/jquery-3.2.1.min.js"></script>
    <script src="students/scripts/studentsscr.js"></script>
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
    .main_item{
        line-height: 40px;
    }
    .noDisp{
        display: none;
    }
    .option{
        cursor: pointer;
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
                        require 'students/Login.php';
                        $test=new LoginStud;
                        $test->validForm($LIerror);
                        if($test->errorF){
                            //Errors Were Found In Submitted Information
                            //Redirection To Display Form
                            unset($test);
                            include 'students/DispForm.php';
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
                                include 'students/DispForm.php';
                                exit();                                
                            }
                            else{
                                //User ID And ATP Matched
                                //Login Confirmed
                                //Cookie Creation
                                $test->CreateCook($LIerror);
                                unset($test);
                                ob_start();
                                header("Location: students/loggedin/student.php");
                                exit();
                            }
                        }
					}
                    
                    //If Student Presses Signup Button
					else if($_POST['const']=='2'){
						
                        include 'students/Registration.php';
                        $test=new RegisterStud; //Instance Of The Class
                        $test->VerifyDet($SUerror); //Verification Of Provided Value
                        if($test->errorF){
                            //Error Was Found
                            //Redirection To Student Form
                            $test->ProvidedVal($SUprovVal);//Used To Re-Display User Input
                            unset($test);//Destroy The Object
                            include 'students/DispForm.php';
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
                                <i class="fa fa-thumbs-up fa-fw w3-margin-right w3-xxxlarge"></i><strong> Please Check Your Mail<br>For LogIn Details</strong></div>';
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
				include 'students/DispForm.php';
                exit();
			}
		?>
</html>