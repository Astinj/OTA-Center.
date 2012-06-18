<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: registreer.php: Registreren voor nieuw account

if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['registreer_submit'])) {
        // Uitvoeren
        // Velden controleren
        if (!empty($_POST['registreer_user']) && !empty($_POST['registreer_pass1']) && !empty($_POST['registreer_pass2']) && !empty($_POST['registreer_email'])) {
            // Gebuikersnaamcheck
            $stmt = $db->stmt_init();
            $stmt->prepare('SELECT `id` FROM `gebruikers` WHERE `naam` = ?');
            $stmt->bind_param('s', $_POST['registreer_user']);
            $stmt->execute();
            $stmt->store_result();
            $tellen = $stmt->num_rows;
            $stmt->free_result();
            $stmt->close();

            if ($tellen == 0) {
                // E-mailcheck
                if (preg_match('/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$/i', $_POST['email'])) {
                    // Email correct
                    if ($_POST['registreer_pass1'] == $_POST['registreer_pass2']) {
                        $actcode = mt_srand((double) microtime()*100000);
                        while (strlen($actcode) <= 10) {
                            $i = chr(mt_rand (0,255));
                            if (eregi('^[a-z0-9]$', $i)) {
                                $actcode = $actcode.$i;
                            }
                        }
                        $usersalt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                        $hashpass = $usersalt.hash('sha256', $sitesalt.$_POST['registreer_pass1'].$_POST['registreer_user'].$usersalt);
                        $stmt = $db->stmt_init();
                        $stmt->prepare('INSERT INTO `gebruikers` (`naam`, `wachtwoord`, `status`, `email`, `actief`, `actcode`) VALUES (?, ?, 0, ?, 0, ?)');
                        $stmt->bind_param('ssss', $_POST['registreer_user'], $hashpass, $_POST['registreer_email'], $actcode);

                        if ($stmt->execute()) {
                            $dbid = $db->insert_id;
                            $bericht = <<<EOF
Hello {$_POST['user']},
You have registered on this site: $sitenaam, this is the activation mail.
To activate your account click on the link below.

Confirm registration: {$sitebaseurl}?page=activeren&id=$dbid&code=$actcode&registratie=true

As soon as you clicked on the link you will be able to login with:
Username: {$_POST['registreer_user']}
Password: {$_POST['registreer_pass1']}
This message has been send automatically **
EOF;
                            $mail = mail($_POST['registreer_email'], "Registration $sitenaam", $bericht, "From: $sitenaam <$sitemail>");
                            if ($mail == TRUE) {
                                echo 'You are registered successfully! As soon as you clicked the link in the mail, you will be able to login.<br /><a href="?page=inloggen">&laquo; Goto loginpage.</a>';
                            } else {
                                echo "An error has occured whole sending the mail, please send a mail to: <a href=\"mailto:$sitemail\">$sitemail</a>.";
                            }
                        } else {
                            echo 'An error has occured while registering your account. Please try again later.<br /><a href="javascript:history.back()">&laquo; Go Back</a>';
                        }
                        $stmt->close();
                    } else {
                        echo 'The passwords you typed did not match, please try again.<br /><a href="javascript:history.back()">&laquo; Go Back</a>';
                    }
                } else {
                    echo 'The mailadress you typed didn\'t look like a mailadress like (user@domain.ext).<br /><a href="javascript:history.back()">&laquo; Go Back</a>';
                }
            } else {
                echo "The username '{$_POST['registreer_user']}' is not available anymore. Try another username.<br /><a href=\"javascript:history.back()\">&laquo; Go Back.</a>";
            }
        } else {
            echo 'You forgot to fill out one or more fields.<br /><a href="javascript:history.back()">&laquo; Go Back</a>';
        }
    } else {
        // Formulier

        # Email
        # User
        # Pass + check
        # emailcheck (uitvoeren)
        ?>
        <div class="formdiv">
            <h2>Create an Account</h2>

            <form id="register_form" action="?page=registreer" method="post">
                <fieldset>
                    <p>
                        <label for="registreer_user">Username</label>
                        <input id="registreer_user" name="registreer_user" type="text" class="text" value="" />
                    </p>
                    <p>
                        <label for="registreer_pass1">Password</label>
                        <input id="registreer_pass1" name="registreer_pass1" class="text" type="password" />
                    </p>
                    <p>
                        <label for="registreer_pass2">Verify</label>
                        <input id="registreer_pass2" name="registreer_pass2" class="text" type="password" />
                    </p>
                    <p>
                        <label for="registreer_email">E-Mail</label>
                        <input id="registreer_email" name="registreer_email" type="text" class="text" value="" />
                    </p>
                    <p>
                        <button id="registreer_submit" name="registreer_submit" type="submit">Register</button>
                    </p>
                    <small>After registration you will get a mail from us with an activation link. Until you clicked the link, you won't be able to log in.</small>
                </fieldset>
            </form>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#register_form label").inFieldLabels();
            });
        </script>
        <?
    }
} else {
    echo 'You are logged in already, registration is not available when you are logged in!';
}
?>
