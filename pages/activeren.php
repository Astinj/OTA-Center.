<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: activeren.php: Account activeren naar wachtwoord vergeten/registratie

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_GET['code'])) {
        $stmt = $db->stmt_init();
        $stmt->prepare('SELECT `id`, `naam`, `actcode`, `actief` FROM `gebruikers` WHERE `id` = ?');
        $stmt->bind_param('i', $id);

        $stmt->execute();
        $stmt->bind_result($id, $naam, $actcode, $actief);
        $stmt->fetch();
        $stmt->close();

        if ($actief == 0) {
            if ($actcode == $_GET['code']) {
                if (isset($_GET['activeer'])) {

                    $stmt = $db->stmt_init();
                    $stmt->prepare('UPDATE `gebruikers` SET `actief` = 1, `actcode` = \'\' WHERE `id` = ?');
                    $stmt->bind_param('i', $id);

                    if ($stmt->execute()) {
                        // Activeren naar registratie
                        echo 'Your account has been activated, you can now login.<br /><a href="?page=inloggen">&laquo; Go to login.</a>';
                    } else {
                        echo 'An error occured while activating.';
                    }

                    $stmt->close();
                } else if (isset($_POST['activeer_submit'])) {
                    // Uitvoeren
                    if($_POST['activeer_pass1'] == $_POST['activeer_pass2']) {
                        $usersalt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                        $hashpass = $usersalt.hash('sha256', $sitesalt.$_POST['activeer_pass1'].$naam.$usersalt);

                        $stmt = $db->stmt_init();
                        $stmt->prepare('UPDATE `gebruikers` SET `wachtwoord` = ?, `actief` = 1, `actcode` = \'\' WHERE `id` = ?');
                        $stmt->bind_param('si', $hashpass, $id);

                        if ($stmt->execute()) {
                            echo 'Your account has been activated and your password is changed.<br /><a href="?page=inloggen">&laquo; Go to login</a>';
                        } else {
                            echo 'An error occured while changing password.';
                        }

                        $stmt->close();
                    } else {
                        echo 'The filled out passwords do not match.<br /><a href="javascript:history.back()">&laquo; Go Back</a>';
                    }
                } else {
                    // Formulier wachtwoord wijzigen
                    ?>
                    <form method="post" action="?page=activeren&id=<?= $id ?>&code=<?= $_GET['code'] ?>">
                        <table>
                            <tr>
                                <td>New password:</td><td><input type="password" name="activeer_pass1" /></td>
                            </tr>
                            <tr>
                                <td>Verify:</td><td><input type="password" name="activeer_pass2" /></td>
                            </tr>
                            <tr>
                                <td></td><td><input type="submit" name="activeer_submit" value="Change Pass" /></td>
                            </tr>
                        </table>
                    </form>
                    <?
                }
            } else {
                echo 'The activation code is not correct. In case you lost it, go to \'forgot password\' again.<br /><a href="?page=forgotpass">&laquo; Go to forgot password.</a>';
            }
        } else {
            echo 'Your account was not deactivated. You can login again. In case you lost your password, please click on \'forgot password\' on the login page.<br /><a href="?page=inloggen">&laquo; Go to login</a>';
        }
    } else {
        header("Location: ?page=activeren&uid=$id");
    }
} else {
    // Formulier
    ?>
    <form method="get" action="index.php">
        <input type="hidden" name="page" value="activeren" />
        <table>
            <tr>
                <td>UserID:</td><td><input type="text" name="id" maxlength="5" <? if (isset($_GET['uid'])) { echo 'value="'.$_GET['uid'].'"'; } ?> /></td>
            </tr>
            <tr>
                <td>Activationcode:</td><td><input type="text" name="code" maxlength="15" /></td>
            </tr>
            <tr>
                <td align="right"><input type="checkbox" name="activeer" value="yes" style="border: 0px" /></td><td>Dont change password <small>(only activates account)</small></td>
            </tr>
            <tr>
                <td></td><td><input type="submit" value="Activate" /></td>
            </tr>
        </table>
    </form>
    <?
}
// id = userid
// code = actcode
// activeer = huidige wachtwoord houden
// controleren of code bij id hoort!
?>
