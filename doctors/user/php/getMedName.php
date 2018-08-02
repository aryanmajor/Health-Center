<?php
    require_once('../../../database/database.php');
    ini_set('display_errors',1);
            ini_set('display_startup_errors',1);
            error_reporting(E_ALL);
    header("Content-type: application/json");

    $conn=new mysqli($hn,$un,$pw,$db);
    $medName=htmlentities($conn->real_escape_string($_GET['query']));
    
    if(strlen($medName)>=2){
        $resultss=array();
        $query='SELECT med_ID,med_name,med_quant FROM MedInfo WHERE med_name LIKE ?';
        $stmt=$conn->prepare($query);
        $medName='%'.strtolower($medName).'%';
        $stmt->bind_param('s',$medName);
        $stmt->execute();
        
        $stmt->store_result();
        if($stmt->num_rows){
            $stmt->bind_result($ID,$name,$quant);
            $count=0;
            while($stmt->fetch()){
                $resultss[$count]['mName']=htmlentities(ucfirst($name));
                $resultss[$count]['mQuant']=htmlentities($quant);
                $resultss[$count]['mCode']=htmlentities($ID);
                
                $count++;
            }
            $stmt->close();
            $conn->close();
            echo json_encode($resultss);
        }
        else{
            $stmt->close();
            $conn->close();
        }
        
    }
    else{
        $conn->close();
    }
?>