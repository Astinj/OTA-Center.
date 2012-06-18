<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: ledenlijst.php: Alle geregistreerde accounts weergeven
// Pagina alleen voor admins; safe_admin.php
include 'safe_admin.php';

if (isset($_GET['edit'])) {
    // Bewerken
    if (is_numeric($_GET['edit'])) {
        if (isset($_POST['admin_submit'])) {
            // Bewerkenuitvoeren
            if ($_POST['admin_pass1'] != "") {
                if ($_POST['admin_pass1'] == $_POST['admin_pass2']) {
                    $usersalt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                    $newpass = $usersalt.hash('sha256', $sitesalt.$_POST['admin_pass1'].$_POST['admin_naam'].$usersalt);
                    $stmt = $db->stmt_init();
                    $stmt->prepare('UPDATE `gebruikers` SET `naam` = ?, `wachtwoord` = ?, `email` = ?, `actief` = ?, `status` = ? WHERE `id` = ?');
                    $stmt->bind_param('sssisi', $_POST['admin_naam'], $newpass, $_POST['admin_email'], $_POST['admin_actief'], $_POST['admin_status'], $_GET['edit']);

                    if ($stmt->execute()) {
                        echo 'De gebruiker is succesvol gewijzigd, wachtwoord is veranderd.<br /><a href="?page=admin">&laquo; Terug naar het beheer</a>';
                    } else {
                        echo 'Fout opgetreden tijdens bewerken.<br /><a href="javascript:history.back()">&laquo; Ga terug</a>';
                    }

                    $stmt->close();
                } else {
                    echo 'De nieuwe wachtwoorden zijn niet hetzelfde.<br /><a href="javascript:history.back()">&laquo; Ga terug</a>';
                }
            } else {
                // Zonder wachtwoord wijzigen
                $stmt = $db->stmt_init();
                $stmt->prepare('UPDATE `gebruikers` SET `naam` = ?, `email` = ?, `actief` = ?, `status` = ? WHERE `id` = ?');
                $stmt->bind_param('ssisi', $_POST['admin_naam'], $_POST['admin_email'], $_POST['admin_actief'], $_POST['admin_status'], $_GET['edit']);

                if ($stmt->execute()) {
                    echo 'De gebruiker is succesvol gewijzigd.<br /><a href="?page=admin">&laquo; Terug naar het beheer</a>';
                } else {
                    echo 'Fout opgetreden tijdens bewerken.<br /><a href="javascript:history.back()">&laquo; Ga terug</a>';
                }

                $stmt->close();
            }
        } else {
            // Bewerkform
            $stmt = $db->stmt_init();
            $stmt->prepare('SELECT `naam`, `status`, `email`, `actief` FROM `gebruikers` WHERE `id` = ?');
            $stmt->bind_param('i', $_GET['edit']);
            $stmt->execute();
            $stmt->bind_result($rij_naam, $status, $rij_email, $actief);
            $stmt->fetch();
            $stmt->close();

            $naam = htmlspecialchars($rij_naam);
            $email = htmlspecialchars($rij_email);
            ?>
            <form method="post" action="?page=admin&edit=<?= $_GET['edit'] ?>">
                <table>
                    <tr>
                        <td>Naam:</td><td><input type="text" name="admin_naam" value="<?= $naam ?>" maxlength="50" /></td>
                    </tr>
                    <tr>
                        <td>Nieuw wachtwoord:</td><td><input type="password" name="admin_pass1" /> <small>(leeglaten voor huidige)</small></td>
                    </tr>
                    <tr>
                        <td>Herhaal:</td><td><input type="password" name="admin_pass2" /></td>
                    </tr>
                    <tr>
                        <td>E-mailadres:</td><td><input type="text" name="admin_email" value="<?= $email ?>" maxlength="100" /></td>
                    </tr>
                    <tr>
                        <td>Actief:</td><td><input type="text" name="admin_actief" value="<?= $actief ?>" maxlength="1" size="1" /> <small>(1 = actief, 0 = niet actief)</small></td>
                    </tr>
                    <tr>
                        <td>Status:</td><td><input type="text" name="admin_status" value="<?= $status ?>" maxlength="1" size="1" /> <small>(1 = admin, 0 = gebruiker)</small></td>
                    </tr>
                    <tr>
                        <td></td><td><input type="submit" name="admin_submit" value="Opslaan" /></td>
                    </tr>
                </table>
            </form>
            <?
        }
    } else {
        // Lijst
        ?>
        Welke gebruiker wil je bewerken?<br />
        <form method="get" action="?page=admin">
            <table>
                <tr>
                    <td><select name="edit" size="1">
                        <option value="do">&nbsp;</option>
                        <?
                        $query = $db->query('SELECT `naam`, `id` FROM `gebruikers` ORDER BY `naam` ASC');
                        while($rij = $query->fetch_object()) {
                            $naam = htmlspecialchars($rij->naam);
                            echo '<option value="'.$rij->id.'">'.$naam.'</option>';
                        }
                        ?>
                    </select></td>
                    <td><input type="submit" value="Bewerken" /></td>
                </tr>
            </table>
        </form>
        <?
    }
} else if (isset($_GET['del'])) {
    // Verwijderen
    if (is_numeric($_GET['del'])) {
        // Verwijderenuitvoeren
        $stmt = $db->stmt_init();
        $stmt->prepare('DELETE FROM `gebruikers` WHERE `id` = ?');
        $stmt->bind_param('i', $_GET['del']);
        if ($stmt->execute()) {
            echo 'De gebruiker met het ID '.$_GET['del'].' is succesvol verwijderd.<br /><a href="?page=admin">&laquo; Terug naar het beheer</a>';
        } else {
            echo 'Er is iets fout gegaan bij het verwijderen van userID '.$_GET['del'].'. Bestaat het gebruikersID wel?<br /><a href="?page=admin">&laquo; Terug naar het beheer</a>';
        }
    } else {
        // Lijst
        ?>
        Welke gebruiker wil je verwijderen?<br />
        <form method="get" action="?page=admin">
            <table>
                <tr>
                    <td><select name="del" size="1">
                        <option value="">&nbsp;</option>
                        <?
                        $query = $db->query('SELECT `naam`, `id` FROM `gebruikers` ORDER BY `naam` ASC');
                        while($rij = $query->fetch_object()) {
                            $naam = htmlspecialchars($rij->naam);
                            echo '<option value="'.$rij->id.'">'.$naam.'</option>';
                        }
                        ?>
                    </select></td>
                    <td><input type="submit" value="Verwijderen" /></td>
                </tr>
            </table>
        </form>
    <?
    }
} else {
    // Keuzelijst
    ?>
    Wat wil je doen?<br />
    <ul>
        <li><a href="?page=admin&edit=do">Gebruiker bewerken</a></li>
        <li><a href="?page=admin&del=do">Gebruiker verwijderen</a></li>
    </ul>
<? } ?>
