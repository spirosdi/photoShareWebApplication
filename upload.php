<?php session_start(); ?>
<!DOCTYPE html>
<?include("logic.php");?>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		 <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>          
		<script type="text/javascript" src="validate.js"> </script>
		<style type="text/css">
			html { height: 100% }
			body { height: 100%; margin: 0; padding: 0 }
			#map_canvas { height: 100% position:absolute;top:0px;left:0px}
			#left_column{height:100%;width:400px;background:rgba(255, 254, 242, 0.8);position:absolute;top:0px;left:70px;z-index:10;padding-left:10px;padding-top:8px;}
			#signupForm div{width:224px;text-align:right;}
			.label{width:64px;text-align:right;display:inline-block}
			#uploadForm .label{width:73px!important}
#tagCloud h5,#tagCloud h4, #tagCloud h3, #tagCloud h2{
				padding-top:0px!important;
				padding-bottom:0px!important;
				margin:0px!important;
				display:inline-block;
				padding-right:8px;
			}
		</style>

		
		<script type="text/javascript" 
		src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBiknA6AoukmWDjNUp_pjE-jTZGraUtpsQ&sensor=true">
		</script>

		<?
	$javascript=populatePhotos();
	?>
	<script type="text/javascript">
		function initialize(position) {
			var myOptions = {
	                    center: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
			    zoom: 14,
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
			<?php echo $javascript;?>


			google.maps.event.addListener(map, "rightclick", function(event) {
    				var lat = event.latLng.lat();
				var lng = event.latLng.lng();
				var elem = document.getElementById("position");
				elem.value = lat +', '+lng;
			});


		}
	
		function initialize2() {
			var myOptions = {
		 	       center: new google.maps.LatLng(38.254465,21.737072),
			       zoom: 14,
			       mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
			google.maps.event.addListener(map, "rightclick", function(event) {
    				var lat = event.latLng.lat();
				var lng = event.latLng.lng();
				var elem = document.getElementById("position");
				elem.value = lat +', '+lng;
			});
			<?php echo $javascript;?>
		}
		function getLocation(){
			if (navigator.geolocation)
			initialize2();
			navigator.geolocation.getCurrentPosition(initialize);
		}

	</script>

<script type="text/javascript">
function showHint(str)
{
var xmlhttp;
if (str.length==0)
  { 
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","gethint.php?q="+str,true);
xmlhttp.send();
}
</script>
	  </head>
	  <body onload="getLocation()">
		<div id="map_canvas" style="width:100%; height:100%"></div>






		<div id="left_column">
			<a href="index.php">αρχική</a><br/>
			<?if(isset($_SESSION['username'])){
				echo "Γεια σας ".$_SESSION['username']."!";
				?>
				<form action="logic.php" method="post">
					<input type="submit" value="αποσύνδεση" name="logout"/>
				</form>
				<hr/>
				<div id="usermenu">
					<a href="index.php">αρχική</a><br/>
					<a href="album.php">προβολή άλμπουμ</a><br/>
					<a href="upload.php">ανέβασμα φωτογραφίας</a><br/>
					<a href="account.php">ο λογαριασμός μου</a>
				</div>

				<hr/>
				Ανέβασμα Φωτογραφίας
				<div id="uploadForm">
					<form method="POST" enctype="multipart/form-data" action="logic.php">
						<div><span class="label">αρχείο:</span><input id="file2" type="file" name="file"/></div>
						<div><span class="label">τίτλος:</span><input id="title2" type="text" name="title"/></div>
						<div><span class="label">περιγραφή:</span><textarea id="description" name="description"></textarea></div>
						<div><span class="label">ετικέτα 1:</span><input id="txt1" onkeyup="showHint(this.value)" type="text" name="tag1"/></div>
						<div><span class="label">ετικέτα 2:</span><input id="txt1" onkeyup="showHint(this.value)" type="text" name="tag2"/></div>
						<div><span class="label">ετικέτα 3:</span><input id="txt1" onkeyup="showHint(this.value)" type="text" name="tag3"/></div>
						<div><span class="label">ετικέτα 4:</span><input id="txt1" onkeyup="showHint(this.value)" type="text" name="tag4"/></div>
				<div>Μήπως εννοείτε: <span id="txtHint"></span></div> 
						<div><span  class="label">θέση</span><input readonly="readonly" type="text" id="position" name="position"/></div>
						<div><span class="label">θέαση</span>

<select name="public">
<option value="true">Δημόσιο</option>
<option value="false">Ιδιωτικό</option>
</select>
						<div><input type="submit" id="uploadB" value="ανέβασμα" name="insertPhoto"/></div>
					</form>
				</div>
				<?
			}else{?>
			<div id="signupForm">
				Συνδεθείτε!
				<hr/>
				<form method="post" action="logic.php">
					<div><span class="label">username:</span><input id="usernameL" type="text" name="username"/></div>
					<div><span class="label">password:</span><input id="passwordL" type="password" name="password"/></div>
					<div><input type="submit" value="σύνδεση" name="login" id="loginB"/></div>
				</form>
			</div>
			<div id="signupForm">
				Εγγραφείτε!
				<hr/>
				<form method="post" action="logic.php">
					<div><span class="label">username:</span><input id="usernameR" type="text" name="username"/></div>
					<div><span class="label">password:</span><input id="passwordR" type="password" name="password"/></div>
					<div><span class="label">email:</span><input id="emailR" type="email" name="email"/></div>
					<div><input type="submit" value="εγγραφή" name="register" id="registerB"/></div>
				</form>
			</div>
			<?}?>				
			<hr/>
			<div id="top10">
				TOP 10<br/>
				<?showTop10();?>
			</div>
			<hr/>
		</div>
	  </body>
</html>
