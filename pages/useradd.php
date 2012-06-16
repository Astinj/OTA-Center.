<?php
include 'safe_admin.php';
if (isset($_SESSION['user_id'])) {
    ?>

    <div id="registration">
        <h2>Add User</h2>

        <form id="AddUserForm" action="?page=useradd_ac" method="post">
            <fieldset>
                <p>
                    <label for="naam">Username</label>
                    <input id="rom" name="naam" type="text" class="rom" value="" />
                </p>
                <p>
                    <label for="wachtwoord">Password</label>
                    <input id="rom" name="wachtwoord" type="password" class="rom" value="changeme" />
                </p>
                <p>
                    <label for="status">Status</label>
                    <input id="rom" name="status" type="text" class="rom" value="0" />
                </p>
                <p>
                    <label for="email">Email</label>
                    <input id="rom" name="email" type="text" class="rom" value="" />
                </p>
                <p>
                    <label for="actief">Actief?</label>
                    <input id="rom" name="actief" type="text" class="rom" value="1" />
                </p>
                <p>
                    <label for="actcode">Activation code</label>
                    <textarea id="rom" name="actcode" class="rom"></textarea>
                </p>
                <p>
                    <button id="addUserNew" name="submit" type="submit">Add User</button>
                </p>
            </fieldset>

        </form>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#AddUserForm label").inFieldLabels();
        });
    </script>
    <?
} else {
    echo 'You are not logged in...';
}
?>
