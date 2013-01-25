<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?
include("data.php");

function showTags(){
	$result=getTags();
	while($row = mysql_fetch_array($result))
 	{
		$a[]=$row['name'];
	}
	return $a;
}

function populatePhotos(){
	$result=getPhotos();
$i=0;
	while($row = mysql_fetch_array($result))
 	{
$javaScript.="
var image".$i." = new google.maps.MarkerImage('".$row['image']."',
new google.maps.Size(100, 100),
new google.maps.Point(0,0),
new google.maps.Point(0, 32),new google.maps.Size(40));
var marker".$i." = new google.maps.Marker({
  position: new google.maps.LatLng(".$row['position']."),
  icon: image".$i.",
  map: map
});


var contentString".$i." = '".$row['title']." <br/><a href=\"details.php?id=".$row['id']."\">προβολή λεπτομερειών</a>';

var infowindow".$i." = new google.maps.InfoWindow({
    content: contentString".$i."
});

google.maps.event.addListener(marker".$i.", 'click', function() {
  infowindow".$i.".open(map,marker".$i.");
});
";

$i=$i+1;

  	}
return $javaScript;

}
function showTop10(){
	$result = getTop10();
	$i=1;
	while($row = mysql_fetch_array($result))
 	{?>
		<?echo $i.".";
		  $i++;
		?>	
		<a href="details.php?id=<?echo $row['id'];?>"><?echo $row['title'];?></a><br/>
	<?
	}	
}	
function showDetails($id){
	$result = getDetails($id);
	while($row = mysql_fetch_array($result))
 	{?>	<a href="index.php" style="font-size:25px; float:right;">Χ</a>
		<h1><?echo $row['title'];?></h1>
		<hr/>
		<img height="300" src="<?echo $row['image'];?>"/><br/>
		<?echo $row['description']?>
	<?
	}
}



function showByTag($name){
	$result = getByTag($name);
	?><a href="index.php" style="font-size:25px; float:right;">Χ</a><?
	while($row = mysql_fetch_array($result))
 	{?>	<div>
		<img height="150" src="<?echo $row['image'];?>"/><br/>
		<a href="details.php?id=<?echo $row['id'];?>"><?echo $row['title'];?></a>
		</div>
		<hr/>
	<?
	}
}

function editPhoto($id){
	$result=getPhoto($id);
	while($row = mysql_fetch_array($result))
 	{?>	<div>
		<img height="150" src="<?echo $row['image'];?>"/><br/>
		<form action="logic.php" method="post">
			<input type="hidden" name="id" value="<?echo $row['id'];?>"/><br/>
			<strong>αλλαγή τίτλου</strong><br/>
			<input type="text" name="title" value="<?echo $row['title'];?>"/><br/>
			<strong>αλλαγή περιγραφής</strong><br/>
			<textarea name="description"><?echo $row['description'];?></textarea><br/>
			<input type="submit" value="αλλαγή" name="editPhoto"/>
		</form>
		</div>
	<?
	}
}
function showAlbum($user){
	$result = getAlbum($user);
	?><a href="index.php" style="font-size:25px; float:right;">Χ</a><?
	while($row = mysql_fetch_array($result))
 	{?>	<div>
		<img height="150" src="<?echo $row['image'];?>"/><br/>
		<a href="details.php?id=<?echo $row['id'];?>"><?echo $row['title'];?></a>
		<form action="logic.php" method="post">
			<input type="hidden" value="<?echo $row['id'];?>" name="photo"/>
			<input type="submit" value="διαγραφή φωτογραφίας" name="deletePhoto"/>
		</form>
		<a href="editphoto.php?id=<?echo $row['id'];?>">τροποποίηση φωτογραφίας</a>
		

 		</form>
		</div>
		<hr/>
	<?
	}
}

function showSearchByTag($search){
	$result = runSearchByTag($search);
	while($row = mysql_fetch_array($result))
 	{?>	<div>
		<img height="150" src="<?echo $row['image'];?>"/><br/>
		<a href="details.php?id=<?echo $row['id'];?>"><?echo $row['title'];?></a>
		</div>
		<hr/>
	<?
	}
}

function showCapacity($user){
	$result=getCapacity($user);
	$used=0;
	while($row = mysql_fetch_array($result))
 	{	
		$size = filesize($row['image']);
		$used=$used+$size;
	}
	echo "Χρησιμοποιείτε περίπου ";
	echo $used/1000000;
	echo " Mbytes από τα 50 Μbytes που δικαιούστε: ";
	echo "<div style=\"width:495px;border:1px solid gray;\">";
	$percent=($used/1000000/50)*100;
	echo "<div style=\"width:".$percent."%;height:30px;background:green;\"></div>";
	echo "</div>";
}

function showUser($user){
	$result=getUser($user);
	while($row = mysql_fetch_array($result))
 	{	
		echo "username:<br/>";
		echo "<strong>".$row['username']."</strong>";
		echo "<br/>";
		echo "email:<br/>";
		echo "<strong>".$row['email']."</strong>";
		echo "<hr/>";
		echo "<form action=\"logic.php\" method=\"POST\">";
		echo "αλλαγή password:<br/>";
		echo "<input type=\"password\" name=\"password\"/>";
		echo "<input type=\"hidden\" name=\"username\" value=\"".$user."\">";
		echo "<input type=\"submit\" name=\"changePassword\" value=\"αλλαγή κωδικού\"/>";
		echo "<br/></form>";
		echo "αλλαγή email:<br/><form action=\"logic.php\" method=\"POST\">";
		echo "<input type=\"email\" name=\"email\"/>";
		echo "<input type=\"hidden\" name=\"username\" value=\"".$user."\">";
		echo "<input type=\"submit\" name=\"changeEmail\" value=\"αλλαγή email\"/>";
		echo "<br/>";

	}
}

function showSearch($search){
	$searchTerms = explode(" ", $search);
	$query="SELECT * FROM photos where title REGEXP ('";
	foreach ($searchTerms as &$searchTerm) {
		$query.="(";
   		$query.=$searchTerm;
		$query.=")|";
	}
	unset($searchTerm); 
	$query=substr_replace($query ,"",-1);
	$query.="')";
	$query.=" OR description REGEXP ('";
	foreach ($searchTerms as &$searchTerm) {
		$query.="(";
   		$query.=$searchTerm;
		$query.=")|";
	}
	$query=substr_replace($query ,"",-1);
	$query.="')";
	$result=runSearch($query);
	?><a href="index.php" style="font-size:25px; float:right;">Χ</a><?
	while($row = mysql_fetch_array($result))
 	{?>	<div>
		<img height="150" src="<?echo $row['image'];?>"/><br/>
		<a href="details.php?id=<?echo $row['id'];?>"><?echo $row['title'];?></a>
		</div>
		<hr/>
	<?
	}
}


function showTagCloud(){
	$result = getTagCloud();
	$sumAll=0;
	while($row = mysql_fetch_array($result))
 	{	
		$sum=getTagSum($row['name']);
		$sumAll=$sumAll+$sum;
	}
	$result = getTagCloud();
	while($row = mysql_fetch_array($result))
 	{	
		$sum=getTagSum($row['name']);
		if($sum==0){
		
		}
		else if($sum/$sumAll<=0.3)
			echo "<h4><a href=\"showByTag.php?id=".$row['name']."\">".$row['name']."</a></h4>";
		else if($sum/$sumAll<=0.6)
			echo "<h3><a href=\"showByTag.php?id=".$row['name']."\">".$row['name']."</a></h3>";
		else if($sum/$sumAll<=1)
			echo "<h2><a href=\"showByTag.php?id=".$row['name']."\">".$row['name']."</a></h2>";
	}
}

function showComments($id){
	$result=getComments($id);
	while($row = mysql_fetch_array($result))
 	{?>
		<div style="border:1px solid black">
			από χρήστη: <?echo $row['user'];?><br/>
			<?echo $row['text'];?>

		</div>
	<?
	}
}


function resize($originalImage){


$image = new Imagick( $originalImage );
$image->thumbnailImage(1024,0);



return $image;
}

if (isset($_POST['register'])){
	//validate
	if(validateUsername($_POST['username'])){
		?><meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare"></HEAD><?
		echo "To username που επιλέξατε υπάρχει ήδη, ξαναδοκιμάστε με διαφορετικό, παρακαλώ περιμένετε...";
		break;
	}
	register($_POST['username'],$_POST['password'],$_POST['email']);
	?>
	<meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare"></HEAD><?
	echo "Η εγγραφή έγινε επιτυχώς, παρακαλώ περιμένετε...";
}

if (isset($_POST['login'])){
	if(!checkLogin($_POST['username'],$_POST['password'])){
		?><meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare"></HEAD><?
		echo "Tα στοιχεία που πληκτρολογήσατε είναι λάθος, παρακαλώ περιμένετε...";
		break;
	}
	?>
	<meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare"></HEAD><?
	echo "Η σύνδεση έγινε επιτυχώς, παρακαλώ περιμένετε...";
	$_SESSION['username']=$_POST['username'];

}

if (isset($_POST['deletePhoto'])){
	deletePhoto($_POST['photo']);
	?>
	<meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare"></HEAD><?
	echo "Η διαγραφή της φωτογραφίας έγινε επιτυχώς, παρακαλώ περιμένετε...";
}



if (isset($_POST['logout'])){?>
	<meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare"></HEAD><?
	echo "Η αποσύνδεση έγινε επιτυχώς, παρακαλώ περιμένετε...";
	session_destroy();


}
if (isset($_POST['changePassword'])){
	changePassword($_POST['username'],$_POST['password']);
	?>
	<meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare"></HEAD><?
	echo "Η αλλαγή έγινε επιτυχώς, παρακαλώ περιμένετε...";
}


if (isset($_POST['editPhoto'])){
	changePhoto($_POST['title'],$_POST['description'], $_POST['id']);
	?>
	<meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare"></HEAD><?
	echo "Η αλλαγή έγινε επιτυχώς, παρακαλώ περιμένετε...";
}

if (isset($_POST['newComment'])){
	addComment($_POST['comment'],$_POST['photo'],$_POST['user']);
	?>
	<meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare"></HEAD><?
	echo "To σχόλιό σας καταχωρήθηκε, παρακαλώ περιμένετε...";
}


if (isset($_POST['changeEmail'])){
	changeEmail($_POST['username'],$_POST['email']);
	?>
	<meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare"></HEAD><?
	echo "Η αλλαγή έγινε επιτυχώς, παρακαλώ περιμένετε...";
}


if (isset($_POST['insertPhoto'])){

	$filename = basename($_FILES['file']['name']);
  	$ext = substr($filename, strrpos($filename, '.') + 1);
  	if (($ext == "jpg") || ($ext == "jpeg") || ($ext == "JPG") || ($ext == "png")){
		list($width, $height) = getimagesize($_FILES['file']['tmp_name']); 
		$image=$_FILES['file']['tmp_name'];
		move_uploaded_file($image, "upload/" . $_FILES["file"]["name"]);
		if($width>1280||$height>1024){
			try
			{
				$image="upload/".$_FILES['file']['name'];
				$im = new Imagick();
			        /*** ping the image ***/
			        $im->pingImage($image);
			        /*** read the image into the object ***/
			        $im->readImage( $image );
			        /*** thumbnail the image ***/
			        $im->thumbnailImage( 1280, null );
			        /*** Write the thumbnail to disk ***/
			        $im->writeImage( $image );
			        /*** Free resources associated with the Imagick object ***/
			        $im->destroy();
			}
			catch(Exception $e)
			{
			        echo $e->getMessage();
			}
		}
		$image="upload/".$_FILES['file']['name'];
		insertPhoto($image,$_POST['title'],$_POST['description'], $_POST['public'], $_POST['tag1'],$_POST['tag2'],$_POST['tag3'],$_POST['tag4'], $_POST['position'], $_SESSION['username'] );
		?><meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare/upload.php"></HEAD><?
		echo "Η φωτογραφία καταχωρήθηκε επιτυχώς, παρακαλώ περιμένετε...";
	}
	else{
		?><meta http-equiv="REFRESH" content="3;url=http://www.wantedpixel.com/photoShare/upload.php"></HEAD><?
		echo "Tα επιτρεπτά αρχεία είναι τύπου .jpg ή .png, ξαναπροσπαθήστε, παρακαλώ περιμένετε...";
		break;
	}


}


?>
