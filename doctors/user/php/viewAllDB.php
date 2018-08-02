	<body>
		<?php
            ini_set('display_errors',1);
            ini_set('display_startup_errors',1);
            error_reporting(E_ALL);
            //We Will Check Login Confirmation
            
   $Continue=0;
    if((!isset($_SESSION['DocLogIN']))||($_SESSION['DocLogIN']!=200)){

        require '../../php/Login.php';
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
        ob_start();
        header("Location: ../../index.php");
        exit();
    }
            //Login Confirmed
            
            $disList=array("Common Cold","Fever","Skin Infection","Muscle Pain",
                            "Cuts And Wounds","Dental Problem","Breathing Problem",
                            "Stomach Ache","Hair Related","Others");
            $linkKey='';
            $schKey='';
			if($_SERVER['REQUEST_METHOD']=='GET'){

        /*
        *Class To Fetch All Available Info
        *
        *@author Roghaari Team
        *
        */
        class FetchAll{
            public $info;
            protected $conn;

            public function Fetch($studInformation,$disList){
                $conRep=$this->connToDB();
                if($conRep){
                    return 0;
                }

                $query="SELECT visit_ID,disease,symptoms,provDiag,timeOfVisit 
                        FROM VisitInfo WHERE 
                    stud_scholarID=? ORDER BY visit_ID DESC";
                $stmt=($this->conn)->prepare($query);
                $stmt->bind_param('s',$studInformation['scholar_id']);
                $stmt->execute();
                $stmt->store_result();

                if($stmt->num_rows){
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
                                 $studInformation['scholar_id'].'ViShAl347');

                    $this->info="";
                    $stmt->bind_result($visitID,$disease,$symp,$provDiag,$tov);

                    while($stmt->fetch()){
                        $this->info .= "<tr class='w3-white w3-hover-light-grey  w3-padding-24'><td>".htmlentities($visitID)."</td>";
                        $this->info .= "<td>".htmlentities(date('d F' , $tov))."</td>";
                        $this->info .= "<td>".$disList[htmlentities($disease)]."</td>";
                        $this->info .= "<td>".htmlentities($symp)."</td>";
                        $this->info .= "<td>".htmlentities($provDiag)."</td>";
                        $data=array('visitID'=>$visitID,
                                    'vK'=>hash('ripemd128',$visitID.'Pol@34'),
                                    'lK'=>$linkKey,
                                    'schID'=>$studInformation['scholar_id'],
                                   'sK'=>$schKey);
                        $query=http_build_query($data);
                        $this->info .= "<td><a target='_blank' href='php/view_info.php?$query'><i class='fa fa-download w3-large' style='cursor:pointer;'></i></a></td>";
                    }

                    $stmt->close();
                    ($this->conn)->close();

                    return 200;
                }
                else{
                    $stmt->close();
                    ($this->conn)->close();
                    return 500;
                }
            }
            protected function connToDB(){
                $this->conn=new mysqli("localhost","root","SQLroot","Dispensary");
                if(($this->conn)->connect_error){
                    return 0;
                }
            }
        }

        $test=new FetchAll;
        $rep=$test->Fetch($studInformation,$disList);
        if($rep!=200){
            if($rep==0){
                echo '<br><hr><h2 class="w3-text-grey w3-padding-16 w3-center"><i class="fa fa-exclamation-circle fa-fw w3-margin-right w3-xlarge w3-text-teal"></i>  SERVER ERROR</h2><hr><br>';
            }
            else{
                echo '<br><hr><h2 class="w3-text-grey w3-padding-16 w3-center"><i class="fa fa-exclamation-circle fa-fw w3-margin-right w3-xlarge w3-text-teal"></i>  No Record Found</h2><hr><br>';
            }
        }
                else{
                ?>
        <div class="w3-responsive w3-padding-24">
            <table class="w3-table w3-centered w3-hoverable w3-bordered w3-padding-24">
                <thead>
                <tr class="w3-teal">
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
                    echo $test->info;
                    unset($test);
                ?>
            </tbody>
        </table>
        </div>
        <?php
                }
			}
				?>
	</body>