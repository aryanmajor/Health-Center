<!DOCTYPE html>
<html>
<body>
    <link rel="stylesheet" href="w3.css">
<body>
	<button onclick=" setup();" class="w3-button w3-black">Upload New Picture</button>
    
<div class="w3-container">
    <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-card-4  w3-animate-right" style="width:40%;">
      <header class="w3-container w3-teal"> 
        <span onclick="document.getElementById('id01').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
        <h2>Upload Picture</h2>
      </header>
        
      <div class="w3-container" id="my_camera" style="padding-left:20%;">
      </div>
        <div class="w3-container" id="my_image" style="padding-left:20%;display: none;">
        </div>
        <footer class="w3-container w3-teal w3-center">
        <p><button class="img_but" onclick="take_snapshot();">Click Picture</button>
            <button class="img_but" style="display: none;" onclick="send_data();">Submit</button></p>
      </footer>
    </div>
  </div>
 </div>
    
<!-- SCRIPTING TIME -->
    <!-- First, include the Webcam.js JavaScript Library -->
	<script src="jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="webcam.min.js"></script>
	
	<!-- Configure a few settings and attach camera -->
	<script language="JavaScript">
		Webcam.set({
			width: 320,
			height: 240,
			image_format: 'jpeg',
			jpeg_quality: 90
		});
	</script>

<!-- Code to handle taking the snapshot and displaying it locally -->
	<script language="JavaScript">
        var uri='';
		function setup() {
            $("#id01").show();
			Webcam.reset();
                $("#my_image").hide();
                $("#my_camera").show();
                $(".img_but").eq(1).hide();
                $(".img_but").eq(0).show();
			Webcam.attach( '#my_camera' );
		}
		
		function take_snapshot() {
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
                Webcam.reset();
                $(".img_but").eq(1).show();
                $(".img_but").eq(0).hide();
				// display results in page
                $("#my_image").show();
                $("#my_camera").hide();
				document.getElementById('my_image').innerHTML = 
					'<img src="'+data_uri+'"/>';
                uri=data_uri;
			} );
		}
        function send_data(){
            var xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange=function(){
                if(this.readyState==4 && this.status==200){
                    alert(this.responseText);
                }
                else{
                    alert(this.readyState+' '+this.status);
                }
            };
            xhttp.open("POST", "rec.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("data="+uri);
        }
	</script>
</body>
</body>
</html>