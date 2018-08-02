<?php
	require_once 'database.php';
	$conn=new mysqli($hn,$un,$pw,$db);
	if($conn->connect_error){
		http_response_code(500);
	}
	if(!filter_has_var(INPUT_POST,'schID')||!filter_has_var(INPUT_POST,'satps')){
		ob_start();
		header("Location: students.php");
		exit();
	}
	$sch_id=htmlspecialchars($_POST['schID'], ENT_QUOTES, UTF-8);
	$loginpw=password_hash($_POST['satps'],PASSWORD_BCRYPT);

	$query="SELECT * FROM StudHealth WHERE scholar_id='".$sch_id."'";
	$result=$conn->query($query);
	if(!$result){
		http_response_code(500);	
	}
	
	if($result->num_rows==0){
			//wrong id
		echo "$sch_id";
		include 'include/LetstudentDisp.php';
	}
	else{
		$result->data_seek(0);
		$userarr=$result->fetch_array(MYSQLI_ASSOC);
		if(password_verify($loginpw,$userarr['stud_ATP'])){
			//create cookie
			$salt1="Roghaari2020BT";
			$salt2="LTBUF1516";
			$cookData=$sch_id.";".ripemd128("$salt1$sch_id$salt2");
			set_cookie('user_stud',$cookData,time()+(60*60*24*7));
			//login
			session_start();
			$_SESSION['stud_name']=$userarr['stud_name'];
			$_SESSION['stud_height']=$userarr['stud_height'];
			$_SESSION['stud_weight']=$userarr['stud_weight'];
			$_SESSION['stud_BMI']=$userarr['stud_BMI'];
			$_SESSION['stud_bloodgrp']=$userarr['stud_bloodgrp'];
			$_SESSION['stud_hostel']=$userarr['stud_hostel'];
			$_SESSION['stud_roomNum']=$userarr['stud_roomNum'];
			$_SESSION['stud_DOB']=$userarr['stud_DOB'];
			$_SESSION['stud_branch']=$userarr['stud_branch'];
			$_SESSION['stud_batch']=$userarr['stud_batch'];
			$result->close();
			$conn->close();
			ob_start();
			header("Location: studentPage.php");
			exit();
		}
		else{
			include 'include/LetstudentDisp.php';
		}
	}
?>