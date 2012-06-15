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
        // update data in mysql database
        $stmt = $db->stmt_init();
        $stmt->prepare('UPDATE `roms` SET `rom` = ?, `version` = ?, `buildfingerprint` = ?, `url` = ?, `md5` = ?, `changelog` = ?, `userid` = ?, `device` = ?, `romversionname` = ? WHERE `id` = ?');
        $stmt->bind_result('', $_POST['rom'], $_POST['version'], $_POST['buildfingerprint'], $_POST['url'], $_POST['md5'], $_POST['changelog'], $_POST['userid'], $_POST['device'], $_POST['romversionname'], $_POST['id']);

        // if successfully updated.
        if ($stmt->execute()){
            echo 'Successful';
            echo '<br />';
            echo '<a href="?page=list-roms">View result</a>';
        } else {
            echo 'ERROR';
        }
    } else {
        header('Location: ?page=list-roms');
    }
} else {
    echo 'You are not logged in';
}
?>
