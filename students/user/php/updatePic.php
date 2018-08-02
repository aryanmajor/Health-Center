<?php
	// requires php5
	$img = $_REQUEST['data'];
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = $_REQUEST['schID']. '.jpeg';
	$success = file_put_contents('../photos/'.$file, $data);
	echo $success ? 'Successfully Updated' : 'Unable to save the file.';
?>