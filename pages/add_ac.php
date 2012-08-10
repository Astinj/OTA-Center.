<?php
if (isset($_SESSION['user_id'])) {
    // update data in mysql db
    $stmt = $db->stmt_init();
    $stmt->prepare('INSERT INTO `roms` (`rom`, `romid`, `version`, `date`, `url`, `md5`, `changelog`, `userid`, `device`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('sssssssis', $_POST['rom'], $_POST['romid'], $_POST['version'], $_POST['date'], $_POST['url'], $_POST['md5'], $_POST['changelog'], $_SESSION['user_id'], $_POST['device']);

    // if successfully updated.
    if ($stmt->execute()) {
        echo 'Added Successfully';
        echo '<br />';
        echo '<a href="?page=list-roms">View result</a>';

        $stmt = $db->stmt_init();
        $stmt->prepare('SELECT `reg_id` FROM `ota_devices` WHERE `romid` = ? AND `device` = ? UNION SELECT `reg_id` FROM `ota_devices2` WHERE `romid` = ? AND `device` = ?');
        $stmt->bind_param('ssss', $_POST['romid'], $_POST['device'], $_POST['romid'], $_POST['device']);
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
                            'info_version' => $_POST['version'],
                            'info_changelog' => $_POST['changelog'],
                            'info_url' => $_POST['url'],
                            'info_md5' => $_POST['md5']
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
            }
        }
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
