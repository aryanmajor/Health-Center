<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(E_ALL);
    
    session_start();


    $Continue=0;
    if((!isset($_SESSION['StaffLogIN']))||($_SESSION['StaffLogIN']!=200)){

        require '../../php/Login.php';
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
        http_response_code(403);
        exit;
    }
            
    //Login Confirmed
    
    //block user if schID is not submitted
    /*if(!filter_has_var(INPUT_POST,"schID")){
        http_response_code(403);
        exit;
    } */
    class GetMedName{
        
        public $schID;
        public $medStr;
        public $medicine=array();
        protected $conn;
        
        protected function connToDB(){
            $this->conn=new mysqli("localhost","root","SQLroot","Dispensary");
            if(($this->conn)->connect_error){
                http_response_code(500);
                return 0;
            }
        }
       
        public function sanitize(){
            $this->connToDB();
            $this->schID=htmlentities(($this->conn)->real_escape_string($_POST['schID']));
            ($this->conn)->close();
        }
        /*
        *@return 200 on success
        *@return 0 on failure
        */
        public function getMedStr(){
            $this->connToDB();

            $query="SELECT medicine_reg,medicine_recieved
                    FROM VisitInfo WHERE 
                    stud_scholarID=? ORDER BY visit_ID DESC LIMIT 1";
            $stmt=($this->conn)->prepare($query);
            $stmt->bind_param('s',$this->schID);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows){
                $stmt->bind_result($med_reg,$med_rec);
                $stmt->fetch();
                $stmt->close();
                ($this->conn)->close();
                if($med_rec!=""){
                    $this->medStr="";
                }
                else{                    
                    $this->medStr=$med_reg;
                }
                return 200;
            }
            else{
                $stmt->close();
                ($this->conn)->close();
                return 0;
            }
        }
        
        public function getMedName(){
            
            $tempArr=explode('|',$this->medStr);
            $count=0;
            foreach($tempArr as $value){
                $this->medicine[$count]=explode(',',$value);
                $count++;
            }
            //medicine variable is a 2-D array now
            //scan every first value of all 1-D array
            $medCode=array();
            for($i=0;$i<$count;$i++){
                if(filter_var($this->medicine[$i][0],FILTER_VALIDATE_INT)){
                    $medCode[]=(int)$this->medicine[$i][0];
                }
                else{
                    $this->medicine[$i][3]=ucfirst($this->medicine[$i][0]);
                }
            }
            $this->connToDB();
            $params=implode(',',array_fill(0,count($medCode),'?'));
            
            $query="SELECT med_ID, med_name FROM MedInfo WHERE med_ID IN ($params)";
            $stmt=($this->conn)->prepare($query);

            $argType=str_repeat('i',count($medCode));       //create string of 'iiii'
            $mainArg=array_merge(array($argType),$medCode); //merge string with medCode iiii,1,2

            //calls $stmt->bind_param by passing reference
            
            call_user_func_array( array($stmt , 'bind_param') , $this->ref($mainArg));
/*
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows){
                $stmt->bind_result($ID,$name);
                while($stmt->fetch()){
                    for($i=0;$i<$count;$i++){
                        if((int)$this->medicine[$i][0]===$ID){
                            $this->medicine[$i][3]=htmlentities(ucfirst($name));
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
*/

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
    }
    $medName=new GetMedName;
    $medName->schID='1615042';
    $medName->getMedStr();
    $jsonMed=json_encode($medName->medStr);
    $medName->getMedName();

    echo $jsonMed;

?>