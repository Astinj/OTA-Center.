<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: wachtwoord.php: Pagina om wachtwoord te wijzigen
// Inloggen verplicht; safe.php
include "safe.php";

if (isset($_POST['useropties_submit'])) {
    if (preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$/i", $_POST['useropties_email'])) {
        if ($_POST['useropties_pass1'] != "") {
            // Wachtwoord wijzigen
            $stmt = $db->stmt_init();
            $stmt->prepare('SELECT `wachtwoord` FROM `gebruikers` WHERE `id` = ?');
            $stmt->bind_param('i', $_SESSION['user_id']);
            $stmt->execute();
            $stmt->bind_result($rij_wachtwoord);
            $stmt->fetch();
            $stmt->close();
            $dbpass = htmlspecialchars($rij_wachtwoord);
            if ($dbpass == md5($_POST['useropties_passnow'])) {
                if ($_POST['useropties_pass1'] == $_POST['useropties_pass2']) {
                    $newpass = md5($_POST['useropties_pass1']);
                    $stmt = $db->stmt_init();
                    $stmt->prepare('UPDATE `gebruikers` SET `email` = ?, `wachtwoord` = ? WHERE `id` = ?');
                    $stmt->bind_param('ssi', $_POST['useropties_email'], $newpass, $_SESSION['user_id']);
                    if ($stmt->execute()) {
                        echo "Your mailadress is changed to '{$_POST['email']}', your password has changed too.<br /><a href=\"?page=useropties\">&laquo; Go back</a>";
                        if (isset($_COOKIE['user_password'])) {
                            setcookie("user_password", $newpass, time() + 365 * 86400);
                        }
                    } else {
                        echo 'An error has occured while changing password or mailadress... Please try again later.<br />\n<a href="javascript:history.back()">&laquo; Go Back</a>';
                    }
                } else {
                    echo 'The new passwords do not match. Please try again.<br /><a href="javascript:history.back()">&laquo; Go Back</a>';
                }
            } else {
                echo 'The filled out \'current password\' is not right.<br />\n<a href="javascript:history.back()">&laquo; Go Back</a>';
            }
        } else {
            // Alleen e-mail wijzigen
            $stmt = $db->stmt_init();
            $stmt->prepare('UPDATE `gebruikers` SET `email` = ?, WHERE `id` = ?');
            $stmt->bind_param('si', $_POST['useropties_email'], $_SESSION['user_id']);
            if ($stmt->execute()) {
                echo "Your mailadress has changed to '{$_POST['useropties_email']}'.<br /><a href=\"?page=useropties\">&laquo; Go Back</a>";
            } else {
                echo 'An error occured while changing your mailadress. Please try again later.<br /><a href="javascript:history.back()">&laquo; Go Back</a>';
            }
        }
    } else {
        echo 'You\'d fill out a wrong mailadress (it has to look like name@domain.com).<br /><a href="javascript:history.back()">&laquo; Go Back</a>';
    }
} else {
    // Formulier
    $stmt = $db->stmt_init();
    $stmt->prepare('SELECT `naam`, `email` FROM `gebruikers` WHERE `id` = ?');
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($rij_namm, $rij_email);
    $stmt->fetch();
    $stmt->close();

    $naam = htmlspecialchars($rij_naam);
    $email = htmlspecialchars($rij_email);
    ?>
    <div class="formdiv">
        <h2>Edit your Account</h2>

        <form id="useropties_form" action="?page=useropties" method="post">
            <fieldset>
                <p>
                    Username: <b><?= $naam ?></b>
                </p>
                <p>
                    <label for="useropties_email">Email</label>
                    <input id="useropties_email" name="useropties_email" type="text" class="text" value="" />
                </p>
                <p>
                    <label for="useropties_passnow">Current Password</label>
                    <input id="useropties_passnow" name="useropties_passnow" class="text" type="password" />
                </p>
                <p>
                    <label for="useropties_pass1">New Password</label>
                    <input id="useropties_pass1" name="useropties_pass1" class="text" type="password" />
                </p>
                <p>
                    <label for="useropties_pass2">Verify</label>
                    <input id="useropties_pass2" name="useropties_pass2" class="text" type="password" />
                </p>
                <p>
                    <button id="useropties_submit" name="useropties_submit" type="submit">Save</button>
                </p>
            </fieldset>
        </form>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#useropties_form label").inFieldLabels();
        });
    </script>
    <?
}
?>
