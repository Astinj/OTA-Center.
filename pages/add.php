<?php
if (!isset($_SESSION['user_id'])) {
    //echo 'You are not logged in...';
    header('Location: ?page=denied');
    exit();
}
?>

<div class="formdiv">
    <h2>Add Rom</h2>

    <form id="add_rom_form" action="?page=add_ac" method="post">
        <fieldset>
            <p>
                <label for="rom">Enter full rom name</label>
                <input id="rom" name="rom" type="text" class="rom" value="" />
            </p>
            <p>
                <label for="romid">Enter ROM OTA ID (as in build.prop)</label>
                <input id="romid" name="romid" type="text" class="rom" value="" />
            </p>
            <p>
                <label for="version">Enter ROM version (as in build.prop)</label>
                <input id="version" name="version" type="text" class="rom" value="" />
            </p>
            <p>
                <label for="date">Enter OTA date/time here (yyyymmdd-hhmm, as in build.prop).</label>
                <input id="date" name="date" type="text" class="rom" value="" />
            </p>
            <p>
                <label for="url">Enter download url.</label>
                <input id="url" name="url" type="text" class="rom" value="" />
            </p>
            <p>
                <label for="md5">Enter MD5 filehash.</label>
                <input id="md5" name="md5" type="text" class="rom" value="" />
            </p>
            <p>
                <label for="changelog">Enter Changelog here.</label>
                <textarea id="changelog" name="changelog" class="rom"></textarea>
            </p>
            <p>
                <label for="device">Enter devicename here.</label>
                <input id="device" name="device" type="text" class="rom" value="" />
            </p>
            <p>
                <button id="add_rom_submit" name="submit" type="submit">Add Rom</button>
            </p>
        </fieldset>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#add_rom_form label").inFieldLabels();
    });
</script>
