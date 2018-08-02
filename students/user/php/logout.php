<?php
    session_start();
    ob_start();
    if(isset($_SESSION['logout_val'])){
        if($_POST['logout_val'] === hash('ripemd128',$_SESSION['logout_val'])){
            session_destroy();
            $data=NULL;
            if(isset($_COOKIE['user'])){
                setcookie('user',$data,time()-2970000,'/',null,null,true);    
                header("Location: logout.html");
                exit();
            }            
            
        }
    }
    http_response_code(400);
?>