<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: forgotpass.php: Wachtwoord opvragen via email

if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['forgot_submit'])) {
        // Uitvoeren
        if ($_POST['forgot_user'] != "" && $_POST['forgot_email'] != "") {
            $stmt = $db->stmt_init();
            $stmt->prepare('SELECT `id`, `email` FROM `gebruikers` WHERE `naam` = ?');
            $stmt->bind_param('s', $_POST['forgot_user']);
            $stmt->execute();
            $stmt->bind_result($dbid, $dbemail);

            if ($stmt->fetch()) {
                $stmt->close();
                // Emailcheck
                if ($dbemail == $_POST['forgot_email']) {
                    // Wachtwoord wijzigen, met autogenerated, email verzenden
                    $actcode = mt_srand((double) microtime()*100000);
                    while (strlen($actcode) <= 10) {
                        $i = chr(mt_rand (0,255));
                        if(eregi('^[a-z0-9]$', $i)) {
                            $actcode = $actcode.$i;
                        }
                    }

                    $stmt = $db->stmt_init();
                    $stmt->prepare('UPDATE `gebruikers` SET `actief` = 0, `actcode` = ? WHERE `id` = ?');
                    $stmt->bind_param('si', $actcode, $dbid);

                    if ($stmt->execute()) {
                        $bericht = <<<EOF
Beste {$_POST['forgot_user']},
Op de website $sitenaam heb je aangegeven dat je je wachtwoord bent vergeten.
Om je wachtwoord te wijzigen, druk je op de link onderaan deze mail, en wijzig je je wachtwoord.
Wanneer je niet je wachtwoord wilt wijzigen, klik je op de 2e link, deze zal je account weer activeren, met je huidige wachtwoord.

WACHTWOORD WIJZIGEN: {$sitebaseurl}?page=activeren&id=$dbid&code=$actcode

WACHTWOORD _NIET_ WIJZIGEN: {$sitebaseurl}?page=activeren&id=$dbid&code=$actcode&activeer=true

** Dit is een automatisch verzonden bericht **
EOF;

                        $mail = mail($dbemail, "Wachtwoord wijzigen $sitenaam", $bericht, "From: $sitenaam <$sitemail>");
                        if ($mail == TRUE) {
                            echo 'Je account is succesvol gedeactiveerd, en er is een e-mail gestuurd naar je emailadres. In deze e-mail staat een link, wanneer je hierop klikt kom je op een pagina waar je je wachtwoord kunt wijzigen.<br /><a href="inloggen.php">&laquo; Ga naar de inlogpagina</a>';
                        } else {
                            echo "Er is een fout opgetreden tijdens het verzenden van de mail. Je account blijft gedeactiveerd. Neem contact op met <a href=\"mailto:$sitemail\">$sitemail</a> om je account te activeren.";
                        }
                    } else {
                        echo 'Er is een fout opgetreden tijdens het deactiveren van je account.<br /><a href="javascript:history.back()">&laquo; Ga terug</a>';
                    }
                    $stmt->close();
                } else {
                    echo "Het gegeven e-mailadres komt niet overeen met het e-mailadres voor '{$_POST['forgot_user']}' in de database.<br /><a href=\"javascript:history.back()\">&laquo; Ga terug</a>";
                }
            } else {
                $stmt->close();
                echo 'De gebruikersnaam die jij invoerde bestaat niet.<br /><a href="javascript:history.back()">&laquo; Ga terug</a>';
            }
        } else {
            echo 'Je hebt een veld niet ingevuld. Alle velden zijn verplicht.<br /><a href="javascript:history.back()">&laquo; Ga terug</a>';
        }
    } else {
        // Formulier
        ?>
        <form method="post" action="?page=forgotpass">
            <table>
                <tr>
                    <td>Gebruikersnaam:</td><td><input type="text" name="forgot_user" /></td>
                </tr>
                <tr>
                    <td>E-mailadres:</td><td><input type="text" name="forgot_email" /></td>
                </tr>
                <tr>
                    <td></td><td><input type="submit" name="forgot_submit" value="Wachtwoord opvragen" /></td>
                </tr>
            </table>
        </form>
        <?
    }
} else {
    echo 'Je bent momenteel ingelogd, je kunt nu geen gebruik maken van de \'Wachtwoord vergeten\'-functie.<br /><a href="javascript:history.back();">&laquo; Ga terug</a>';
}

?>
