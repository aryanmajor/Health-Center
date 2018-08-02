<body onload="sh()">
        <div class="container">
            
            
            
            <div class="main_item">
            <!-- Login -->
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" autocomplete="off" method="POST">
                <br><?php
                        if($LIerror['logInfo']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$LIerror['logInfo']."</div>";
                        }
                ?>
                    <br>
                Enter Your Scholar I.D. :: <br>
                <input type="text" name="schID" placeholder="Enter ScholarID" 
                       <?php 
                            if(isset($LIproValue[0])){
                                echo 'value="'.$LIproValue[0].'"';
                            }
                       ?>
                       required autofocus maxlength="10">
                <br>
                <?php
                        if($LIerror['schID']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$LIerror['schID']."</div><br>";
                        }
                ?>
                    
                Enter Your 5 Digit A.T.P. :: <br>
                <input type="password" name="satps" placeholder="Enter ATP" maxlength="4" required>
                <br>
                    <?php
                        if($LIerror['ATP']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$LIerror['ATP']."</div><br>";
                        }
                ?>
                    
                    <input type="hidden" name="const" value="1">
                <input type="submit"  value="LogIn">
                <br>
                <a href="students/forgotatp.php" >Forgot ATP</a>
                </form>
            </div>
		
            <div class="main_item noDisp">
                
            <!-- Register -->
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" autocomplete="off"  method="POST" name="register">
                Enter Your Scholar I.D. :: <br>
                <input type="text" id="sID" name="schID" autofocus placeholder="Enter ScholarID" 
                       <?php 
                            if(isset($SUprovVal['schID'])){
                                echo 'value="'.$SUprovVal['schID'].'"';
                            }
                       ?> 
                       required onkeyup="return chkSchID(event)" maxlength="10">
                    <br>
                    <?php
                        if($SUerror['schID']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$SUerror['schID']."</div><br>";
                        }
                    ?>
                
                <input type="hidden" name="const" value="2">
                    
                <!--If Student Is Not Registered-->
                <div id="caution" class="noDisp">
                <span>Sorry! You Are Not Registered<br>
                    Contact <a href="mailto:feedback@roghaari.com?Subject=Registration%20Not%20Done">feedback@roghaari.com</a> For Further Support
                    </span>    
                </div>
                
                <div id="alreD" class="noDisp">
                <span>You Have Already Registered<br>
                    Continue To Login<br>
                    </span>    
                </div>
                    
                <!--If Student Is Registered-->
                <div id="info" class="noDisp">
                    Name:: <input type="text" readonly name='name' id="RegNameS"
                                  <?php 
                            if(isset($SUprovVal['name'])){
                                echo 'value="'.$SUprovVal['name'].'"';
                            }
                       ?> >
                    <br>
                    <?php
                        if($SUerror['name']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$SUerror['name']."</div><br>";
                        }
                    ?>
                    
					Enter Height (in cms.)::
					<input type="text" name="height" placeholder="Enter Height"
                        <?php 
                            if(isset($SUprovVal['height'])){
                                echo 'value="'.$SUprovVal['height'].'"';
                            }
                       ?>
                           required><br>
                    
                    <?php
                        if($SUerror['height']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$SUerror['height']."</div><br>";
                        }
                    ?>
                    
                    
                    Enter Weight (in kgs.) ::
					<input type="text" name="weight" placeholder="Enter Weight" 
                        <?php 
                            if(isset($SUprovVal['weight'])){
                                echo 'value="'.$SUprovVal['weight'].'"';
                            }
                       ?> 
                           required>
                    <br>
                    <?php
                        if($SUerror['weight']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$SUerror['weight']."</div><br>";
                        }
                    ?>
                    
                    Email I.D. ::
					<input type="text" name="emailID" placeholder="Email ID" readonly
                           <?php 
                            if(isset($SUprovVal['emailID'])){
                                echo 'value="'.$SUprovVal['emailID'].'"';
                            }
                       ?> >
                    <br>
                    <?php
                        if($SUerror['emailID']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$SUerror['emailID']."</div><br>";
                        }
                    ?>
                    
                    Select Blood Group ::
					<select name="bldgrp" 
                        <?php 
                        if(isset($SUprovVal['bldgrp'])){
                            echo 'value="'.$SUprovVal['bldgrp'].'"';
                        }
                       ?> 
                            >
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    </select>
                    <br>
                    
                    <?php
                        if($SUerror['bldgrp']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$SUerror['bldgrp']."</div><br>";
                        }
                    ?>
                    
                    Enter Hostel ::
                    <select name="hostel">
                    <option value="1">Hostel Number 1</option>
                    <option value="2">Hostel Number 2</option>
                    <option value="3">Hostel Number 3</option>
                    <option value="4">Hostel Number 4</option>
                    <option value="5">Hostel Number 5</option>
                    <option value="6">Hostel Number 6</option>
                    <option value="7">Hostel Number 7</option>
                    <option value="8">Hostel Number 8</option>
                    <option value="9">P.G. Hostel</option>
                    <option value="10">Girls Hostel 1</option>
                    <option value="11">Girls Hostel 2</option>
                    </select>
                    <br>
                    
                    <?php
                        if($SUerror['hostel']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$SUerror['hostel']."</div><br>";
                        }
                    ?>
                    
                    
                    Enter Room Number ::
					<input type="text" name="rnum" placeholder="Enter Room Number" 
                           <?php 
                           if(isset($SUprovVal['rnum'])){
                                echo 'value="'.$SUprovVal['rnum'].'"';
                            }
                       ?> 
                           required>
                    <br>
                    <?php
                        if($SUerror['rnum']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$SUerror['rnum']."</div><br>";
                        }
                    ?>
                    
                    Enter D.O.B. ::
					<input type="date" data-date-inline-picker="true" name="dob" 
                           <?php 
                            if(isset($SUprovVal['dob'])){
                                echo 'value="'.$SUprovVal['dob'].'"';
                            }
                       ?> 
                           required><br>
                    <?php
                        if($SUerror['dob']!=NULL){
                            echo "<div class='alert alert-danger'><strong>Warning! </strong>".$SUerror['dob']."</div><br>";
                        }
                    ?>
                    <input type="submit" value="GET A.T.P.">
                </div>  
                   
                </form>
            </div>
            <div class="option">
                Not Registered?
            </div>
            <div class="option noDisp">
                Already Registered? LogIn Now
            </div> 
        </div>
<script>
    function chkSchID(event){
        var schID=document.register.schID.value;
        if(schID.length==10){
            var xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange=function(){
                if(xhttp.readyState==4 && xhttp.status==200){
                    var reply=this.responseText;
                    if(reply==0){
                        document.getElementById("caution").classList.remove("noDisp");
                    }
                    else if(reply==1){
                        document.getElementById("alreD").classList.remove("noDisp");
                    }
                    else{
                        var infoAr=this.responseText.split(";;");
                        document.getElementById("info").classList.remove("noDisp");
                        document.register.name.value=infoAr[0];
                        document.register.emailID.value=infoAr[1]; 
                    }
                }
            };
            xhttp.open("GET","students/scripts/fetchInfoID.php?id="+schID,true);
            xhttp.send();
        }
        else{
            document.getElementById("info").classList.add("noDisp");
            document.getElementById("caution").classList.add("noDisp");
            document.getElementById("alreD").classList.add("noDisp")
        }
    }
    function sh(){
        var ValInName=document.getElementById("RegNameS").value.length;
        if(ValInName){
            document.getElementsByClassName("main_item")[0].classList.add("hid");
            document.getElementsByClassName("main_item")[1].classList.remove("hid");
            document.getElementById("info").classList.remove("noDisp");
        }
    }
</script>
</body>