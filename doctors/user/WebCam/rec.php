<?php
	// requires php5
	$img = $_REQUEST['data'];
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = uniqid() . '.jpeg';
	$success = file_put_contents($file, $data);
	echo $success ? $file : 'Unable to save the file.';
?>