<?php
    session_start();
    ob_start();
?>
<!DOCTYPE html>
<html>
<title>Health Center | Doctor</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href='css/w3.css'>
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
    .tt-menu{
        width: 100%;
        border: 0px;
        border-top: 0px;
        z-index: -1;
    }
    .tt-input:focus{
        outline: none;
    }
    .tt-suggestion{
        padding:10px;
        margin: 0px;
        background-color: #349999;
    }
    .tt-cursor{
        background-color: #008080;
    }
    .tt-hint{
        color: #a2a5a5;
    }
    .tt-dataset{
        color:#FFFFFF;
    }
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
            
            if((!isset($_SESSION['DocLogIN']))||($_SESSION['DocLogIN']!=200)){
                
                require '../php/Login.php';
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
            <h2>Dr. <?php echo ucfirst($_SESSION['name']) ?></h2>
          </div>
        </div>
        <div class="w3-container">
          <p><i class="fa fa-stethoscope fa-fw w3-margin-right w3-large w3-text-teal"></i><?php echo "Dermatologist" ?></p>
          <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>Health Center, NIT Silchar</p>
          <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i><?php echo $_SESSION['email'] ?></p>
          <hr>

          <p class="w3-large"><b><i class="fa fa-asterisk fa-fw w3-margin-right w3-text-teal"></i>Enter Scholar ID</b></p>
          <form>
              <input type="text" maxlength="10" name="stud_ID" placeholder="Enter Scholar I.D." class="w3-input w3-border" required
        <?php
            if(isset($_GET['stud_ID'])){
                echo "value='".$_GET['stud_ID']."'";
            }
        ?>
                     ><br>
            <input type="hidden" name="option" value="0" id="hiddenval">
                <input type="submit" value="New Record" onclick="HiddVal(1)" class="w3-button w3-round-xlarge w3-block w3-white w3-border w3-border-teal w3-hover-teal"><br>
                <input type="submit" value="Edit Last" onclick="HiddVal(2)" class="w3-button w3-round-xlarge w3-block w3-white w3-border w3-border-teal w3-hover-teal"><br>
                <input type="submit" value="View All" onclick="HiddVal(3);" class="w3-button w3-round-xlarge w3-block w3-white w3-border w3-border-teal w3-hover-teal">
            </form>
          <br>
            <hr>
            
            <form method="post" action='../../Logout/index.php'>
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
            $DispInfo.='<h3 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Please Enter A Scholar ID</h3>';  
            $TechError='<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Technical Error</h2>';
        
            
            if(filter_has_var(INPUT_GET,"option") && filter_has_var(INPUT_GET,"stud_ID")){
                //Everything Is Okay
                //Option Variable And Scholar ID Were Found
                //Continue To Sanitization
                
                $linkDB=new mysqli("localhost","root","SQLroot","Dispensary");
                if($linkDB->connect_error){
                    echo $TechError;
                }
                
                $ClickOp=htmlentities($linkDB->real_escape_string($_GET['option']));
                $ScholarID=htmlentities($linkDB->real_escape_string($_GET['stud_ID']));    

                $linkDB->close();   //Connection Closed
                
                $Choice=array('1','2','3');     //Total Allowed Values
                if(!in_array($ClickOp , $Choice)){
                    
                    //$_GET['option'] Was Tampered
                    
                    echo $DispInfo;
                }
                else{
                    
                    if(!isset($studInformation['scholar_id']) || 
                    $studInformation['scholar_id']!=$ScholarID){
                    //We Check If The New ID Is Same as previous One
                    //In Such Case We Would Not Require To Refetch The Student Information

                    class FindDet{
                        protected $conn;
                        /*
                        *Starts Connection With Database
                        *
                        *Stores the connection in $conn variable
                        *
                        *@return 0 if connection fails
                        *
                        */
                        public function connToDB(){
                            $this->conn=new mysqli("localhost","root","SQLroot","Dispensary");
                            if(($this->conn)->connect_error){
                                return 0;
                            }
                        }
                        /*
                        *
                        *@return 0 If There Is Any Server Error
                        *@return 200 If Everything Was Okay
                        */
                        public function FetchInfo(&$studInformation,$ScholarID){
                            $rep=$this->connToDB();

                            $query="SELECT stud_name,stud_DOB,stud_sex,
                            stud_BMI, stud_bloodgrp
                            FROM StudHealth WHERE scholar_id=?";
                            $stmt=($this->conn)->prepare($query);
                            $stmt->bind_param('s',$ScholarID);
                            $stmt->execute();

                            $stmt->store_result();
                            if($stmt->num_rows){
                                $stmt->bind_result($name,$dob,$sex,$BMI,
                                                   $bldgrp);

                                $stmt->fetch();
                                $stmt->close();
                                ($this->conn)->close();

                                $studInformation['name']=htmlentities($name); $studInformation['dob']=htmlentities($dob);
                                $sexArr=array('M'=>'Male','F'=>'Female');
                                $studInformation['sex']=htmlentities($sex);
                                $studInformation['BMI']=htmlentities($BMI);
                                $studInformation['bldgrp']=htmlentities($bldgrp);
                                $studInformation['scholar_id']=$ScholarID;
                                $studInformation['batch']=(int)(substr($studInformation['scholar_id'],0,2))+2004;
                                $studInformation['branch']=substr($studInformation['scholar_id'],3,1);
                                return 200;
                            }
                            else{
                                $stmt->close();
                                ($this->conn)->close();

                                return 500;
                            }
                        }
                    }//End Of Class Definition
                        
                        
                    $test=new FindDet;
                    $rep=$test->FetchInfo($studInformation,$ScholarID);
                    if($rep!=200){
                        if($rep==500){
                            echo $WrongID;
                        }
                        elseif($rep==0){
                            echo $TechError;
                        }
                        else{
                            echo $DispInfo;
                        }
                        unset($test);
                        exit();
                    }
                    unset($test);

                }//End Of IF Statement

                    if($ClickOp==1){
                        //User Selected Insert Option
                        include 'php/insertToDB.php';
                    }
                    elseif($ClickOp==2){
                        //User Selected Edit Last Option
                        include 'php/editLastDB.php';
                    }
                    elseif($ClickOp==3){
                        //user Selects View All Option
                        include 'php/viewAllDB.php';
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

<!--------------------SCRIPT TIME--------------------------->
<!-- First, include Required JavaScript Libraries -->
	<script src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/webcam.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/typeahead.js"></script>

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
        var schID='<?php  echo $studInformation['scholar_id'];  ?>';
		function setup() {
            $("#id01").show();
			Webcam.reset();
                $("#my_image").hide();
                $("#my_camera").show();
                $(".img_but").eq(1).hide();
                $(".img_but").eq(0).show();
			Webcam.attach( '#my_camera' );
		}
		function closeCam(){
            Webcam.reset();
            $("#id01").hide();
            
            $(".img_but").eq(1).show();
            $(".img_but").eq(0).hide();
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
            xhttp.open("POST", "../../students/user/php/updatePic.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("data="+uri+"&schID="+schID);
        }
    </script>
<!-- Code to show suggestion for typeahead -->
    <script>

        
        
        var currMedicine=0;
        $(document).on('keyup','#tBody tr .medName', function(){
            currMedicine =$(this).parents('tr').index();
        });
        
        //function to add a new row in the table
        var addHideCount=0;
        function addRec(){
            
            var $tRow=$('<tr><td><input type="text" name="medicine[]" placeholder="Medicine Name" class="w3-input w3-border medName"><input type="hidden" name="code[]"  class="medCode"></td><td><input type="text" name="dose[]" placeholder="Medicine Dose" class="w3-input w3-border"></td><td><input type="text" name="days[]" placeholder="No. Of Days" class="w3-input w3-border"></td><td onclick="addRec();" class="addHide"><i class="fa fa-plus-circle fa-fw w3-margin-right w3-xlarge w3-text-teal" style="cursor: pointer;"></i></td></tr>');
            
            $('#tBody').append($tRow);
            $('.addHide').eq(addHideCount).hide();
            addHideCount++;
            createTypeahead($tRow.find('input.medName'));
         }
        
        //prevent form submission on 'Enter Key' press
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
        
        //Bloodhound for the typeahead
        var users= new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('mName','mQuant','mCode'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url:'php/getMedName.php?query=%QUERY',
                wildcard: '%QUERY'
            }
        });

        users.initialize();

        //typeahead function to link respective textboxes with
        //respective object of JSON
        function createTypeahead($els){
            $els.typeahead({
                hint:true,
                highlight:true,
                minlength:2,
                autoselect: true
            },
            {
                name: 'medicine',
                displayKey:'mName',
                source: users.ttAdapter(),
                //a well defined template
                templates:{
                    empty :[
                              '<div class="empty-message">',
                              'Not Available',
                              '</div>'
                            ].join('\n'),
                    suggestion: function(datum) {

                        return '<div><strong>' + datum["mName"] + '</strong>     ' + datum["mQuant"] + '</div>';
                    }
                }
            }).on("typeahead:selected",onSelected);

            function onSelected($e,datum){
                $('#tBody .medCode').eq(currMedicine).val(datum['mCode']);
                return;
            }
        }

        $(document).ready(function() {
            //DropDown suggestions
            createTypeahead($('#tBody .medName'));
        });


    </script>
</body>
</html>