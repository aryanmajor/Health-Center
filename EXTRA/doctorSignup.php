<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style>
        #loginBox{
            width:50%;
            float:left;
        }
        #signupBox{
            width:50%;
            float: right;
        }
        input['text']{
            border:0px;
            outline: none;
        }
    </style>
</head>
    <body>
        <!--LOGIN BOX-->
        <div id="loginBox">
            <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
                Enter UserID<br>
                <input type="text" name="userid" placeholder="UserID"><br>
                Enter Password<br>
                <input type="password" name="pass" placeholder="Password"><br>
                <input type="submit" value="LogIN">
            </form>
        </div>
        
        <!--Signup BOX-->
        <div id="signupBox">
            <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
                Enter Doctor's Registration Number:<br>
                <input type="text" name="reg_no" placeholder="Doctor Registration Number"><br>
                Enter Doctor Name: (Without 'Dr.' )<br>
                <input type="text" name="name" placeholder="Enter Name"><br>
                Choose An UserID: <br>
                <input type="text" maxlength="15" name="user_id" placeholder="User I.D."><br>
                Choose A Password:<br>
                <input type="password" name="password"><br>
                <input type="submit" value="Register">
            </form>
        </div>
    </body>
</html>