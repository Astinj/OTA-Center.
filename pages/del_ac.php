<?php
// Connect to server and select database.
//mysql_connect("$db_host", "$db_user", "$db_pass")or die("cannot connect");
//mysql_select_db("$db_db")or die("cannot select DB");

$id = $_GET['id'];

$stmt = $db->stmt_init();
$stmt->prepare('SELECT `userid` FROM `roms` WHERE `id` = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($userid);
$stmt->fetch();
$stmt->close();

//$sql = "SELECT * FROM roms WHERE id = '".$id."'";
//$result=mysql_query($sql);
//$rows=mysql_fetch_array($result);

if (isset($_SESSION['user_id'])) {
    // update data in mysql database
    if (isset($rows['id'])) {
        if ($userid == $_SESSION['user_id']) {
            $stmt = $db->stmt_init();
            $stmt->prepare('DELETE FROM `roms` WHERE `id` = ?');
            $stmt->bind_param('i', $id);

            //$sql2="DELETE FROM roms WHERE  id='$id'";
            //$result=mysql_query($sql2);
            // if successfully updated.
            if ($stmt->execute()) {
                echo "Deleted Successfully";
                echo "<BR>";
                echo "<a href='?page=list-roms'>View result</a>";
            } else {
                echo "ERROR";
            }
            $stmt->close();
        } else {
            if ($_SESSION[user_status] == 1) {
                $stmt = $db->stmt_init();
                $stmt->prepare('DELETE FROM `roms` WHERE `id` = ?');
                $stmt->bind_param('i', $id);

                //$sql2="DELETE FROM roms WHERE  id='$id'";
                //$result=mysql_query($sql2);
                // if successfully updated.
                if ($stmt->execute()) {
                    echo "Deleted Successfully";
                    echo "<BR>";
                    echo "<a href='?page=list-roms'>View result</a>";
                } else {
                    echo "ERROR";
                }
                $stmt->close();
            } else {
                echo "You have no permission to delete roms added by anyone else";
                header("Location: ?page=list-roms");
                exit();
            }
        }
    } else {
        echo "This rom does not exist.";
        header("Location: ?page=list-roms");
        exit();
    }
} else {
    echo "You are not logged in...";
    header("Location: ?page=denied");
    exit();
}
?>
