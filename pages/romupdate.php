<?
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: romupdate: Give all roms in database table 'roms' if it matched the adress
// the adress would be something like this: http://<domain>/<path>/romupdate.php?romname=<romname>
include("config.php");
$romname = $_GET['romname'];
?>
{
    <? echo "\"".$romname."\": {"; ?>
    "device": {
        <?
        $sql = "SELECT `rom`, `version`, `buildfingerprint`, `url`, `md5`, `changelog`, `device` FROM `roms` ORDER BY `version` ASC";
        $query = $db->query($sql);
        while($rij = $query->fetch_object()) {
            $rom = htmlspecialchars($rij->rom);
            $romversionname = htmlspecialchars($rij->romversionname);
            $version = htmlspecialchars($rij->version);
            $buildfingerprint = htmlspecialchars($rij->buildfingerprint);
            $url = htmlspecialchars($rij->url);
            $md5 = htmlspecialchars($rij->md5);
            $device = htmlspecialchars($rij->device);
            $changelog = htmlspecialchars($rij->changelog);
            if ($rom == $romname) {
                echo "\"".$device."\": [";
                echo "{";
                echo "\"version\": \"".$version."\",";
                echo "\"rom\": \"".$rom."\",";
                echo "\"build-fingerprint\": \"".$buildfingerprint."\",";
                echo "\"url\": \"".$url."\",";
                echo "\"md5\": \"".$md5."\",";
                echo "\"changelog\": \"".$changelog."\",";
                echo "}";
                echo "],";
            }
        }
        ?>
    }
}
