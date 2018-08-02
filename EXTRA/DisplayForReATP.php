<div class="container">
                <div class="main_item">
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" autocomplete="off"  method="POST" name="register">
                    Enter Your Scholar I.D. :: <br>
                    <input type="text" name="schID" autofocus placeholder="Enter ScholarID" 
                           <?php 
                                if(isset($provVal['schID'])){
                                    echo 'value="'.$provVal['schID'].'"';
                                }
                        ?> 
                        required maxlength="10">
                    <br>
                    <?php
                        if($error['schID']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$error['schID']."</div><br>";
                        }
                    ?>
                
                Enter Your E-Mail I.D. :: <br>
                <input type="text" name="emailID" autofocus placeholder="Enter Email ID" 
                       <?php 
                            if(isset($provVal['emailID'])){
                                echo 'value="'.$provVal['emailID'].'"';
                            }
                       ?> 
                       required>
                    <br>
                    <?php
                        if($error['emailID']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$error['emailID']."</div><br>";
                        }
                    ?>
                <input type="submit" value="Verify And Send ATP">
               </form>
           </div>
        </div>