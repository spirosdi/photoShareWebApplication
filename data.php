<?
function connect(){
	//connect to database
	$con = mysql_connect("localhost","wantedpi_photoSh","a1234567!");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("wantedpi_photoShare", $con);
	mysql_query("SET NAMES utf8");  
}

function register($username,$password,$email)
{
	connect();
	mysql_query("INSERT INTO users (username, password, email) VALUES ('".$username."', '".$password."','".$email."')");
	

}

function getComments($id){
	connect();
	$result = mysql_query("SELECT * FROM comment where photo='".$id."'");
	return $result;
}

function addComment($comment,$photo,$user){
	connect();
	if($user=="")
		$user="ανώνυμος";
	mysql_query("INSERT INTO comment (text, photo, user) VALUES ('".$comment."', '".$photo."','".$user."')");
}

function getPhotos(){
	connect();
	$result = mysql_query("SELECT * FROM photos where public='true'");
	return $result;
}

function getTags(){
	connect();
	$result = mysql_query("SELECT name FROM tags");
	return $result;
}


function validateUsername($username)
{
	connect();
	$result = mysql_query("SELECT * FROM users where username='".$username."'");
	$num_rows = mysql_num_rows($result);
	return $num_rows;
	
}
function getTop10()
{	
	connect();
	$result = mysql_query("SELECT * FROM photos where public='true' ORDER BY popularity desc");
	return $result;
}
function getDetails($id)
{	
	connect();
	$result = mysql_query("SELECT * FROM photos where id='".$id."' and public='true'");
	increasePop($id);
	return $result;
}

function changePhoto($title,$description,$id){
	connect();
	if($title!="")
		mysql_query("UPDATE photos SET title='".$title."' WHERE id='".$id."'");
	if($description!="")
		mysql_query("UPDATE photos SET description='".$description."' WHERE id='".$id."'");

}

function getPhoto($id)
{	
	connect();
	$result = mysql_query("SELECT * FROM photos where id='".$id."' and public='true'");
	return $result;
}


function getTagCloud()
{	
	connect();
	$result = mysql_query("SELECT * FROM tags");
	return $result;
}

function deletePhoto($photo){
	connect();
	$result = mysql_query("SELECT * FROM photos where id='".$photo."'");
	while($row = mysql_fetch_array($result))
 	{
		$tag1=$row['tag1'];
		$tag2=$row['tag2'];
		$tag3=$row['tag3'];
		$tag4=$row['tag4'];
		if($tag1!=""){
			mysql_query("UPDATE tags SET sum=sum-1 WHERE name='".$tag1."'");
		}

		if($tag2!=""){
			mysql_query("UPDATE tags SET sum=sum-1 WHERE name='".$tag2."'");
		}
		if($tag3!=""){
			mysql_query("UPDATE tags SET sum=sum-1 WHERE name='".$tag3."'");
		}
		if($tag4!=""){
			mysql_query("UPDATE tags SET sum=sum-1 WHERE name='".$tag4."'");
		}

	}
	mysql_query("DELETE FROM photos WHERE id='".$photo."'");
	
}
function changePassword($username,$password){
	connect();
	mysql_query("UPDATE users SET password='".$password."' WHERE username='".$username."'");

}

function changeEmail($username,$email){
	connect();
	mysql_query("UPDATE users SET email='".$email."' WHERE username='".$username."'");

}

function increasePop($id){
	mysql_query("UPDATE photos SET popularity=popularity+1 WHERE id='".$id."'");

}

function checkLogin($username,$password){
	connect();
	$result = mysql_query("SELECT * FROM users where username='".$username."' and password='".$password."'");
	$num_rows = mysql_num_rows($result);
	return $num_rows;
}

function insertPhoto($image,$title,$description, $public, $tag1,$tag2,$tag3,$tag4, $position, $user){
	connect();
	mysql_query("INSERT INTO photos (image,title,description, public, tag1,tag2,tag3,tag4, position, user) VALUES ('".$image."', '".$title."','".$description."', '".$public."', '".$tag1."', '".$tag2."', '".$tag3."', '".$tag4."', '".$position."', '".$user."')");


if($tag1!=""){
	mysql_query("INSERT INTO tags (name) VALUES ('".$tag1."')");
	mysql_query("UPDATE tags SET sum=sum+1 WHERE name='".$tag1."'");
}

if($tag2!=""){
	mysql_query("INSERT INTO tags (name) VALUES ('".$tag2."')");
	mysql_query("UPDATE tags SET sum=sum+1 WHERE name='".$tag2."'");
}

if($tag3!=""){
	mysql_query("INSERT INTO tags (name) VALUES ('".$tag3."')");
	mysql_query("UPDATE tags SET sum=sum+1 WHERE name='".$tag3."'");
}

if($tag4!=""){
	mysql_query("INSERT INTO tags (name) VALUES ('".$tag4."')");
	mysql_query("UPDATE tags SET sum=sum+1 WHERE name='".$tag4."'");
}

}

function getByTag($name){
	connect();
	$result = mysql_query("SELECT * FROM photos where public='true' and (tag1='".$name."' or tag2='".$name."' or tag3='".$name."' or tag4='".$name."')");
	return $result;
}

function getUser($user){
	connect();
	$result = mysql_query("SELECT * FROM users where username='".$user."'");
	return $result;
}

function getCapacity($user){
	connect();
	$result = mysql_query("SELECT * FROM photos where user='".$user."'");
	return $result;
}

function getAlbum($user){
	connect();
	$result = mysql_query("SELECT * FROM photos where user='".$user."'");
	return $result;
}

function runSearchByTag($search)
{	
	connect();
	echo $search;
	$result = mysql_query("SELECT * FROM photos where public='true' and (tag1='".$search."' or tag2='".$search."' or tag3='".$search."' or tag4='".$search."')");
	return $result;
}

function runSearch($query)
{	
	connect();
	$result = mysql_query($query);
	return $result;
}

function getTagSum($name)
{	
	connect();
	$result = mysql_query("SELECT sum FROM tags where name='".$name."'");
	$row = mysql_fetch_array($result);
	$sum=$row['sum'];
	return $sum;
}

mysql_close($con);
?>

