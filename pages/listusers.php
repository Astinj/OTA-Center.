<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: list-roms.php: Give all roms in database table 'roms'.
// the adress would be something like this: http://<domain>/<path>/list-roms.php
include 'safe_admin.php';

$page_num = 0;
$perpage = 20;
if (isset($_GET['p'])) $page_num = intval($_GET['p']);
$pageoffset = $page_num * $perpage;

$stmt = $db->stmt_init();
$stmt->prepare('SELECT SQL_CALC_FOUND_ROWS `id`, `naam`, `email`, `status`, `actief`, `lastactive` FROM `gebruikers` ORDER BY `id` LIMIT ?, ?');
$stmt->bind_param('ii', $pageoffset, $perpage);
$stmt->execute();
$stmt->bind_result($id, $rij_naam, $rij_email, $status, $actief, $lastactive);

?>
<h2>Userlist</h2>
<table style="width:100%; border-spacing:0;">
    <tr>
        <th>Username</th>
        <th>Status</th>
        <th>Email</th>
        <th>Active</th>
        <th>Last Active</th>
        <th><a href="?page=useradd">Add User</a></th>
    </tr>
    <?php
    while ($stmt->fetch()) {
        $naam = htmlspecialchars($rij_naam);
        $email = htmlspecialchars($rij_email);
        ?>
        <tr>
            <td><? echo $naam; ?></td>
            <? if ($status == 1) { ?><td>Admin</td><? } else { ?><td>User</td><? } ?>
            <td><? echo $rows['email']; ?></td>
            <? if ($actief == 1) { ?><td>Active</td><? } else { ?><td>Inactive</td><? } ?>
            <td><? echo $lastactive; ?></td>

            <!--- link to update.php and send value of id --->
            <td align="center">
                <a href="?page=userupdate&id=<? echo $id; ?>">update</a> &bull;
                <a href="?page=userdel_ac&id=<? echo $id; ?>">delete</a>
            </td>
        </tr>
        <?php
    }
    $stmt->close();

    $total_count_row = $db->query('SELECT FOUND_ROWS()')->fetch_row();
    $total_count = $total_count_row[0];
    ?>
    <tr><td colspan="3" style="text-align:left;font-size:smaller;">
        Showing <?php echo $pageoffset + 1; ?> - <?php echo min($total_count, $pageoffset + $perpage); ?> of <?php echo $total_count; ?> users.
    </td><td colspan="3" style="text-align:right;font-size:smaller;">
        <?php if ($page_num != 0) { ?>
            <a href="?page=listusers&p=<?php echo ($page_num-1); ?>">&laquo;</a>
        <?php }
        $maxpage = ceil($total_count / $perpage);
        ?>
        Page <?php echo ($page_num+1); ?> of <?php echo $maxpage; ?>
        <?php if ($page_num < $maxpage - 1) { ?>
            <a href="?page=listusers&p=<?php echo ($page_num+1); ?>">&raquo;</a>
        <?php } ?>
    </td></tr>
</table>
