<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: list-roms.php: Give all roms in database table 'roms'.
// the adress would be something like this: http://<domain>/<path>/list-roms.php
// Connect to server and select database.
include('./pages/safe_admin.php');
mysql_connect("$db_host", "$db_user", "$db_pass")or die("cannot connect");
mysql_select_db("$db_db")or die("cannot select DB");

	$sql="SELECT * FROM gebruikers";
	$result=mysql_query($sql);
?>
<H2>Userlist</H2>
<table style="width:100%; border-spacing:0;">
<tr>
<th>Username</th>
<th>Status</th>
<th>Email</th>
<th>Active</th>
<th>Last Active</th>
<th><a href="?page=useradd">Add Rom</a></th>
</tr>
<?php
	while($rows=mysql_fetch_array($result)){
?>
<tr>
<td><? echo $rows['naam']; ?></td>
<? if($rows['status'] == 1) { ?><td>Admin</td><? } else { ?><td>User</td><? } ?>
<td><? echo $rows['email']; ?></td>
<? if($rows['actief'] == 1) { ?><td>Active</td><? } else { ?><td>Inactive</td><? } ?>
<td><? echo $rows['lastactive']; ?></td>

<!--- link to update.php and send value of id --->
<td align="center"><a href="?page=userupdate&id=<? echo $rows['id']; ?>">update</a>-<a href="?page=userdel_ac&id=<? echo $rows['id']; ?>">delete</a></td>
</tr>
<?php

	}
?>
</table>
<?php
mysql_close();
?>

