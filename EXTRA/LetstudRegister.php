<?php    
    
    if(!filter_has_var(INPUT_POST,"schID")||$_POST["schID"]==NULL){
            $error['schID']="Enter Scholar I.D.";
        }
        if(!filter_has_var(INPUT_POST,"weight")||($_POST["weight"]==NULL)){
            $error['weight']="Enter Weight.";
        }
        else if(!filter_input(INPUT_POST,"weight",FILTER_VALIDATE_FLOAT)){
            $error['weight']="Weight Must Be In Decimal or Numeral.";
        }
        if(!filter_has_var(INPUT_POST,"height")||($_POST["height"]==NULL)){
            $error['height']="Enter Height.";
        }
        else if(!filter_input(INPUT_POST,"height",FILTER_VALIDATE_FLOAT)){
            $error['height']="Height Must Be In Decimal or Numeral.";
        }
        if($_POST['emailID']&&!filter_input(INPUT_POST,"emailID",FILTER_VALIDATE_EMAIL)){
            $error['emailID']="Enter Correct Email I.D.";
        }
        $choice=array("A+","B+","A-","B-","O+","O-","AB+","AB-");
        if(!filter_has_var(INPUT_POST,"bldgrp")){
            $error['bldgrp']="Choose A BloodGroup.";
        }
        else if(!in_array($_POST['bldgrp'],$choice)){
            $error['bldgrp']="Choose An Option From Given One.";
        }
        if(!filter_has_var(INPUT_POST,"hostel")||($_POST["hostel"]==NULL)){
            $error['hostel']="Enter A Hostel Name.";
        }
        
        if(!filter_has_var(INPUT_POST,"dob")||($_POST["dob"]==NULL)){
            $error['dob']="Enter Your Date Of Birth.";
        }
        $datearr=explode("-",$_POST['dob']);
        if(!checkdate($datearr[1],$datearr[2],$datearr[0])){
            $error['dob']="Enter Correct Date Of Birth.";
        }
        if(!CheckempTy($error)){
            $errorFound=1;
        }

        function CheckempTy($array){
            foreach($array as $key => $val) {
                if (!empty($val))
                    return false;
                }
            return true;
        }

?>