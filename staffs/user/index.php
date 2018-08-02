<?php
    session_start();
    ob_start();
?>
<!DOCTYPE html>
<html>
<title>Health Center | Doctor</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href='w3.css'>
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
</style>
    
<script>
    function HiddVal(x){
        document.getElementById("hiddenval").value=x;
    }
</script>
<body class="w3-light-grey">
    <?php
            ini_set('display_errors',1);
            ini_set('display_startup_errors',1);
            error_reporting(E_ALL);
            
            $Continue=0;
            
            if((!isset($_SESSION['StaffLogIN']))||($_SESSION['StaffLogIN']!=200)){
                
                require '../php/Login.php';
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
                
                header("Location: ../index.php");
                exit();
            }
            
        /*
            ob_start();
            session_start();
            if(!isset($_SESSION['loggedIN'])){
                session_destroy();
                header("Location: doctor.php");
                exit();
            }
            elseif($_SESSION['loggedIN']!=true){
                session_destroy();
                header("Location: doctor.php");
                exit();
            }
            */
            $studInformation=array('scholar_id'=>'', 'name'=>'', 'height'=>'', 'weight'=>'', 'BMI'=>'', 'bldgrp'=>'', 'branch'=>'', 'batch'=>'');
            $DispInfo='<div id="info">Welcome, Sir<br>Enter A Scholar ID<br>Then Select An              Option<br></div>';
            $TechError='<div id="info">Technical Error Found</div>';
            $WrongID='<div id="info">Wrong Scholar ID<br>Or<br>Un-Registered ID</div>';
        ?>
<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
  
    <!-- Left Column -->
    <div class="w3-third">
    
      <div class="w3-white w3-text-grey w3-card-4">
        <div class="w3-display-container">          
          <div class="w3-container w3-text-black">
            <h2><?php echo $_SESSION['name'] ?></h2>
          </div>
        </div>
        <div class="w3-container">
          <p><i class="fa fa-stethoscope fa-fw w3-margin-right w3-large w3-text-teal"></i> Inventory Manager</p>
          <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>Health Center, NIT Silchar</p>
          <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i><?php echo $_SESSION['email'] ?></p>
          <hr>

          <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Select One Option</b></p>
          <form>
            <input type="hidden" name="option" value="0" id="hiddenval">
                <input type="submit" value="Add New Medicine" onclick="HiddVal(1)" class="w3-button w3-round-xlarge w3-block w3-white w3-border w3-border-teal w3-hover-teal"><br>
                <input type="submit" value="Provide Medicine" onclick="HiddVal(2)" class="w3-button w3-round-xlarge w3-block w3-white w3-border w3-border-teal w3-hover-teal"><br>
                
            </form>
          <br>
            <hr>
            
            <form method="post" action="../../Logout/index.php">
                <p>
                    <?php
                        $Formnm='logout_val';
                        $bytes=random_bytes(8);
                        $Formval=bin2hex($bytes).time();
                        $_SESSION['logout_val']=$Formval;
                        $Formval=hash('ripemd128',$Formval);
                        echo "<input type='hidden' name='".$Formnm."' value='".$Formval."'>";
                    ?>
                <button type="submit" class="w3-button w3-block w3-white w3-border w3-border-white">
            <i class="fa fa-arrow-left fa-fw w3-margin-right w3-large w3-text-teal"></i>
                Log Out    
                </button>
                </p>
            </form>
            
          
        </div>
      </div><br>

    <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">
    
      <div class="w3-container w3-card w3-white w3-margin-bottom w3-text-grey w3-animate-zoom">
          
          <?php
            $DispInfo='<br><hr><h2 class="w3-text-grey w3-padding-16 w3-center">Welcome Sir ,</h2><hr><br>';
            $DispInfo.='<h3 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Please Select An Option</h3>';  
            $TechError='<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Technical Error</h2>';
        
            
            if(filter_has_var(INPUT_GET,"option")){
                //Everything Is Okay
                //Option Variable And Scholar ID Were Found
                //Continue To Sanitization
                
                $linkDB=new mysqli("localhost","root","SQLroot","Dispensary");
                if($linkDB->connect_error){
                    echo $TechError;
                }
                
                $ClickOp=htmlentities($linkDB->real_escape_string($_GET['option']));   

                $linkDB->close();   //Connection Closed
                
                $Choice=array('1','2');     //Total Allowed Values
                if(!in_array($ClickOp , $Choice)){
                    
                    //$_GET['option'] Was Tampered
                    
                    echo $DispInfo;
                }
                else{

                    if($ClickOp==1){
                        //User Selected Insert Option
                        include 'php/insertToDB.php';
                    }
                    elseif($ClickOp==2){
                        //User Selected Edit Last Option
                        include 'php/provideMed.php';
                    }
            }//End Of Sanitization
            }//End Of Filter_Has_Var
            else{
                //Something Was Wrong
                echo $DispInfo;
            }
          
        
        ?>
      </div>


    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
</div>

<footer class="w3-container w3-teal w3-center w3-margin-top">
  <p>Find us on social media.</p>
  <i class="fa fa-facebook-official w3-hover-opacity"></i>
  <i class="fa fa-instagram w3-hover-opacity"></i>
  <i class="fa fa-snapchat w3-hover-opacity"></i>
  <i class="fa fa-pinterest-p w3-hover-opacity"></i>
  <i class="fa fa-twitter w3-hover-opacity"></i>
  <i class="fa fa-linkedin w3-hover-opacity"></i>
  <p>Powered by <a href="https://www.roghaari.com" target="_blank">Roghaari</a></p>
</footer>

</body>
</html>