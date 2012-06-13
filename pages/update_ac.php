<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: update_ac: Updates the rom that is submitted in update
// the adress would be something like this: http://<domain>/<path>/update_ac.php
// Connect to server and select database.
include('./pages/safe.php');
error_reporting(E_ALL); 
ini_set('display_errors', true);

mysql_connect($db_host, $db_user, $db_pass)or die("cannot connect");
mysql_select_db($db_db)or die("cannot select DB");


// when the form of update.php is submitted with info, continue, if else redirect to list-roms.php page
if(isset($_SESSION['user_id'])) {
	if(isset($_POST['submit_form'])) {

		// update data in mysql database
		$sql="UPDATE roms SET rom='".$_POST['rom']."', version='".$_POST['version']."', buildfingerprint='".$_POST['buildfingerprint']."', url='".$_POST['url']."', md5='".$_POST['md5']."', changelog='".$_POST['changelog']."', userid='".$_POST['userid']."', device='".$_POST['device']."', romversionname='".$_POST['romversionname']."' WHERE id='".$_POST['id']."'";
		$result=mysql_query($sql);

		// if successfully updated.
		if($result){
			echo "Successful";
			echo "<BR>";
			echo "<a href='?page=list-roms'>View result</a>";
		} else {
			echo "ERROR";
		}
	} else {
	header("Location: ?page=list-roms");
	}
} else {
	echo "You are not logged in";
}

?>