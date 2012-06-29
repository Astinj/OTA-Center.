<?php
if (isset($_SESSION['user_id'])) {
    // update data in mysql database
    $stmt = $db->stmt_init();
    $stmt->prepare('INSERT INTO `roms` (`rom`, `romid`, `version`, `buildfingerprint`, `url`, `md5`, `changelog`, `userid`, `device`, `romversionname`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('sssssssiss', $_POST['rom'], $_POST['romid'], $_POST['version'], $_POST['buildfingerprint'], $_POST['url'], $_POST['md5'], $_POST['changelog'], $_SESSION['user_id'], $_POST['device'], $_POST['romversionname']);

    // if successfully updated.
    if ($stmt->execute()) {
        echo 'Added Successfully';
        echo '<br />';
        echo '<a href="?page=list-roms">View result</a>';
    } else {
        echo 'ERROR';
    }
    $stmt->close();
} else {
    //echo "You are not logged in.";
    header('Location: ?page=denied');
    exit();
}
?>
