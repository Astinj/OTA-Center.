<?php
include('./pages/safe_admin.php');
// Connect to server and select database.
mysql_connect("$db_host", "$db_user", "$db_pass")or die("cannot connect");
mysql_select_db("$db_db")or die("cannot select DB");
// update data in mysql database
$md5pass = md5($_POST['wachtwoord']);
$sql="INSERT INTO gebruikers (naam, wachtwoord, status, email, actief, actcode) VALUES('$_POST[naam]','$md5pass','$_POST[status]','$_POST[email]','$_POST[actief]','$_POST[actcode]')";
$result=mysql_query($sql);
// if successfully updated.
if($result){
	echo "Added Successfully";
	echo "<BR>";
	echo "<a href='?page=listusers'>View result</a>";
} else {
	echo "ERROR";
}
?>