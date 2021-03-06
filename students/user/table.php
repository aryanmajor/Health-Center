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
<link rel="stylesheet" href="../css/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">
<?php
    $Continue=0;
            
            if((!isset($_SESSION['StudLogIN']))||($_SESSION['StudLogIN']!=200)){
                
                require '../php/Login.php';
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
                
                header("Location: ../index.php");
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
      
         
        
        <?php
                    $dir='photos/';
                    if(file_exists($dir.$_SESSION['schID'].'.jpeg')){
                        ?>
                    <img 
                         src="<?php echo $dir.$_SESSION['schID'].'.jpeg'; ?>" 
                         class="w3-circle w3-border w3-border-teal" 
                         alt="<?php echo $_SESSION['schID']; ?>" 
                         style="width:90%;height:100%;">
                    <br>
                    <button onclick="setup();" class="w3-button w3-teal" style="margin-top:10px;">Upload New Picture</button>
                    <?php
                    }
                    else{
                        ?>
                    <div id="image_icon">
                    <i class="fa fa-user-circle-o fa-fw w3-margin-right w3-jumbo" ></i>
                        </div>
                        <br>
                    <button onclick="setup();" class="w3-button w3-teal" style="margin-top:10px;">Upload New Picture</button>
   
                    <?php
                    }
                ?>
        <div class="w3-container">
                    <div id="id01" class="w3-modal">
                    <div class="w3-modal-content w3-card-4  w3-animate-right" style="width:40%;">
                      <header class="w3-container w3-teal"> 
                        <span onclick="document.getElementById('id01').style.display='none'" 
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
    <a href="index.php" target="_top" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Overview</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bell fa-fw"></i>  News</a>
    <a href="table.php" target="_top" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-history fa-fw"></i>  History</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Settings</a><br><br>
  </div>
    
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
        <i class="fa fa-arrow-left fa-fw w3-margin-right w3-large"></i>
        Log Out    
    </button>
    </p>
    </form>
    
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main w3-row-padding" style="margin-left:300px;margin-top:43px;">
        <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-history"></i>  Visit History</b></h5>
  </header>
                    
    <?php
        //Continue To Retrieving The Info
        $conn=new mysqli('localhost','root','SQLroot','Dispensary');
        if($conn->connect_error){
            http_response_code(500);
            exit;
        }
        
        $query="SELECT visit_ID,disease,symptoms,provDiag,timeOfVisit 
                        FROM VisitInfo WHERE 
                    stud_scholarID=? ORDER BY visit_ID DESC";
        $stmt=$conn->prepare($query);
        $stmt->bind_param('s',$_SESSION['schID']);
        $stmt->execute();
        
        $stmt->store_result();
        
        if($stmt->num_rows){
            //Display Table
            ?>
        <div class="w3-responsive">
            <table class="w3-table w3-border w3-centered w3-hoverable w3-bordered">
                <thead>
                <tr class="w3-red">
                    <th>
                        Visit ID
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Disease
                    </th>
                    <th>
                        Symptoms
                    </th>
                    <th>
                        Provisional Diagnosis
                    </th>
                    <th>
                        View PDF
                    </th>
                    </tr>
                </thead>
                <tbody>
        <?php
           /*
                *Authentication For Link
                *
                *Link Key for doctor login approval
                *Sch Key for scholarID verification
              */  
            $linkKey=bin2hex(random_bytes(10)).time();
            $_SESSION['linkKey']=$linkKey;
            $linkKey=hash('ripemd128',$linkKey);
            $schKey=hash('ripemd128',
                         $_SESSION['schID'].'ViShAl347');
            
            $disList=array("Common Cold","Fever","Skin Infection","Muscle Pain",
                            "Cuts And Wounds","Dental Problem","Breathing Problem",
                            "Stomach Ache","Hair Related","Others");
            $disp="";
            $stmt->bind_result($visitID,$disease,$symp,$provDiag,$tov);
            while($stmt->fetch()){
                //Array of list placed at appropriate index
                
                $disp .= "<tr class='w3-white w3-hover-light-grey  w3-padding-24'>
                        <td>".htmlentities($visitID)."</td>";
                $disp .= "<td>".htmlentities(date('d F' , $tov))."</td>";
                $disp .= "<td>".$disList[htmlentities($disease)]."</td>";
                $disp .= "<td>".ucfirst(htmlentities($symp))."</td>";
                $disp .= "<td>".ucfirst(htmlentities($provDiag))."</td>";
                $data = array('visitID'=>$visitID,
                            'vK'=>hash('ripemd128',$visitID.'Pol@34'),
                            'lK'=>$linkKey,
                            'schID'=>$_SESSION['schID'],
                           'sK'=>$schKey);
                $query= http_build_query($data);
                $disp .= "<td><a target='_blank' href='../../doctors/user/php/view_info.php?$query'><i class='fa fa-download           w3-large' style='cursor:pointer;'></i></a></td></tr>";
            
            }
            echo $disp;
            $stmt->close();
            $conn->close();
                      ?>
                </tbody>
            </table>
    <?php
    
        }
        else{
            //No Record Found
            ?>
    <div class="w3-responsive w3-card-4 w3-padding-32 w3-text-white w3-center w3-light-green">
        <i class="fa fa-asterisk fa-fw w3-margin-right w3-large"></i>
        <strong>No Record Found</strong>
    </div>
        <?php
        }
    
    ?>
                  
    </div>
    


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

    <!--------------------SCRIPT TIME--------------------------->
<!-- First, include the Webcam.js JavaScript Library -->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/webcam.min.js"></script>
	
	<!-- Configure a few settings and attach camera -->
	<script language="JavaScript">
		Webcam.set({
			width: 320,
			height: 240,
			image_format: 'jpeg',
			jpeg_quality: 90
		});
	</script>

<!-- Code to handle taking the snapshot and displaying it locally -->
	<script language="JavaScript">
        var uri='';
        var schID='<?php  echo $_SESSION['schID'];  ?>';
		function setup() {
            $("#id01").show();
			Webcam.reset();
                $("#my_image").hide();
                $("#my_camera").show();
                $(".img_but").eq(1).hide();
                $(".img_but").eq(0).show();
			Webcam.attach( '#my_camera' );
		}
		
		function take_snapshot() {
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
                Webcam.reset();
                $(".img_but").eq(1).show();
                $(".img_but").eq(0).hide();
				// display results in page
                $("#my_image").show();
                $("#my_camera").hide();
				document.getElementById('my_image').innerHTML = 
					'<img src="'+data_uri+'"/>';
                uri=data_uri;
			} );
		}
        function send_data(){
            var xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange=function(){
                if(this.readyState==4 && this.status==200){
                    alert(this.responseText);
                    $("#id01").hide();
                    location.reload(true);
                }
            };
            xhttp.open("POST", "php/updatePic.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("data="+uri+"&schID="+schID);
        }
</script>
    
</body>
</html>