<?php
include('safe_admin.php');
// Connect to server and select database.
//mysql_connect("$db_host", "$db_user", "$db_pass")or die("cannot connect");
//mysql_select_db("$db_db")or die("cannot select DB");

$id=$_GET['id'];
//$sql = "SELECT * FROM gebruikers WHERE id = '".$id."'";
//$result=mysql_query($sql);
//$rows=mysql_fetch_array($result);

// update data in mysql database
//if(isset($rows['id'])) {
	$stmt = $db->stmt_init();
    $stmt->prepare('DELETE FROM `gebruikers` WHERE `id` = ? ');
    $stmt->bind_param('i', $id);
    //$sql="DELETE FROM gebruikers WHERE  id='$id'";
	//$result=mysql_query($sql);
	// if successfully updated.
	if($stmt->execute()){
		echo "Deleted Successfully";
		echo "<BR>";
		echo "<a href='?page=listusers'>View result</a>";
	} else {
		echo "ERROR";
	}
//} else {
//	echo "This rom does not exist.";
//}
