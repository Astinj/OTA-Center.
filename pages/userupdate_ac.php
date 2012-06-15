<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: update_ac: Updates the rom that is submitted in update
// the adress would be something like this: http://<domain>/<path>/update_ac.php
include('safe_admin.php');
error_reporting(E_ALL);
ini_set('display_errors', true);

// when the form of update.php is submitted with info, continue, if else redirect to list-roms.php page
if (isset($_POST['submit_form'])) {
    // update data in mysql database
    $stmt = $db->stmt_init();
    $stmt->prepare('UPDATE `gebruikers` SET `naam` = ?, `wachtwoord` = ?, `status` = ?, `email` = ?, `actief` = ?, `lastactive` = ?, `actcode` = ? WHERE `id` = ?');
    $stmt->bind_param('ssssssi', $_POST['naam'], $_POST['wachtwoord'], $_POST['status'], $_POST['email'], $_POST['actief'], $_POST['lastactive'], $_POST['actcode'], $_POST['id']);

    // if successfully updated.
    if ($stmt->execute()){
        echo "Successful";
        echo "<BR>";
        echo "<a href='?page=listusers'>View result</a>";
    } else {
        echo "ERROR";
    }
} else {
    header("Location: ?page=listusers");
}
?>
