<?php
    $conn=new mysqli('localhost','root','SQLroot','Dispensary');
    if($conn->connect_error){
        echo 0;
    }
    //filtering required
    $sID=mysql_fix_string($conn,$_GET['id']);
    
    $query="SELECT stud_name,stud_email,stud_DOB FROM StudHealth WHERE scholar_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param('s',$sID);
    $stmt->execute();
    
    $stmt->store_result();
    if($stmt->num_rows){
        $stmt->bind_result($name,$email,$SHeight);
        $stmt->fetch();
        if($SHeight==NULL){
            $respText=$name.";;".$email;
            $conn->close();
            echo $respText;
        }
        else{
            echo 1;
        }
    }
    else{
        echo 0;
    }
    
    function mysql_fix_string($conn,$string){
        return htmlentities($conn->real_escape_string($string));
    }
?>