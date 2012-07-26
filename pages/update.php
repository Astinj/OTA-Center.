<?php
// OTA Update file
// Copyright Mark Weulink (W4lth3r on FreeNode)
// Support by info@sensation-devs.org (Email)
// Pagina: update: you can edit the details of given rom(id)
// the adress would be something like this: http://<domain>/<path>/update.php?id=<romid>
include 'safe.php';
error_reporting(E_ALL);
ini_set('display_errors', true);

//Continue when ID is set in the header
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve data from database
    $stmt = $db->stmt_init();
    $stmt->prepare('SELECT `id`, `rom`, `romid`, `version`, `date`, `url`, `md5`, `changelog`, `device`, `userid` FROM `roms` WHERE `id` = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($id, $rom, $romid, $version, $date, $url, $md5, $changelog, $device, $userid);
    $stmt->fetch();
    $stmt->close();

    if (isset($_SESSION['user_id'])) {
        if ($userid == $_SESSION['user_id'] || $_SESSION['user_status'] == 1) {
            ?>
            <div class="formdiv">
                <h2>Update Rom</h2>

                <form id="update_rom_form" action="?page=update_ac" method="post">
                    <fieldset>
                        <p>
                            <label for="rom"><? echo $rom; ?></label>
                            <input id="rom" name="rom" type="text" class="rom" value="<? echo $rom; ?>" />
                        </p>
                        <p>
                            <label for="romid"><? echo $romid; ?></label>
                            <input id="romid" name="romid" type="text" class="rom" value="<? echo $romid; ?>" />
                        </p>
                        <p>
                            <label for="version"><? echo $version; ?></label>
                            <input id="version" name="version" type="text" class="rom" value="<? echo $version; ?>" />
                        </p>
                        <p>
                            <label for="date"><? echo $date; ?></label>
                            <input id="date" name="date" type="text" class="rom" value="<? echo $date; ?>" />
                        </p>
                        <p>
                            <label for="url"><? echo $url; ?></label>
                            <input id="url" name="url" type="text" class="rom" value="<? echo $url; ?>" />
                        </p>
                        <p>
                            <label for="md5"><? echo $md5; ?></label>
                            <input id="md5" name="md5" type="text" class="rom" value="<? echo $md5; ?>" />
                        </p>
                        <p>
                            <label for="changelog"><? echo $changelog; ?></label>
                            <textarea id="changelog" name="changelog" class="rom"><? echo $changelog; ?></textarea>
                        </p>
                        <p>
                            <label for="device"><? echo $device; ?></label>
                            <input id="device" name="device" type="text" class="rom" value="<? echo $device; ?>" />
                        </p>
                        <p>
                            <label for="userid"><? echo $userid; ?></label>
                            <input id="userid" name="userid" type="<? echo $_SESSION['user_status'] == 1 ? 'text' : 'hidden'; ?>" class="rom" value="<? echo $userid; ?>" />
                        </p>
                            <input name="id" type="hidden" id="id" value="<? echo $id; ?>">
                        <p>
                            <button id="update_rom_submit" name="submit_form" type="submit">Update Rom</button>
                        </p>
                    </fieldset>
                </form>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {
                    $("#update_rom_form label").inFieldLabels();
                });
            </script>
            <?
        } else {
            echo 'This rom has not been added by you.<br />If you are sure its your rom, please contact an admin to change it the userid of the rom...';
        }
    } else {
        echo 'You are not logged in...';
    }
} else {
    echo 'ID not set<br /><br /><a href="?page=list-roms">Go to list of ROMs &raquo;</a>';
} ?>
