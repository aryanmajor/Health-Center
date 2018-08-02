<?php
    session_start();
    ob_start();
    
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
?> 
<!DOCTYPE html>
<html>
<title>Health Center | Students</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">
<?php
    $Continue=0;
            
            if((!isset($_SESSION['StudLogIN']))||($_SESSION['StudLogIN']!=200)){
                
                require '../Login.php';
                $test=new LoginStud;
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
                $_SESSION['StudLogIN']=0;
                session_destroy;
                
                header("Location: ../../students.php");
                exit();
            }
    ?>
<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right">Health Centre @ NITS</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <i class="fa fa-user fa-fw w3-margin-right w3-xxxlarge w3-text-red"></i>
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <br><h4><strong><?php echo $_SESSION['name'] ?></strong></h4></span><br>
    </div>
    <div class="w3-container">
        <hr>
          <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-blue"></i><?php echo $_SESSION['hostel'] ?></p>
          <p><i class="fa fa-map-marker fa-fw w3-margin-right w3-large w3-text-blue"></i><?php echo $_SESSION['RNum'] ?></p>
          <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-blue"></i><?php echo $_SESSION['email'] ?></p>
  </div>
    </div>
  <hr>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="student.php" target="_top" class="w3-bar-item w3-button w3-padding options"><i class="fa fa-users fa-fw"></i>  Overview</a>
    <a href="#" class="w3-bar-item w3-button w3-padding options"><i class="fa fa-bell fa-fw"></i>  News</a>
    <a href="table.php" target="_top" class="w3-bar-item w3-button w3-padding options"><i class="fa fa-history fa-fw"></i>  History</a>
    <a href="#" class="w3-bar-item w3-button w3-padding  w3-blue options"><i class="fa fa-cog fa-fw"></i>  Settings</a><br><br>
  </div>
    
    <hr>
    <form method="post" action="logout.php">
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
        <i class="fa fa-arrow-left fa-fw w3-margin-right w3-large"></i>
        Log Out    
    </button>
    </p>
    </form>
    
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:53px;">
  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h4><b><i class="fa fa-cog"></i> Settings</b></h4>
  </header>

  <div class="w3-row-padding w3-padding-24 w3-margin-bottom">
    <header class="w3-container" >
    <h6><i class="fa fa-cog"></i> Profile Picture</h6>
  </header>
    </div>
</div>
    

<div class="w3-main" style="margin-left:0px;margin-bottom:0px;">
  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-light-grey">
    <h4>FOOTER</h4>
    <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
  </footer>
    </div>
  <!-- End page content -->

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>
