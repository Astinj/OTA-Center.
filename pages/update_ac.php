<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: update_ac: Updates the rom that is submitted in update
// the adress would be something like this: http://<domain>/<path>/update_ac.php
include 'safe.php';
error_reporting(E_ALL);
ini_set('display_errors', true);

// when the form of update.php is submitted with info, continue, if else redirect to list-roms.php page
if (isset($_SESSION['user_id'])) {
    if (isset($_POST['submit_form'])) {
        $stmt = $db->stmt_init();
        $stmt->prepare('SELECT `md5`, `version` FROM `roms` WHERE `id` = ?');
        $stmt->bind_param('i', $_POST['id']);
        $stmt->execute();
        $stmt->bind_result($md5, $version);
        $stmt->fetch();
        $stmt->close();

        if ($md5 != $_POST['md5'] && $version != $_POST['version']) {
            $stmt = $db->stmt_init();
            $stmt->prepare('SELECT `reg_id` FROM `ota_devices` WHERE `romid` = ? AND `device` = ?');
            $stmt->bind_param('ss', $_POST['romid'], $_POST['device']);
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
                        'info_rom' => $_POST['rom'],
                        'info_changelog' => $_POST['changelog'],
                        'info_url' => $_POST['url'],
                        'info_build' => $_POST['buildfingerprint']
                    ),
                    'delay_while_idle' => true
                )));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Authorization: key=GCM_API_KEY'
                ));

                $result = curl_exec($ch);

                if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
                    echo 'NOTE: Sending GCM notification(s) unsuccessful.<br /><br />';
                }
            }
        }

        // update data in mysql database
        $stmt = $db->stmt_init();
        $stmt->prepare('UPDATE `roms` SET `rom` = ?, `romid` = ?, `version` = ?, `buildfingerprint` = ?, `url` = ?, `md5` = ?, `changelog` = ?, `userid` = ?, `device` = ?, `romversionname` = ? WHERE `id` = ?');
        $stmt->bind_param('sssssssissi', $_POST['rom'], $_POST['romid'], $_POST['version'], $_POST['buildfingerprint'], $_POST['url'], $_POST['md5'], $_POST['changelog'], $_POST['userid'], $_POST['device'], $_POST['romversionname'], $_POST['id']);

        // if successfully updated.
        if ($stmt->execute()){
            echo 'Successful';
            echo '<br />';
            echo '<a href="?page=list-roms">View result</a>';
        } else {
            echo 'ERROR';
        }

        $stmt->close();
    } else {
        header('Location: ?page=list-roms');
    }
} else {
    echo 'You are not logged in';
}
?>
