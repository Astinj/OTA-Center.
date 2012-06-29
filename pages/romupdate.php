<?
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: romupdate: Give all roms in database table 'roms' if it matched the adress
// the adress would be something like this: http://<domain>/<path>/romupdate.php?romname=<romname>

header('Content-Type: application/json');

include 'config.php';
$romid = $_GET['rom'];
$device = $_GET['device'];

$stmt = $db->stmt_init();
$stmt->prepare('SELECT `rom`, `version`, `buildfingerprint`, `url`, `md5`, `changelog`, `device` FROM `roms` WHERE `romid` = ? AND `device` = ? ORDER BY `version` ASC LIMIT 1');
$stmt->bind_param('ss', $romid, $device);
$stmt->execute();
$stmt->bind_result($version, $rom, $buildfingerprint, $url, $md5, $changelog);

if ($stmt->fetch()) {
    $json = array(
        'version' => $version,
        'rom' => $rom,
        'build-fingerprint' => $buildfingerprint,
        'url' => $url,
        'md5' => $md5,
        'changelog' => $changelog
    );
} else {
    $json = array(
        'error' => 'Invalid ROM/device combo!'
    );
}

$stmt->close();

echo json_encode($json);
?>
