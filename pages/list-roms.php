<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: list-roms.php: Give all roms in database table 'roms'.
// the adress would be something like this: http://<domain>/<path>/list-roms.php
// Connect to server and select database.
include 'safe.php';

$page_num = 0;
$perpage = 20;
if (isset($_GET['p'])) $page_num = intval($_GET['p']);
$pageoffset = $page_num * $perpage;

$stmt = $db->stmt_init();
if ($_SESSION['user_status'] == 1) {
    $stmt->prepare('SELECT SQL_CALC_FOUND_ROWS `id`, `rom`, `version`, `url`, `userid`, `device` FROM `roms` LIMIT ?, ?');
    $stmt->bind_param('ii', $pageoffset, $perpage);
} else {
    $stmt->prepare('SELECT SQL_CALC_FOUND_ROWS `id`, `rom`, `version`, `url`, `userid`, `device` FROM `roms` WHERE `userid` = ? LIMIT ?, ?');
    $stmt->bind_param('iii', $_SESSION['user_id'], $pageoffset, $perpage);
}
$stmt->execute();
$stmt->bind_result($rom_id, $rij_rom_name, $rij_rom_version, $rij_rom_url, $rom_userid, $rij_rom_device);

?>
<table style="width:100%; border-spacing:0;">
    <tr>
        <th>ROM Name</th>
        <th>Version</th>
        <th>Device</th>
        <th><a href="?page=add">Add Rom</a></th>
    </tr>
    <?php
    while ($stmt->fetch()) {
        $rom_name = htmlspecialchars($rij_rom_name);
        $rom_version = htmlspecialchars($rij_rom_version);
        $rom_url = htmlspecialchars($rij_rom_url);
        $rom_device = htmlspecialchars($rij_rom_device);
        ?>
        <tr>
            <td><? echo $rom_name; ?></td>
            <td><? echo $rom_version; ?></td>
            <td><? echo $rom_device; ?></td>

            <!--- link to update.php and send value of id --->
            <td align="center">
                <a href="<?php echo $rom_url; ?>" target="_blank">Download</a> &bull;
                <a href="?page=update&id=<? echo $rom_id; ?>">Update</a> &bull;
                <a href="?page=del_ac&id=<? echo $rom_id; ?>">Delete</a>
            </td>
        </tr>
        <?php
    }
    $stmt->close();

    $total_count_row = $db->query('SELECT FOUND_ROWS()')->fetch_row();
    $total_count = $total_count_row[0];
    ?>
    <tr><td colspan="2" style="text-align:left;font-size:smaller;">
        Showing <?php echo $pageoffset + 1; ?> - <?php echo min($total_count, $pageoffset + $perpage); ?> of <?php echo $total_count; ?> ROMs.
    </td><td colspan="2" style="text-align:right;font-size:smaller;">
        <?php if ($page_num != 0) { ?>
            <a href="?page=list-roms&p=<?php echo ($page_num-1); ?>">&laquo;</a>
        <?php }
        $maxpage = ceil($total_count / $perpage);
        ?>
        Page <?php echo ($page_num+1); ?> of <?php echo $maxpage; ?>
        <?php if ($page_num < $maxpage - 1) { ?>
            <a href="?page=list-roms&p=<?php echo ($page_num+1); ?>">&raquo;</a>
        <?php } ?>
    </td></tr>
</table>
