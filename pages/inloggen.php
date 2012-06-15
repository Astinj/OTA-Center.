<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: inloggen.php: Inloggen
//include("config.php");

if (isset($_SESSION['user_id'])) {
    ?>
    <h2>Welcome <a href="./?page=useropties"><? echo $_SESSION['user_name']; ?></a></h2>
    <ul>
        <li><a href="./?page=home">Home</a></li>
        <li><a href="./?page=list-roms">List Roms</a></li>
        <li><a href="./?page=add">Add Rom</a></li>
        <li><a href="./?page=uitloggen">Logout</a></li>
    </ul>
    <? if($_SESSION['user_status'] == 1) { ?>
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
        $stmt->bind_result($rij_id, $rij_status, $rij_wachtwoord, $rij_actief);
        $stmt->fetch();
        $stmt->close();

        //$sql = "SELECT id,status,wachtwoord,actief FROM gebruikers WHERE id='".$_COOKIE['user_id']."'";
        //$query = mysql_query($sql);
        //$rij = mysql_fetch_object($query);
        $id = htmlspecialchars($rij_id);
        $status = htmlspecialchars($rij_status);
        $dbpass = htmlspecialchars($rij_wachtwoord);
        $actief = htmlspecialchars($rij_actief);
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
            $stmt->bind_result($rij_id, $rij_naam, $rij_wachtwoord, $rij_status, $rij_actief, $rij_lastactive);
            $stmt->fetch();
            $stmt->close();

            //$sql = "SELECT id,naam,wachtwoord,status,actief,lastactive FROM gebruikers WHERE naam='".$_POST['user']."'";
            //$query = mysql_query($sql);
            //$rij = mysql_fetch_object($query);
            $userpass = md5($_POST['pass']);
            $dbpass = htmlspecialchars($rij_wachtwoord);
            $userid = htmlspecialchars($rij_id);
            $userstatus = htmlspecialchars($rij_status);
            $username = htmlspecialchars($rij_naam);
            $useractief = htmlspecialchars($rij_actief);
            $lastactive = htmlspecialchars($rij_lastactive);
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
                    header("Location: ?page=home");
                } else {
                    echo "Your account has not been activated. Activate your account by clicking the link in the mail that we send at registration.<br />\n<a href=\"javascript:history.back()\">&laquo; Go Back.</a>";
                }
            } else {
                echo "Your password does not match with the account '".$_POST['user']."'.<br />\n<a href=\"javascript:history.back()\">&laquo; Go Back.</a>";
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

            <script type="text/javascript">
                $(document).ready(function() {
                    /*
                     * In-Field Label jQuery Plugin
                     * http://fuelyourcoding.com/scripts/infield.html
                     *
                     * Copyright (c) 2009 Doug Neiner
                     * Dual licensed under the MIT and GPL licenses.
                     * Uses the same license as jQuery, see:
                     * http://docs.jquery.com/License
                     *
                     * @version 0.1
                     */
                    (function($) {
                        $.InFieldLabels = function(label, field, options) {
                            var base = this;
                            base.$label = $(label);
                            base.$field = $(field);
                            base.$label.data("InFieldLabels", base);
                            base.showing = true;
                            base.init = function() {
                                base.options = $.extend({}, $.InFieldLabels.defaultOptions, options);
                                base.$label.css('position', 'absolute');
                                var fieldPosition = base.$field.position();
                                base.$label.css({ 'left': fieldPosition.left, 'top': fieldPosition.top }).addClass(base.options.labelClass);
                                if (base.$field.val() != "") {
                                    base.$label.hide();
                                    base.showing = false;
                                };
                                base.$field.focus(function() {
                                    base.fadeOnFocus();
                                }).blur(function() {
                                    base.checkForEmpty(true);
                                }).bind('keydown.infieldlabel', function(e) {
                                    base.hideOnChange(e);
                                }).change(function(e) {
                                    base.checkForEmpty();
                                }).bind('onPropertyChange', function() {
                                    base.checkForEmpty();
                                });
                            };
                            base.fadeOnFocus = function() {
                                if (base.showing) {
                                    base.setOpacity(base.options.fadeOpacity);
                                };
                            };
                            base.setOpacity = function(opacity) {
                                base.$label.stop().animate({ opacity: opacity }, base.options.fadeDuration);
                                base.showing = (opacity > 0.0); };
                                base.checkForEmpty = function(blur) {
                                    if (base.$field.val() == "") {
                                        base.prepForShow();
                                        base.setOpacity(blur ? 1.0 : base.options.fadeOpacity);
                                    } else {
                                        base.setOpacity(0.0);
                                    };
                                };
                                base.prepForShow = function(e) {
                                    if (!base.showing) {
                                        base.$label.css({ opacity: 0.0 }).show();
                                        base.$field.bind('keydown.infieldlabel', function(e) {
                                            base.hideOnChange(e);
                                        });
                                    };
                                };
                                base.hideOnChange = function(e) {
                                    if ((e.keyCode == 16) || (e.keyCode == 9)) return;
                                    if (base.showing) {
                                        base.$label.hide();
                                        base.showing = false;
                                    };
                                    base.$field.unbind('keydown.infieldlabel');
                                };
                                base.init();
                        };
                        $.InFieldLabels.defaultOptions = { fadeOpacity: 0.5, fadeDuration: 300, labelClass: 'infield' };
                        $.fn.inFieldLabels = function(options) {
                            return this.each(function() {
                                var for_attr = $(this).attr('for');
                                if (!for_attr) return;
                                var $field = $("input#" + for_attr + "[type='text']," +
                                        "input#" + for_attr + "[type='password']," +
                                        "input#" + for_attr + "[type='tel']," +
                                        "input#" + for_attr + "[type='email']," +
                                        "textarea#" + for_attr);
                                if ($field.length == 0) return;
                                (new $.InFieldLabels(this, $field[0], options));
                            });
                        };
                    })(jQuery);

                    $("#RegisterUserForm label").inFieldLabels();
                });
            </script>
            <?
        }
    }
}
?>
