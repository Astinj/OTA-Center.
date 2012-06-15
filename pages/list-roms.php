<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: list-roms.php: Give all roms in database table 'roms'.
// the adress would be something like this: http://<domain>/<path>/list-roms.php
// Connect to server and select database.
include('safe.php');
//mysql_connect("$db_host", "$db_user", "$db_pass")or die("cannot connect");
//mysql_select_db("$db_db")or die("cannot select DB");

$stmt = $db->stmt_init();
if ($_SESSION['user_status'] == 1) {
    //$sql="SELECT * FROM roms";
    $stmt->prepare('SELECT `id`, `rom`, `version`, `url`, `userid`, `device` FROM `roms`');
} else {
    //$sql="SELECT * FROM roms WHERE userid='$_SESSION[user_id]'";
    $stmt->prepare('SELECT `id`, `rom`, `version`, `url`, `userid`, `device` FROM `roms` WHERE `userid` = ?');
    $stmt->bind_param('i', $_SESSION['user_id']);
}
$stmt->execute();
$stmt->bind_result($rom_id, $rom_name, $rom_version, $rom_url, $rom_userid, $rom_device);

//$result=mysql_query($sql);
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
    //while($rows=mysql_fetch_array($result)){
    while ($stmt->fetch()) {
        ?>
        <tr>
            <td><a href="<? echo $sitebaseurl; ?>pages/romupdate.php?romname=<? echo $rom_name; ?>"><? echo $rom_name; ?></a></td>
            <td><? echo $rom_version; ?></td>
            <td><? echo $rom_url; ?></td>
            <td><? echo $rom_userid; ?></td>
            <td><? echo $rom_device; ?></td>

            <!--- link to update.php and send value of id --->
            <td align="center"><a href="?page=update&id=<? echo $rom_id; ?>">update</a>-<a href="?page=del_ac&id=<? echo $rom_id; ?>">delete</a></td>
        </tr>
        <?php
    }
    stmt->close();
    ?>
</table>
