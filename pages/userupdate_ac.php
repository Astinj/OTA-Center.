<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: update_ac: Updates the rom that is submitted in update
// the adress would be something like this: http://<domain>/<path>/update_ac.php
// Connect to server and select database.
include('./pages/safe_admin.php');
error_reporting(E_ALL); 
ini_set('display_errors', true);

mysql_connect($db_host, $db_user, $db_pass)or die("cannot connect");
mysql_select_db($db_db)or die("cannot select DB");


// when the form of update.php is submitted with info, continue, if else redirect to list-roms.php page
if(isset($_POST['submit_form'])) {
	// update data in mysql database
	$sql="UPDATE gebruikers SET naam='".$_POST['naam']."', wachtwoord='".$_POST['wachtwoord']."', status='".$_POST['status']."', email='".$_POST['email']."', actief='".$_POST['actief']."', lastactive='".$_POST['lastactive']."', actcode='".$_POST['actcode']."' WHERE id='".$_POST['id']."'";
	$result=mysql_query($sql);
	// if successfully updated.
	if($result){
		echo "Successful";
		echo "<BR>";
		echo "<a href='?page=listusers'>View result</a>";
	} else {
		echo "ERROR";
	}
} else {
header("Location: ?page=listusers");
}
?>