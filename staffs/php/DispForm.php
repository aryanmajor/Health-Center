
<body class="w3-light-grey">
        
        <div class="w3-third w3-card w3-white w3-margin-bottom w3-text-indigo main_item w3-animation-left">
    
              <header class="w3-container w3-indigo w3-text-white w3-block">
    <h3><b><i class="fa fa-user-circle"></i> Login</b></h3>
  </header>
            <div class="w3-container  w3-padding-48">
        
            <!-- Login -->
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" autocomplete="off" method="POST">
                    
            <?php
                //LogIn Error

                if($LIerror['logInfo']!=NULL){
                    echo "<strong><div class='w3-red'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>"
                    .$LIerror['logInfo']."</div></strong>";
                }
            ?>
                    <p><label><b>
                        <i class="fa fa-user fa-fw w3-margin-right w3-large"></i>
                        User I.D. :</b></label> <br>
                <input type="text" name="userID" placeholder="User ID" class="w3-input w3-border" 
                       <?php
                            //Scholat ID Value
                            if(isset($LIproValue[0])){
                                echo 'value="'.$LIproValue[0].'"';
                            }
                       ?>
                       >
                <?php
                        //Scholar ID Error
                        if($LIerror['userID']!=NULL){
                            echo "<strong><div class='w3-red'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$LIerror['userID']."</div></strong><br>";
                        }
                ?>
                <br>
                  <label><b>
                        <i class="fa fa-user-secret fa-fw w3-margin-right w3-large "></i>
                        Password : </b></label><br>
                <input type="password" name="pass" placeholder="Password" maxlength="4" required class="w3-input w3-border">
                    
                <?php
                    //Password Error
                    if($LIerror['pass']!=NULL){
                        echo "<strong><div class='w3-red'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$LIerror['pass']."</div></strong><br>";
                    }
                ?>
                <br>
                    <input type="hidden" name="const" value="1">
                <p><button type="submit" class="w3-button w3-round-xlarge w3-block w3-white w3-border w3-border-indigo w3-hover-indigo"> <i class="fa fa-location-arrow fa-fw w3-margin-right w3-large"></i>LogIn</button>
                <hr>
                <p>
                    <label class="w3"><b><a href="forgotPass.php" >
                        <i class="fa fa-user-times fa-fw w3-margin-right w3-large"></i>  
                        Forgot Password</a></b></label>
                    </p>
                    </p>
                </form>
            </div>  
        <hr>
              <p><b>
            <div class="option w3-block">                
                 Not Registered ?               
            </div>
        </b></p>
    </div>
    </body></html>