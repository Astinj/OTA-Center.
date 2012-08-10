<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: update_ac: Updates the rom that is submitted in update
// the adress would be something like this: http://<domain>/<path>/update_ac.php
include 'config.php';

if (isset($_POST['do']) && isset($_POST['reg_id'])) {
    $stmt = $db->stmt_init();
    $stmt->prepare('DELETE FROM `ota_devices` WHERE `reg_id` = ?');
    $stmt->bind_param('s', $_POST['reg_id']);
    $stmt->execute();
    $stmt->close();

    if ($_POST['do'] == 'register') {
        if (isset($_POST['reg_id'], $_POST['device'], $_POST['rom_id'], $_POST['device_id'])) {
            $stmt = $db->stmt_init();
            $stmt->prepare('INSERT INTO `ota_devices2` (`reg_id`, `device`, `romid`, `device_id`) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE `device` = ?, `romid` = ?, `reg_id` = ?, `device_id` = ?');
            $stmt->bind_param('ssssssss', $_POST['reg_id'], $_POST['device'], $_POST['rom_id'], $_POST['device_id'], $_POST['device'], $_POST['rom_id'], $_POST['reg_id'], $_POST['device_id']);
            $stmt->execute();
            $stmt->close();

            $stmt = $db->stmt_init();
            $stmt->prepare('SELECT `version`, `date`, `rom`, `url`, `md5`, `changelog` FROM `roms` WHERE `romid` = ? AND `device` = ? ORDER BY `version` ASC LIMIT 1');
            $stmt->bind_param('ss', $_POST['rom_id'], $_POST['device']);
            $stmt->execute();
            $stmt->bind_result($version, $date, $rom, $url, $md5, $changelog);

            if ($stmt->fetch()) {
                $json = array(
                    'version' => $version,
                    'date' => $date,
                    'rom' => $rom,
                    'url' => $url,
                    'md5' => $md5,
                    'changelog' => $changelog
                );
            } else {
                $json = array(
                    'error' => 'Invalid ROM ('.$romid.') & device ('.$device.') combo!'
                );
            }

            $stmt->close();

            echo json_encode($json);
        } else {
            echo json_encode(array('error' => 'Registration parameters not all present!'));
        }
    } else if ($_POST['do'] == 'unregister') {
        if (isset($_POST['reg_id'])) {
            $stmt = $db->stmt_init();
            $stmt->prepare('DELETE FROM `ota_devices2` WHERE `reg_id` = ?');
            $stmt->bind_param('s', $_POST['reg_id']);
            $stmt->execute();
            $stmt->close();
        } else {
            echo json_encode(array('error' => 'No registration ID provided for unregistration!'));
        }
    } else {
        echo json_encode(array('error' => 'Invalid action ('.$_POST['do'].')!'));
    }
} else {
    echo json_encode(array('error' => 'Invalid request!'));
}
?>
