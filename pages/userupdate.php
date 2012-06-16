<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: update: you can edit the details of given rom(id)
// the adress would be something like this: http://<domain>/<path>/update.php?id=<romid>
include 'safe_admin.php';
error_reporting(E_ALL);
ini_set('display_errors', true);

//Continue when ID is set in the header
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve data from database
    $stmt = $db->stmt_init();
    $stmt->prepare('SELECT `naam`, `wachtwoord`, `status`, `email`, `actief`, `lastactive`, `actcode` FROM `gebruikers` WHERE `id` = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($rij_naam, $wachtwoord, $status, $rij_email, $actief, $lastactive, $actcode);
    $stmt->fetch();
    $stmt->close();

    $naam = htmlspecialchars($rij_naam);
    $email = htmlspecialchars($rij_email);
    ?>
        <div id="registration">
            <h2>Update User</h2>
            <form id="UpdateUserForm" action="?page=userupdate_ac" method="post">
                <fieldset>
                    <p>
                        <label for="naam">Username:</label>
                        <input id="rom" name="naam" type="text" class="rom" value="<? echo $naam; ?>" />
                    </p>
                    <p>
                        <label for="wachtwoord">Password in md5:</label>
                        <input id="rom" name="wachtwoord" type="text" class="rom" value="<? echo $wachtwoord; ?>" />
                    </p>
                    <p>
                        <label for="status">Status: <small>(Admin = 1 / User = 0)</small></label>
                        <input id="rom" name="status" type="text" class="rom" value="<? echo $status; ?>" />
                    </p>
                    <p>
                        <label for="email">Email:</label>
                        <input id="rom" name="email" type="text" class="rom" value="<? echo $email; ?>" />
                    </p>
                    <p>
                        <label for="actief">Active: <small>(Active = 1 / Inactive = 0)</small></label>
                        <input id="rom" name="actief" type="text" class="rom" value="<? echo $actief; ?>" />
                    </p>
                    <p>
                        <label for="lastactive">Last active on:</label>
                        <input id="rom" name="lastactive" disable="disable" type="text" class="rom" value="<? echo $lastactive; ?>" />
                    </p>
                    <input name="id" type="hidden" id="id" value="<? echo $id; ?>">
                    <input name="actcode" type="hidden" id="actcode" value="<? echo $actcode; ?>">

                    <p>
                        <button id="updateRomNew" name="submit_form" type="submit">Update User</button>
                    </p>
                </fieldset>
            </form>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#UpdateUserForm label").inFieldLabels();
            });
        </script>
        <?
} else {
    echo 'fuck you, add an id at the end of the url ass!';
}
?>
