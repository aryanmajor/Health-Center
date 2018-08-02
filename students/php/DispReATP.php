 <div class="w3-margin-bottom w3-half w3-card-4 w3-white largeContainer w3-text-dark-grey w3-border w3-border-deep-orange">
     <div class="w3-half w3-padding-24 smallContainer" >
         <header class="w3-text-deep-orange">Recover ATP</header>
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" autocomplete="off" method="POST">
                    <label>
                        <i class="fa fa-user fa-fw w3-margin-right w3-large"></i>
                        User I.D.</label> <br>
                <input type="text" name="schID" autofocus placeholder="Enter ScholarID"  
                       <?php 
                                if(isset($provVal['schID'])){
                                    echo 'value="'.$provVal['schID'].'"';
                                }
                        ?>
                       required>
                <?php
                        //Scholar ID Error
                        if($error['schID']!=NULL){
                            echo "<strong><div class='w3-deep-orange'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$error['schID']."</div></strong><br>";
                        }
                ?>
                <br>
                  <label>
                        <i class="fa fa-envelope fa-fw w3-margin-right w3-large "></i>
                        Email ID</label><br>
                <input type="text" name="emailID" autofocus placeholder="Enter Email ID" requideep-orange 
                       <?php 
                            if(isset($provVal['emailID'])){
                                echo 'value="'.$provVal['emailID'].'"';
                            }
                       ?> 
                        required>
                    
                <?php
                        if($error['emailID']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$error['emailID']."</div><br>";
                        }
                    ?>
                <br>
                    <input type="hidden" name="const" value="1">
                <button type="submit" class="w3-button w3-round-large w3-white w3-border w3-border-deep-orange w3-hover-deep-orange"> <i class="fa fa-check-square-o  w3-margin-right w3-large w3-deep-orange"></i> Resend ATP</button>
                    
                    <hr>
                    
                </form>
     </div>
     <div class="w3-half" style="background:url('../pics/forgotpass.jpg');"></div>
</div>