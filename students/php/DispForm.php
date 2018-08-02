<body onload="sh()" class="w3-light-grey">

    <div class="w3-margin-bottom w3-card-4 w3-white largeContainer w3-text-dark-grey">
        <div class="w3-third w3-padding-24 w3-border-blue w3-border smallContainer" >
            <header class="w3-text-blue">Login</header>
            <!-- Login -->
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" autocomplete="off" method="POST">
                    
            <?php
                //LogIn Error

                if($LIerror['logInfo']!=NULL){
                    echo "<strong><div class='alertion' style='width:90%;'>
                    "
                    .$LIerror['logInfo']."</div></strong>";
                }
            ?>
                    <p><label>
                        <i class="fa fa-user fa-fw w3-margin-right w3-large"></i>
                        Enter Your Scholar I.D. :</label> <br>
                <input type="text" name="schID" placeholder="Enter ScholarID" class="" 
                       <?php
                            //Scholat ID Value
                            if(isset($LIproValue[0])){
                                echo 'value="'.$LIproValue[0].'"';
                            }
                       ?>
                        maxlength="7" required>
                <?php
                        //Scholar ID Error
                        if($LIerror['schID']!=NULL){
                            echo "<strong><div class='alertion'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$LIerror['schID']."</div></strong><br>";
                        }
                ?>
                <br>
                  <label>
                        <i class="fa fa-user-secret fa-fw w3-margin-right w3-large "></i>
                        Enter Your 5 Digit A.T.P. : </label><br>
                <input type="password" name="satps" placeholder="Enter ATP" maxlength="4" required class="">
                    
                <?php
                    //Password Error
                    if($LIerror['ATP']!=NULL){
                        echo "<strong><div class='alertion'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$LIerror['ATP']."</div></strong><br>";
                    }
                ?>
                <br>
                    <input type="hidden" name="const" value="1">
                        <button type="submit" class="w3-button w3-round-xlarge w3-text-blue w3-border w3-border-blue w3-hover-blue"> <i class="fa fa-user-circle fa-fw w3-margin-right w3-large"></i>LogIn</button>
                <hr class="w3-blue">
                    <label class="w3"><a href="forgotatp.php" >
                        <i class="fa fa-user-times fa-fw w3-margin-right w3-large"></i>  
                        Forgot ATP</a></label>
                </form>
        </div>
        <div class="w3-third smallContainer w3-centered" style="padiing:0px;margin:0px;background: url('pics/stud.jpg');background-size: cover;">
            
        </div>
        
        <div class="w3-third  w3-padding-24 w3-border-blue  w3-border smallContainer" style="overflow-y:scroll;overflow-x:hidden;">
            
            <header class="w3-text-blue">Register</header>

            <!-- Register -->
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" autocomplete="off"  method="POST" name="register">
                <p><label>
                        <i class="fa fa-user fa-fw w3-margin-right w3-large"></i>
                    Enter Your Scholar I.D. :</label> <br>
                <input type="text" id="sID" name="schID" autofocus placeholder="Enter ScholarID" required onkeyup="return chkSchID(event)" maxlength="7"
                       class=""
                <?php 
                    //Value Of Scholar ID
                    if(isset($SUprovVal['schID'])){
                        echo 'value="'.$SUprovVal['schID'].'"';
                    }
                ?>
                >
                </p>
                <?php
                    //Scholar ID Error
                    if($SUerror['schID']!=NULL){
                        echo "<strong><div class='alertion'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$SUerror['schID']."</div></strong><br>";
                    }
                ?>
                <input type="hidden" name="const" value="2">
                    
                <!--If Student Is Not Registered-->
                <div id="caution" class="noDisp w3-text-blue w3-padding-16 w3-center">
                    <strong><i class='fa fa-close fa-fw w3-centered w3-xlarge'></i><br>
                Sorry!</strong> You Cannot Request This Service !<br> Contact <a href="mailto:feedback@roghaari.com?Subject=Registration%20Not%20Done">
                    <strong>feedback@roghaari.com</strong></a> For Further Support
                    
                </div>
                
                <div id="alreD" class="noDisp w3-text-blue w3-padding-16 w3-center">
                <strong><i class='fa fa-exclamation-circle fa-fw w3-centered w3-xlarge'></i><br>
                You Have Already Registered<br>
                    Continue To Login<br> 
                    </strong>
                </div>
                    
                <!--If Student Is Registered-->
                <div id="info" class="noDisp">
                    <p><label>
                        <i class="fa fa-address-card fa-fw w3-margin-right w3-large"></i>
                        Name: </label><br><input type="text" readonly name='name' id="RegNameS" class=""
                        
                       <?php 
                            //Value Of Name
                            if(isset($SUprovVal['name'])){
                                echo 'value="'.$SUprovVal['name'].'"';
                            }
                       ?>
                        >
                     <?php
                        //Error
                        if($SUerror['name']!=NULL){
                            echo "<strong><div class='alertion'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$SUerror['name']."</div></strong><br>";
                        }
                    ?>    
                        
                    <br>
                    <label>
                        <i class="fa fa-arrows-v fa-fw w3-margin-right w3-large"></i>
                        Enter Height (in cms.):</label><br>
					<input type="text" name="height" placeholder="Enter Height" class=""
                   <?php 
                        //Value Of Height
                        if(isset($SUprovVal['height'])){
                            echo 'value="'.$SUprovVal['height'].'"';
                        }
                    ?>>
                    
                    <?php
                        //Height Error
                        if($SUerror['height']!=NULL){
                            echo "<strong><div class='alertion'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$SUerror['height']."</div></strong><br>";
                        }
                    ?>
                    <label>
                        <i class="fa fa-tachometer fa-fw w3-margin-right w3-large"></i>
                        Enter Weight (in kgs.) :</label><br>
					<input type="text" name="weight" placeholder="Enter Weight" class="" required
                    <?php 
                           //Weight Value
                            if(isset($SUprovVal['weight'])){
                                echo 'value="'.$SUprovVal['weight'].'"';
                            }
                       ?>>
                    <?php
                        //Weight Error
                        if($SUerror['weight']!=NULL){
                            echo "<strong><div class='alertion'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$SUerror['weight']."</div></strong><br>";
                        }
                    ?>
                    <br>
                    <label>
                        <i class="fa fa-envelope fa-fw w3-margin-right w3-large"></i>
                        Email I.D. :</label><br>
					<input type="text" name="emailID" placeholder="Email ID" class="" readonly
                    <?php 
                        if(isset($SUprovVal['emailID'])){
                            echo 'value="'.$SUprovVal['emailID'].'"';
                        }
                   ?> >
                    <?php
                        if($SUerror['emailID']!=NULL){
                            echo "<strong><div class='alertion'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$SUerror['emailID']."</div></strong><br>";
                        }
                    ?>
                    <br>
                    <label>
                        <i class="fa fa-plus-square fa-fw w3-margin-right w3-large"></i>
                        Select Blood Group :</label><br>
					<select name="bldgrp" class="w3-select" style="margin-right:2%;">
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
                        //Blood Group Error
                        if($SUerror['bldgrp']!=NULL){
                            echo "<strong><div class='alertion'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$SUerror['bldgrp']."</div></strong><br>";
                        }
                    ?>
                        <br>
                    <label>
                        <i class="fa fa-home fa-fw w3-margin-right w3-large"></i> Enter Hostel : </label><br>
                    <select name="hostel" class="w3-select" style="margin-right:2%;">
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
                        //Hostel Error
                        if($SUerror['hostel']!=NULL){
                            echo "<strong><div class='alertion'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$SUerror['hostel']."</div></strong><br>";
                        }
                    ?>
                        <br>
                   <label>
                        <i class="fa fa-map-marker fa-fw w3-margin-right w3-large"></i>
                       Enter Room Number :</label>
					<input type="text" name="rnum" placeholder="Enter Room Number" class="" required
                   <?php
                        //Room Number Value
                        if(isset($SUprovVal['rnum'])){
                            echo 'value="'.$SUprovVal['rnum'].'"';
                        }
                    ?>>
                    <?php
                        //Room Number Error
                        if($SUerror['rnum']!=NULL){
                            echo "<strong><div class='alertion'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$SUerror['rnum']."</div></strong><br>";
                        }
                    ?>
                    <br>
                    <label>
                        <i class="fa fa-smile-o fa-fw w3-margin-right w3-large"></i> Enter D.O.B. : </label>
					<br>
                    <input type="date" data-date-inline-picker="true" name="dob" 
                           required>
                    <?php
                        //DOB Error
                        if($SUerror['dob']!=NULL){
                            echo "<strong><div class='alertion'>
                    <i class='fa fa-exclamation-triangle fa-fw w3-margin-right w3-large'></i>".$SUerror['dob']."</div></strong><br>";
                        }
                    ?>
                        <br>
                    <p><button type="submit" class="w3-button w3-round-xlarge w3-block w3-white w3-border w3-border-blue w3-hover-blue w3-text-blue"> <i class="fa fa-location-arrow fa-fw w3-margin-right w3-large"></i>Register</button>
                <hr>
                    </div>
            </form>
        </div>
    </div>
                
        <!---------------------------------------------REGISTER--------------------->
<script>
    function chkSchID(event){
        var schID=document.register.schID.value;
        if(schID.length==7){
            
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
            xhttp.open("GET","js/fetchInfoID.php?id="+schID,true);
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
            $('#info').show();
        }
    }
</script>

    </body>