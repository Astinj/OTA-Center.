<?php
include 'safe_admin.php';

// update data in mysql database
$md5pass = md5($_POST['wachtwoord']);
$stmt = $db->stmt_init();
$stmt->prepare('INSERT INTO `gebruikers` (`naam`, `wachtwoord`, `status`, `email`, `actief`, `actcode`) VALUES(?, ?, ?, ?, ?, ?)');
$stmt->bind_param('ssssss', $_POST['naam'], $md5pass, $_POST['status'], $_POST['email'], $_POST['actief'], $_POST['actcode']);

// if successfully updated.
if ($stmt->execute()){
    echo 'Added Successfully';
    echo '<br />';
    echo '<a href="?page=listusers">View result</a>';
} else {
    echo 'ERROR';
}
?>
