<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: inloggen.php: Inloggen

if (isset($_SESSION['user_id'])) {
    ?>
    <h2>Welcome <a href="./?page=useropties"><? echo $_SESSION['user_name']; ?></a></h2>
    <ul>
        <li><a href="./?page=home">Home</a></li>
        <li><a href="./?page=list-roms">List Roms</a></li>
        <li><a href="./?page=add">Add Rom</a></li>
        <li><a href="./?page=uitloggen">Logout</a></li>
    </ul>
    <? if ($_SESSION['user_status'] == 1) { ?>
        <div class="sidebar">
            <h2>Admin Menu</h2>
            <ul>
                <li><a href="./?page=listusers">User list</a></li>
                <li><a href="./?page=useradd">Add User</a></li>
            </ul>
        </div>
    <? } ?>
    <!-- <script language="Javascript" type="text/javascript">
        location.href='<?= $loginpage ?>';
    </script> -->
    <?
} else {
    if (isset($_COOKIE['user_id'])) {
        // Cookie uitlezen, sessie aanmaken
        $stmt = $db->stmt_init();
        $stmt->prepare('SELECT `id`, `status`, `wachtwoord`, `actief` FROM `gebruikers` WHERE `id` = ?');
        $stmt->bind_param('i', $_COOKIE['user_id']);
        $stmt->execute();
        $stmt->bind_result($id, $status, $wachtwoord, $actief);
        $stmt->fetch();
        $stmt->close();

        if ($dbpass == $_COOKIE['user_password'] AND $actief == 1) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_status'] = $status;
            ?>
            <!--- A Session has been created, you will be send to the begin page.
            <script language="Javascript" type="text/javascript">
                location.href='<?= $loginpage ?>';
            </script> --->
            <?
        } else {
            echo "The cookies found on your pc do not match our database, it can be that your password has changed or that your account has been deactivated. <br />\nYour old cookies have been deleted.";
            setcookie("user_id", "", time() - 3600);
            setcookie("user_password", "", time() - 3600);
        }
    } else {
        if (isset($_POST['submit'])) {
            // Inloggen
            $stmt = $db->stmt_init();
            $stmt->prepare('SELECT `id`, `naam`, `wachtwoord`, `status`, `actief`, `lastactive` FROM `gebruikers` WHERE `naam` = ?');
            $stmt->bind_param('s', $_POST['user']);
            $stmt->execute();
            $stmt->bind_result($id, $rij_naam, $wachtwoord, $status, $actief, $lastactive);
            $stmt->fetch();
            $stmt->close();

            $userpass = md5($_POST['pass']);
            $username = htmlspecialchars($rij_naam);
            if ($dbpass == $userpass) {
                if ($useractief == 1) {
                    $_SESSION['user_id'] = $userid;
                    $_SESSION['user_name'] = $username;
                    $_SESSION['user_lastactive'] = $lastactive;
                    $_SESSION['user_status'] = $userstatus;
                    if ($_POST['cookie'] == "do") {
                        setcookie("user_id", $userid, time() + 365 * 86400);
                        setcookie("user_password", $dbpass, time() + 365 * 86400);
                    }
                    ?>
                    You are logged in correctly.<br />
                    You will be automatticly send to the next page, if nothing happens <a href="./?page=home">Click here.</a>.

                    <?
                    //no point in sending header after contents sent...
                    //header("Location: ?page=home");
                } else {
                    echo 'Your account has not been activated. Activate your account by clicking the link in the mail that we send at registration.<br /><a href="javascript:history.back()">&laquo; Go Back.</a>';
                }
            } else {
                echo "Your password does not match with the account '{$_POST['user']}'.<br /><a href=\"javascript:history.back()\">&laquo; Go Back.</a>";
            }
        } else {
            // Inlogform
            ?>
            <div id="registration">
                <h2>Login to your Account</h2>

                <form id="RegisterUserForm" action="" method="post">
                    <fieldset>
                        <p>
                            <label for="user">Username</label>
                            <input id="user" name="user" type="text" class="login" value="" />
                        </p>

                        <p>
                            <label for="pass">Password</label>
                            <input id="pass" name="pass" class="login" type="password" />
                        </p>

                        <p>
                            <label for="cookie">Stay logged in.</label>
                            <input id="cookie" name="cookie" type="checkbox" />
                        </p>

                        <p>
                            <button id="loginNew" name="submit" type="submit">Login</button>
                        </p>
                    </fieldset>

                </form>
            </div>
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
            <script type="text/javascript" src="js/infieldlabels.js"></script>
            <?
        }
    }
}
?>
