<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<title>Visit Information</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href='w3.css'>
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
   
    $allowance=200;
    if(!filter_has_var(INPUT_GET,"visitID")||$_GET['visitID']==NULL){
        $allowance=0;
    }
    if(!filter_has_var(INPUT_GET,"vK")||$_GET['vK']==NULL){
        $allowance=0;
    }
    if(!filter_has_var(INPUT_GET,"lK")||$_GET['lK']==NULL){
        $allowance=0;
    }
    if(!filter_has_var(INPUT_GET,"schID")||$_GET['schID']==NULL){
        $allowance=0;
    }
    if(!filter_has_var(INPUT_GET,"sK")||$_GET['sK']==NULL){
        $allowance=0;
    }
    if($allowance!=200){
        http_response_code(403);
    }
    
    
    $visitID=$_GET['visitID'];
    $visitKey=$_GET['vK'];
    $linkKey=$_GET['lK'];
    $schID=$_GET['schID'];
    $schKey=$_GET['sK'];
    
    $contVal=500;
    if(!strcmp(hash('ripemd128',$visitID.'Pol@34'),$visitKey)){
        if(!strcmp($linkKey,hash('ripemd128',$_SESSION['linkKey']))){
            
            if(!strcmp(hash('ripemd128',$schID.'ViShAl347'),$schKey)){
                $contVal=200;
            }
        }
    }
    
    if($contVal!=200){
        http_response_code(403);
        exit();
    }
    $medicine=array();
    $visitInfo=array('vistID'=>'','tov'=>'','docReg'=>'','medicine'=>'',
                     'disease'=>'','symptoms'=>'','remark'=>'',);
    $studInfo=array('studName'=>'','studAge'=>'','studBlood'=>'',
                    'sex'=>'','studHostel'=>'','studRNum'=>'');
    $docInfo=array('docName'=>'','docDep'=>'','docEmail'=>'');
    
    
    /*
    *Class To Fetch All Available Info
    *
    *@author Roghaari Team
    *
    */
    class FetchAll{
        public $info;
        protected $conn;
        
         protected function connToDB(){
            $this->conn=new mysqli("localhost","root","SQLroot","Dispensary");
            if(($this->conn)->connect_error){
                return 0;
            }
        }
        
        /*
        *@returns 200 on success
        *@returns 500 on failure
        */
        public function FetchInfo($visitID,&$visitInfo,&$studInfo,&$docInfo){
            $conRep=$this->connToDB();
            if($conRep){
                return 500;
            }
            $query="SELECT v.disease, v.symptoms, v.remarks, v.timeOfVisit, v.doc_regNo, v.medicine_reg,
                    d.doc_name, d.doc_department, d.doc_email, 
                    s.stud_name, s.stud_bloodgrp, s.stud_hostel, s.stud_roomNum,
                    s.stud_DOB, s.stud_sex
                    FROM DocInfo AS d, VisitInfo AS v, StudHealth AS s
                    WHERE v.visit_ID=? AND v.stud_scholarID=s.scholar_ID AND v.doc_regNo=d.doc_RegNo
                    LIMIT 1";
            $stmt=($this->conn)->prepare($query);
            $stmt->bind_param('i',$visitID);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows){
                $stmt->bind_result($disease,$symp,$remk,$tov,$docReg,$medStr,
                                  $docName,$docDep,$docEmail,
                                  $name,$bldgrp,$hostel,$rNum,$dob,$sex);
                $stmt->fetch();
                
                //visit info at one place
                $disList=array("Common Cold","Fever","Skin Infection","Muscle Pain",
                            "Cuts And Wounds","Dental Problem","Breathing Problem",
                            "Stomach Ache","Hair Related","Others");
                $visitInfo['disease']=$disList[htmlentities($disease)];
                $visitInfo['symptoms']=ucfirst(htmlentities($symp));
                $visitInfo['remark']=ucfirst(htmlentities($remk));
                $visitInfo['tov']=date('d F',htmlentities($tov));
                $visitInfo['docReg']=htmlentities($docReg);
                $visitInfo['vistID']=htmlentities($visitID);
                $visitInfo['medicine']=htmlentities($medStr);
                
                //doctor info at one place
                $docInfo['docName']=ucfirst(htmlentities($docName));
                $docInfo['docDep']=ucfirst(htmlentities($docDep));
                $docInfo['docEmail']=htmlentities($docEmail);
                
                //student info at one place
                $studInfo['studName']=strtoupper(htmlentities($name));
                $studInfo['studBlood']=strtoupper(htmlentities($bldgrp));
                $studInfo['studHostel']=ucfirst(htmlentities($hostel));
                $studInfo['studRNum']=htmlentities($rNum);
                $sexArr=array('M'=>'Male','F'=>'Female');
                $studInfo['sex']=htmlentities($sexArr[$sex]);                
                $dobY=new DateTime(htmlentities($dob));
                $curY=new DateTime('today');
                $age= $dobY->diff($curY)->y;
                $studInfo['studAge']=htmlentities($age);
                
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
        public function MedcineTreat(&$medicine,$medString){
            $tempArr=explode('|',$medString);
            $count=0;
            foreach($tempArr as $medStr){
                $medicine[$count]=explode(',',$medStr);
                $count++;
            }
            //medicine variable is a 2-D array now
            //scan every first value of all 1-D array
            $medCode=array();
            for($i=0;$i<$count;$i++){
                if(filter_var($medicine[$i][0],FILTER_VALIDATE_INT)){
                    $medCode[]=(int)$medicine[$i][0];
                }
                else{
                    $medicine[$i][3]=ucfirst($medicine[$i][0]);
                }
            }
            $this->connToDB();
            $params=implode(',',array_fill(0,count($medCode),'?'));
            $query="SELECT med_ID,med_name FROM MedInfo WHERE med_ID IN ($params)";
            $stmt=($this->conn)->prepare($query);

            $argType=str_repeat('i',count($medCode));       //create string of 'iiii'
            $mainArg=array_merge(array($argType),$medCode); //merge string with medCode iiii,1,2

            //calls $stmt->bind_param by passing reference
            call_user_func_array(array($stmt,'bind_param'),$this->ref($mainArg));

            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows){
                $stmt->bind_result($ID,$name);
                while($stmt->fetch()){
                    for($i=0;$i<$count;$i++){
                        if((int)$medicine[$i][0]===$ID){
                            $medicine[$i][3]=htmlentities(ucfirst($name));
                            break;
                        }
                    }
                }
                $stmt->close();
                ($this->conn)->close();
            }
            else{
                $stmt->close();
                ($this->conn)->close();
            }
        }
        /*
        *function to create a reference
        *
        *bind_param function requires reference to the value
        *rather than getting exact value itself
        *
        */
        protected function ref($arr) {
            $refs = array();
            foreach ($arr as $key => $val){ 
                $refs[$key] = &$arr[$key];
            }
            return $refs;
        }
    }//End Of Class
    

    
    $test=new FetchAll;
    $reply=$test->FetchInfo($visitID,$visitInfo,$studInfo,$docInfo);
    if($reply!=200){
        http_response_code(403);
        exit();
    }
    $test->MedcineTreat($medicine,$visitInfo['medicine']);

    require_once 'view_pdf.php';
    ob_start();

    $pdf=new myPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->PDFStudInfo($studInfo);
    $pdf->PDFDocInfo($docInfo);
    $pdf->PDFVisitInfo($visitInfo);
    $pdf->PDFMedicine($medicine);
    $pdf->Output();

?>
</html>