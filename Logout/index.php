<!DOCTYPE html>
<html>
<title>Health Center | Doctor</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href='../w3.css'>
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  

<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
</style>
<body class="w3-light-grey">
<?php
    session_start();
    ob_start();
    if(isset($_SESSION['logout_val'])){
        if($_POST['logout_val'] === hash('ripemd128',$_SESSION['logout_val'])){
            session_destroy();
            $data=NULL;
            if(isset($_COOKIE['user'])){
                setcookie('user',$data,time()-2970000,'/',null,null,true);    
                ?>

        <div class="w3-card-4 w3-third w3-padding-24 w3-teal" style="position: absolute;left:33%;top:20%; padding-left: 25px;"> 
        <i class="fa fa-thumbs-up fa-fw w3-margin-right w3-xxxlarge"></i><strong>LogOut Successfull !</strong>
        </div>

<?php
            }            
            
        }
    }
    http_response_code(400);
?>
    </body>
</html>