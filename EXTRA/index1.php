<!DOCTYPE html>
<html>
    <head>
    <title>Health Center@NITS</title>
        <style>
            body , html{
                margin:0px;
                overflow-x: hidden;
            }
            #upper{
                position: absolute;
                top:0%;
                left:0%;
                width:100%;
                height:75%;
                background:linear-gradient(to bottom right,#C5CECB,#FFFFFF);
            }
            #bottom{
                position: absolute;
                top:75%;
                left:0%;
                width:100%;
                height:25%;
                background-color:rgb(54,143,143);
                color:#FFF;
                box-shadow: 0px -3px 10px rgb(150,150,150);
                font-family: sans-serif;
                padding-top: 5%;
            }
            .main_tag{
                font-size: 2.3em;
                margin-left: 10%;
                font-weight: 700;
            }
            .items{
                position: absolute;
                top:15%;
                left:10%;
                width:30%;
                height:45%;
                background:linear-gradient(
                                rgba(243, 0, 150, 0.3), 
                             rgba(243, 0, 150, 0.3)), 
                            url('pics/Doctor_Workspace.jpg');
                background-position: center;
                background-size: cover;
                border-radius:10%;
                box-shadow: 5px 5px 10px rgb(150,150,150);
                -webkit-transition: width 0.6s, height 0.6s,box-shadow 0.6s;
                transition: width 0.6s, height 0.6s,box-shadow 0.6s;
                text-align: center;
            }
            .items:hover{
                width:33%;
                height: 48%;
                box-shadow: 10px 10px 10px rgb(150,150,150);
                cursor:pointer;
            }
            .text{
                color:black;
                font-size: 3em ;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div id="upper">
            <a href="doctor.php"><div class="items">
                <span class="text" style="">Doctor</span>
                </div></a>
            <a href="students.php"><div class="items" style="left:50%;background:linear-gradient(
                                rgba(132, 216, 217, 0.3), 
                                rgba(132, 216, 217, 0.3)), 
                            url('pics/Hot-Desking.jpg');background-position: center;
                            background-size: cover;
                            ">
                
            </div></a>
        </div>
        <div id="bottom">
            <span class="main_tag"> Health Center @NITS </span>
            </div>
    </body>
</html>