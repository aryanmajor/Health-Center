<body onload="sh()">
        <div class="container">
            <h1>LogIn</h1>
            <div class="main_item">
            <!-- Login -->
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" autocomplete="off" method="POST">
                <br><?php
                        if($LIerror['logInfo']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$LIerror['logInfo']."</div>";
                        }
                ?>
                    <br>
                <span class="indication">User I.D.</span><br>
                <input type="text" name="userID" placeholder="Enter User ID" 
                       <?php 
                            if(isset($LIproValue[0])){
                                echo 'value="'.$LIproValue[0].'"';
                            }
                       ?>
                       required autofocus>
                <br>
                <?php
                        if($LIerror['userID']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$LIerror['userID']."</div><br>";
                        }
                ?>
                    
                <span class="indication">Password</span><br>
                <input type="password" name="pass" placeholder="Enter Password" maxlength="5" required>
                <br>
                    <?php
                        if($LIerror['pass']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$LIerror['pass']."</div><br>";
                        }
                ?>
                    <br>
                    <input type="hidden" name="const" value="1">
                <input type="submit"  value="LogIn">
                <br><br>
                <a href="students/forgotatp.php" >Forgot Password</a>
                </form>
            </div>
        </div>

</body>