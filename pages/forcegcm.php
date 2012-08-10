<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: update_ac: Updates the rom that is submitted in update
// the adress would be something like this: http://<domain>/<path>/update_ac.php
include 'config.php';
include 'safe_admin.php';
error_reporting(E_ALL);
ini_set('display_errors', true);

$stmt = $db->stmt_init();
$stmt->prepare('SELECT `rom`, `changelog`, `url`, `romid`, `device`, `md5`, `version` FROM `roms` WHERE `id` = ?');
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$stmt->bind_result($rom, $changelog, $url, $romid, $device, $md5, $version);
$stmt->fetch();
$stmt->close();

$stmt = $db->stmt_init();
$stmt->prepare('SELECT `reg_id` FROM `ota_devices` WHERE `romid` = ? AND `device` = ? UNION SELECT `reg_id` FROM `ota_devices2` WHERE `romid` = ? AND `device` = ?');
$stmt->bind_param('ss', $romid, $device, $romid, $device);
$stmt->execute();
$stmt->bind_result($regid);

$regids = array();
while ($stmt->fetch()) $regids[] = $regid;
$stmt->close();

if (!empty($regids)) {
    $ch = curl_init('https://android.googleapis.com/gcm/send');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
        'registration_ids' => $regids,
        'collapse_key' => 'ROM Update Available',
        'data' => array(
            'info_rom' => $rom,
            'info_version' => $version,
            'info_changelog' => $changelog,
            'info_url' => $url,
            'info_md5' => $md5
        ),
        'delay_while_idle' => true
    )));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: key='.$gcmapikey
    ));

    $result = curl_exec($ch);

    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
        echo 'NOTE: Sending GCM notification(s) unsuccessful.<br /><br />';
    } else {
        echo 'GCM notifications sent successfully to reg. IDs:<br />';
        print_r($regids);
    }
} else {
    echo 'No devices registered for ROM';
}
?>
