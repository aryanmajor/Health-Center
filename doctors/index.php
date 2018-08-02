<!DOCTYPE html>
<html>
<head>
<title>Health Center | Doctor</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/w3.css">
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
    body{
        background: linear-gradient( rgba(89,0,186,0.5),rgba(89,0,186,0.5)) , url('pic.jpeg');
        background-position: center;
        background-size: cover;
    }
</style>
    <script src="scripts/jquery-3.2.1.min.js">        
    </script>
    <script src="scripts/doctorsscr.js">
    </script>
    <link rel="stylesheet" href="css/w3.css">
</head>
		<?php
            ini_set( 'session.cookie_httponly', 1 );
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
            $LIerror=array("userID"=>"","pass"=>"","logInfo"=>"");
            
    
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
                        
                        $LIproValue=array(htmlentities($_POST['userID']));//Stores Scholar ID That Was Provided
                        require 'php/Login.php';
                        $test=new LoginDoc;
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
                session_start();
                if(isset($_SESSION['DocLogIN'])&&$_SESSION['DocLogIN']==200){
                    ob_start();
                    header("Location: user/index.php");
                    exit();
                }
                //We Will Check If Cookie Exist
                require 'php/Login.php';
                $test=new LoginDoc;
                $Rep=$test->CheckCookie();
                if($Rep!=200){
                    //Something Was Wrong
                    unset($test);
                    include 'php/DispForm.php';
                    exit();
                }
                else{
                    //Cookie Found
                    //Login Successfull
                    unset($test);
                    ob_start();
                    header("Location: user/index.php");
                    exit();                    
                }

			}
		?>
</html>