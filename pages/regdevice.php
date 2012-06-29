<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: update_ac: Updates the rom that is submitted in update
// the adress would be something like this: http://<domain>/<path>/update_ac.php
include 'config.php';

if (isset($_POST['do']) && isset($_POST['reg_id'])) {
    if ($_POST['do'] == 'register') {
        if (isset($_POST['device']) && isset($_POST['rom_id'])) {
            $stmt = $db->stmt_init();
            $stmt->prepare('INSERT INTO `ota_devices` (`reg_id`, `device`, `romid`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `device` = ?, `romid` = ?');
            $stmt->bind_param('sssss', $_POST['reg_id'], $_POST['device'], $_POST['rom_id'], $_POST['device'], $_POST['rom_id']);
            $stmt->execute();
            $stmt->close();
        }
    } else if ($_POST['do'] == 'unregister') {
        $stmt = $db->stmt_init();
        $stmt->prepare('DELETE FROM `ota_devices` WHERE `romid` = ?');
        $stmt->bind_param('s', $_POST['reg_id']);
        $stmt->execute();
        $stmt->close();
    }
}
?>
