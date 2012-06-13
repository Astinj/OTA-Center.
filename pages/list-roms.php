<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: list-roms.php: Give all roms in database table 'roms'.
// the adress would be something like this: http://<domain>/<path>/list-roms.php
// Connect to server and select database.
include('./pages/safe.php');
mysql_connect("$db_host", "$db_user", "$db_pass")or die("cannot connect");
mysql_select_db("$db_db")or die("cannot select DB");
	if($_SESSION['user_status'] == 1) {
		$sql="SELECT * FROM roms";
	} else {
		$sql="SELECT * FROM roms WHERE userid='$_SESSION[user_id]'";
	}
	$result=mysql_query($sql);
?>
<table style="width:100%; border-spacing:0;">
<tr>
<th>Rom</th>
<th>Version</th>
<th>url</th>
<th>userid</th>
<th>device</th>
<th><a href="?page=add">Add Rom</a></th>
</tr>
<?php
	while($rows=mysql_fetch_array($result)){
?>
<tr>
<td><a href="<? echo $sitebaseurl; ?>pages/romupdate.php?romname=<? echo $rows['rom']; ?>"><? echo $rows['rom']; ?></a></td>
<td><? echo $rows['version']; ?></td>
<td><? echo $rows['url']; ?></td>
<td><? echo $rows['userid']; ?></td>
<td><? echo $rows['device']; ?></td>

<!--- link to update.php and send value of id --->
<td align="center"><a href="?page=update&id=<? echo $rows['id']; ?>">update</a>-<a href="?page=del_ac&id=<? echo $rows['id']; ?>">delete</a></td>
</tr>
<?php

	}
?>
</table>
<?php
mysql_close();
?>

