<?php session_start(); ?>
<!DOCTYPE html>
<?include("logic.php");?>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

		<style type="text/css">
			html { height: 100% }
			body { height: 100%; margin: 0; padding: 0 }
			#map_canvas { height: 100% position:absolute;top:0px;left:0px}
			#left_column{height:100%;width:400px;background:rgba(255, 254, 242, 0.8);position:absolute;top:0px;left:70px;z-index:10;padding-left:10px;padding-top:8px;}

#tagCloud h5,#tagCloud h4, #tagCloud h3, #tagCloud h2{
				padding-top:0px!important;
				padding-bottom:0px!important;
				margin:0px!important;
				display:inline-block;
				padding-right:8px;
			}
#main{height:100%;width:600px;background:rgba(255, 254, 242, 0.8);position:absolute;top:0px;left:536px;z-index:10;padding-left:10px;padding-top:8px;}


			#signupForm div{width:224px;text-align:right;}
			.label{width:64px;text-align:right;display:inline-block}
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
		}
	
		function initialize2() {
			var myOptions = {
		 	       center: new google.maps.LatLng(38.254465,21.737072),
			       zoom: 14,
			       mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
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
			<div id="tagCloud">
				Tag Cloud<br/>
				<?showTagCloud();?>
				<br/>
				Αναζήτηση στις Ετικέτες<br/>
				<form action="searchByTag.php" method="post">
					<input type="text" name="search" id="txt1" onkeyup="showHint(this.value)" />
					<input type="submit" name="searchButton" value="αναζήτηση" id="searchBT"/>
				</form>
				<div>Μήπως εννοείτε: <span id="txtHint"></span></div> 

			</div>
			<hr/>
			<div id="search">
				Αναζήτηση<br/>
				<form action="search.php" method="post">
					<input type="text" name="search" id="searchi"/>
					<input type="submit" name="searchButton" id="searchB" value="αναζήτηση"/>
				</form>
		</div>


		<div id="main">
			<?showCapacity($_SESSION['username']);?>
			<h2>Το προσωπικό σας album:</h2>
			<?showAlbum($_SESSION['username']);?>
		</div>


	  </body>
</html>
