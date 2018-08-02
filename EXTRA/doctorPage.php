<?php
    session_start();
    ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Doctor@NITS</title>
    <style>
        html, body{
            margin:0px;
            overflow-x: scroll;
        }
        #top_banner{
            position: absolute;
            top:0px;
            left:0px;
            background:#4056A1;
            color: #EFE2BA;
            width:100%;
            height:15%;
            padding-left: 10%;
            padding-top: 2%;
        }
        #schID{
            position: absolute;
            background-color:#EFE2BA;
            top:15%;
            left:0px;
            height: 10%;
            width: 100%;
            padding-top: 2%;
            padding-left: 15%;
            
        }
        #schID input[type="text"]{
            margin-right: 5%;
            background: transparent;
            outline:none;
            border:none;
            height:60%;
            font-size: 20px;
            border-bottom: 2px solid #4056A1;
            padding-bottom: 0.5%;
            color:#4056A1;
        }
        #schID input[type="submit"]{
            margin-right: 2%;
            background-color: #4056A1;
            border:none;
            height:100%;
            width:15%;
            font-size: 17px;
            padding: 0.5%;
            border-radius: 20px;
            color:#EFE2BA;
            font-weight:800;
        }
        #schID input[type="submit"]:hover{
            background-color: #140B28;
            cursor: pointer;
        }
        #belowPart{
            padding-top: 5%;
            padding-left: 5%;
            padding-right: 5%;
            background:#EFE2BA;
            color:#4056A1;
            position: absolute;
            top:25%;
            left:0px;
            height:80%;
            width: 100%;
        }
        #info{
            text-align: center;
            display: block;
            position:absolute;
            left:30%;
            top:30%;
            width:40%;
            height:40%;
            font-size: 3em;
            font-family: cursive;
        }
        #stuInfo{
            font-size: 2em;
            font-weight: 400;
            text-align: right;
            

        }
        #heading{
            font-size: 3.0em;
            font-weight: 600;
        }
        .NoDisp{
            display: none;
        }
        #insertTable{
            line-height: 20px;
            font-size: 1.5em;
            font-weight: 500;
        }
        #insertTable select {
            border:0;
            background:#BC986A;
            color:#fff;
            font-weight: 600;
            padding-left: 2%;
            height:32px;
            border:2px solid #4056A1;
            width:350px;
            -webkit-appearance: none;
        }
        #insertTable input[type="text"]{
            margin-right: 5%;
            background: transparent;
            outline:none;
            border:none;
            height:60%;
            font-size: 20px;
            border-bottom: 2px solid #4056A1;
            padding-bottom: 0.5%;
            color:#4056A1;
        }
        #insertTable input[type="submit"]{
            background-color: #4056A1;
            border:none;
            height:100%;
            width:60%;
            font-size: 17px;
            padding: 0.5%;
            border-radius: 20px;
            color:#EFE2BA;
            font-weight:800;
        }
        #insertTable input[type="submit"]:hover{
            background-color: #140B28;
            cursor: pointer;
        }
        textarea{
            margin-right: 5%;
            background: transparent;
            outline:none;
            border:none;
            height:60%;
            font-size: 20px;
            border-bottom: 2px solid #4056A1;
            padding-bottom: 0.5%;
            color:#4056A1;
        }
        table{
            width:70%;
            
        }
        td, th{
            width:10%;
        }
        tr{
            border-bottom: black solid 1px;
        }
        thead{
            background: #4056A1;
            height:10%;
            color:#EFE2BA;
        }
        #name{
            font-size: 2em;
            font-weight: 600;
            margin-left: 10%;
            
        }
    </style>
    <script>
        function HiddVal(x){
            document.getElementById("hiddenval").value=x;
        }
    </script>
</head>
    <body>
        <?php
            ini_set('display_errors',1);
            ini_set('display_startup_errors',1);
            error_reporting(E_ALL);
            
            $Continue=0;
            
            if((!isset($_SESSION['DocLogIN']))||($_SESSION['DocLogIN']!=200)){
                
                require 'doctors/Login.php';
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
                
                header("Location: doctor.php");
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
        <div id="top_banner"> <span id="heading">Health Centre, N.I.T. Silchar</span>
        <span id="name"><?php echo $_SESSION['name'] ?></span>
        </div>
        <div id="schID">
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="get">
                <input type="text" maxlength="10" name="stud_ID" placeholder="Enter Scholar I.D."
                       <?php
                            if(isset($studInformation["scholar_id"])){
                                echo "value='".$studInformation["scholar_id"]."'";
                            }
                        ?>
                       required>
                <input type="hidden" name="option" value="0" id="hiddenval">
                <input type="submit" value="New Record" onclick="HiddVal(1)">
                <input type="submit" value="Edit Last" onclick="HiddVal(2)">
                <input type="submit" value="View All" onclick="HiddVal(3);">
            </form>
        </div>
        <div id="belowPart">
			
		<?php
		
        //WHEN PAGE starts the first thing we show is the details
        if(!filter_has_var(INPUT_GET,"option")){
            echo $DispInfo;
            exit();
        }
        if(!filter_has_var(INPUT_GET,"stud_ID")){
            echo $DispInfo;
            exit();
        }
        //Option Variable And Scholar ID Were Found
        //Continue To Sanitization
        $linkDB=new mysqli("localhost","root","SQLroot","Dispensary");
        if($linkDB->connect_error){
            exit();
        }
        $ClickOp=htmlentities($linkDB->real_escape_string($_GET['option']));
        $ScholarID=htmlentities($linkDB->real_escape_string($_GET['stud_ID']));        
        
        $linkDB->close();   //Connection Closed

        $Choice=array('1','2','3');
        if(!in_array($ClickOp , $Choice)){
            //$_GET['option'] Was Tampered
            echo $DispInfo;
            exit();
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
                        
                        $query="SELECT stud_name, stud_height, stud_weight,
                        stud_BMI, stud_bloodgrp, stud_branch, stud_batch 
                        FROM StudHealth WHERE scholar_id=?";
                        $stmt=($this->conn)->prepare($query);
                        $stmt->bind_param('s',$ScholarID);
                        $stmt->execute();
                        
                        $stmt->store_result();
                        if($stmt->num_rows){
                            $stmt->bind_result($name,$height,$weight,
                                               $BMI,$bldgrp,$branch,$batch);
                            
                            $stmt->fetch();
                            $stmt->close();
                            ($this->conn)->close();
                            
                            $studInformation['name']=htmlentities($name); $studInformation['height']=htmlentities($height); $studInformation['weight']=htmlentities($weight);
                            $studInformation['BMI']=htmlentities($BMI);
                            $studInformation['bldgrp']=htmlentities($bldgrp);
                            $studInformation['branch']=htmlentities($branch); $studInformation['batch']=htmlentities($batch);
                            $studInformation['scholar_id']=$ScholarID;
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
                include 'doctors/insertToDB.php';
                exit();
            }
            elseif($ClickOp==2){
                //User Selected Edit Last Option
                include 'doctors/editLastDB.php';
            }
            elseif($ClickOp==3){
                //user Selects View All Option
                include 'doctors/viewAllDB.php';
            }
        }
            
		?>        
        </div>
    </body>
</html>