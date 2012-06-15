<?
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: romupdate: Give all roms in database table 'roms' if it matched the adress
// the adress would be something like this: http://<domain>/<path>/romupdate.php?romname=<romname>

header('Content-Type: application/json');

include 'config.php';
$romname = $_GET['romname'];

$json = array();

$sql = "SELECT `rom`, `version`, `buildfingerprint`, `url`, `md5`, `changelog`, `device` FROM `roms` ORDER BY `version` ASC";
$query = $db->query($sql);
while($rij = $query->fetch_object()) {
    if ($rij->rom == $romname) {
        $json[$rij->device] = array(
            'version' => $rij->version,
            'rom' => $rij->rom,
            'build-fingerprint' => $rij->buildfingerprint,
            'url' => $rij->url,
            'md5' => $rij->md5,
            'changelog' => $rij->changelog
        );
    }
}

echo json_encode(array("$romname" => $json));
?>
