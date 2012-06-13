<?php
if(isset($_SESSION['user_id'])) {
	// Connect to server and select database.
	mysql_connect("$db_host", "$db_user", "$db_pass")or die("cannot connect");
	mysql_select_db("$db_db")or die("cannot select DB");
	// update data in mysql database
	$sql="INSERT INTO roms (rom, version, buildfingerprint, url, md5, changelog, userid, device, romversionname) VALUES('$_POST[rom]','$_POST[version]','$_POST[buildfingerprint]','$_POST[url]','$_POST[md5]','$_POST[changelog]','$_SESSION[user_id]','$_POST[device]','$_POST[romversionname]')";
	$result=mysql_query($sql);
	// if successfully updated.
	if($result){
		echo "Added Successfully";
		echo "<BR>";
		echo "<a href='?page=list-roms'>View result</a>";
	} else {
		echo "ERROR";
	}
} else {
	echo "You are not logged in.";
	header("Location: ?page=denied");
	exit();
}
?>