<?php
include 'safe_admin.php';

// update data in mysql database
$usersalt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
$hashpass = $usersalt.hash('sha256', $sitesalt.$_POST['wachtwoord'].$_POST['naam'].$usersalt);
$stmt = $db->stmt_init();
$stmt->prepare('INSERT INTO `gebruikers` (`naam`, `wachtwoord`, `status`, `email`, `actief`, `actcode`) VALUES(?, ?, ?, ?, ?, ?)');
$stmt->bind_param('ssssss', $_POST['naam'], $hashpass, $_POST['status'], $_POST['email'], $_POST['actief'], $_POST['actcode']);

// if successfully updated.
if ($stmt->execute()){
    echo 'Added Successfully';
    echo '<br />';
    echo '<a href="?page=listusers">View result</a>';
} else {
    echo 'ERROR';
}
?>
